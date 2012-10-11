<?php
  /**
   * Helper function for smarty_cache_apc()
   * Checks whether a cached content has been expired by reading the content's header.
   *
   * @access  private
   * @param   string    $cache_content      the cached content
   * @return  boolean                       TRUE if cache has been expired, FALSE otherwise
   *
   * @see     smarty_cache_apc()
   */
  function _apc_hasexpired(&$cache_content)
    {
    $split      = explode("\n", $cache_content, 2);
    $attributes = unserialize($split[0]);
    if ($attributes['expires'] > 0 && time() > $attributes['expires'])
      return true;
    else
      return false;
    }

  /**
   * Smarty Cache Handler<br>
   * utilizing apc extension (http://apc.net/)<br>
   *
   * Name:     smarty_cache_apc<br>
   * Type:     Cache Handler<br>
   * Purpose:  Replacement for the file based cache handling of Smarty. smarty_cache_apc() is
   *           using Turck apc extension to minimize disk usage.
   * File:     cache.apc.php<br>
   * Date:     Dec 2, 2003<br>
   *
   * Usage Example<br>
   * <pre>
   * $smarty = new Smarty;
   * $smarty->cache_handler_func = 'smarty_cache_apc';
   * $smarty->caching = true;
   * $smarty->display('index.tpl');
   * </pre>
   *
   * @author   Ilya Berdinskikh
   *
   * @param    string   $action         Cache operation to perform ( read | write | clear )
   * @param    mixed    $smarty         Reference to an instance of Smarty
   * @param    string   $cache_content  Reference to cached contents
   * @param    string   $tpl_file       Template file name
   * @param    string   $cache_id       Cache identifier
   * @param    string   $compile_id     Compile identifier
   * @param    integer  $exp_time       Expiration time
   * @return   boolean                  TRUE on success, FALSE otherwise
   *
   * @link     http://apc.net/
   *           (apc homepage)
   * @link     http://smarty.net/manual/en/section.template.cache.handler.func.php
   *           (Smarty online manual)
   */
  function smarty_cache_apc($action, &$smarty, &$cache_content, $tpl_file=null, $cache_id=null, $compile_id=null, $exp_time=null)
    {
    if(!function_exists("apc_store"))
      {
      $smarty->trigger_error("cache_handler: PHP Extension \"apc\" (http://apc.net/HomeUk) not installed.");
      return false;
      }

    // Create unique cache id:
//    $apc_id  = 'smarty|'.$cache_id.'_'.$tpl_file;
    $apc_id  = 'smarty|'.$cache_id;

    switch ($action)
      {
      case 'read':
        // read cache from shared memory
        $cache_content = @gzuncompress(apc_fetch($apc_id));
//        print_r($apc_id);
        if (!is_null($cache_content) && _apc_hasexpired($cache_content))
          {
          // Cache has been expired so we clear it now by calling ourself with another parameter :)
          $cache_content = null;
          //apc_rm($apc_id);
          }

        $return = true;
        break;

      case 'write':
        // save cache to shared memory
        $current_time = time();
        //Почемуто не корректно передается $exp_time
        $exp_time = $current_time + $smarty->cache_lifetime;

        if (is_null($exp_time) || $exp_time < $current_time)
          {
          global $sysConfig;
          $ttl = $sysConfig['systpl.cache_lifetime'];;
          }
        else
          $ttl = $exp_time - $current_time;

        //Добавляем запись об id в MySql
        $sql = "INSERT INTO sys_cache_content
         									 (`cache_id`)
        						   VALUES
        						     ('".sysVarPrepForStore($cache_id)."')";
        global $dbg_sql_queries; $dbg_sql_queries[] = array('sql_query'=>$sql); sysDBQuery($sql);

        //Ложим инфу в apc
        $return = apc_store($apc_id, gzcompress($cache_content,8), $ttl);
        break;

      case 'clear':
        // clear cache info
        //$current_time = time();

        //Формируем список ключей для удаления
        //Блокируем таблицу на запись
        //$sql = "LOCK TABLES `sys_cache_content` READ;";
        //global $dbg_sql_queries; $dbg_sql_queries[] = array('sql_query'=>$sql); sysDBQuery($sql);
        //if (mysql_errno()!=0) sysException ('smarty_cache_apc', DATABASE_ERROR, mysql_error()."<br> $sql");

        //Выбираем ключи подлежащие удалению
        $sql = "SELECT * FROM `sys_cache_content` WHERE `cache_id` LIKE '".sysVarPrepForStore($cache_id)."%'";
        global $dbg_sql_queries; $dbg_sql_queries[] = array('sql_query'=>$sql); $mysql_result = sysDBQuery($sql);
        if (mysql_errno()!=0) sysException ('smarty_cache_apc', DATABASE_ERROR, mysql_error()."<br> $sql");
        //Удаляем ключи из apca
        $apc_keys = array();
        while ($row = mysql_fetch_assoc($mysql_result))
          {
          $apc_id  = 'smarty|'.$row['cache_id'];
          apc_delete($apc_id);
          }
        mysql_free_result($mysql_result);

        //Удаляем из mysql ключи удаленные из apca
        //$sql = "DELETE FROM `sys_cache_content` WHERE `cache_id` LIKE '".sysVarPrepForStore($cache_id)."%'";
        //global $dbg_sql_queries; $dbg_sql_queries[] = array('sql_query'=>$sql); $mysql_result = sysDBQuery($sql);
        //if (mysql_errno()!=0) sysException ('smarty_cache_apc', DATABASE_ERROR, mysql_error()."<br> $sql");

        //Снимаем блокировку
        //$sql = "UNLOCK TABLES";
        //global $dbg_sql_queries; $dbg_sql_queries[] = array('sql_query'=>$sql); sysDBQuery($sql);
        //if (mysql_errno()!=0) sysException ('smarty_cache_apc', DATABASE_ERROR, mysql_error()."<br> $sql");

        //Удаляем устаревшие ключи
        //if (rand(1,100)<=3)
        //  {
          //apc_gc();
        //  }

        $return = true;
        break;

      default:
        // error, unknown action
        $smarty->trigger_error("cache_handler: unknown action \"$action\"");
        $return = false;
        break;
      }
    return $return;
    }
?>
