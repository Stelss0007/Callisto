<?php // 
// function getAccess($obj_name, $level)
//   {
//   $ses_info=UserSession::getInstance();
//   $gid = $ses_info->userGid();
//   $perms_list = groupPermsGetList($gid);
//  
//   if(empty($perms_list))
//     return false;
//   
//   foreach($perms_list as $key=>$permission)
//     {
//     $pattern = "/$permission[pattern]/Ui";
//     if(preg_match($pattern, $obj_name))
//       {
//       if($level<=$permission['level'])
//         {
//         //print_r($perms_list[$key]);
//         return true;
//         }
//       return false;
//       }
//     }
//   return false;
//   }
//
///*
//   * Информация о правах групп
//  */
//  function groupPermsGetList($gid=null)
//    {
//    $db=DBConnector::getInstance();
//    $db->query("SELECT * FROM group_permission WHERE gid='%d' ORDER BY group_permission_weight", $gid);
//    $perms_list = $db->fetch_array();
//
//    return $perms_list;
//    }
//
//  /*
//   * Информация о правах группы
//  */
//  function groupPermsGetInfo($id)
//    {
//    $groups_perms_table = sysDBGetTable('groups_perms');
//    $groups_perms_column = sysDBGetColumns($groups_perms_table);
//    $info = sysDbSelect ($groups_perms_table, $groups_perms_column, "WHERE $groups_perms_column[id]='$id'");
//    return ($info);
//    }
//
//  /*
//   * Возврашает ассоциативный массив уровень прав->  Человеческое название
//  */
//  function permsLevelGetList()
//    {
//    $levels_list[ACCESS_NONE]='NONE';
//    $levels_list[ACCESS_OVERVIEW]='OVERVIEW';
//    $levels_list[ACCESS_READ]='READ';
//    $levels_list[ACCESS_COMMENT]='COMMENT';
//    $levels_list[ACCESS_ADD]='ADD';
//    $levels_list[ACCESS_EDIT]='EDIT';
//    $levels_list[ACCESS_DELETE]='DELETE';
//    $levels_list[ACCESS_ADMIN]='ADMIN';
//    return ($levels_list);
//    }
//
//  /*
//  * Создает права группы
//  */
//  function groupPermsCreate($args)
//    {
//    //Делаем вставку информаии в базу
//    $groups_perms_table = sysDBGetTable('groups_perms');
//    $groups_perms_column = sysDBGetColumns($groups_perms_table);
//
//    //Находим и задаем самый большой вес
//    $MaxWeight = appDbMaxWeight ($groups_perms_table);
//    $MaxWeight++;
//    $args ['weight'] = $MaxWeight;
//
//    sysDbInsert ($groups_perms_table, $args);
//    //Очищаем кеш прав доступа
//    appVarDelCached('kernel', 'sec_levels');
//    return (mysql_insert_id());
//    }
//
//  /*
//   * Внесение изменений в базу данных
//  */
//  function groupPermsUpdate($args)
//    {
//    $groups_perms_table = appDBGetTable('groups_perms');
//    $groups_perms_column = appDBGetColumns($groups_perms_table);
//    //Добавляем элимент в базу.
//    unset ($args ['weight']);//Подстраховка
//    appDbUpdate ($groups_perms_table, $args, "WHERE $groups_perms_column[id]='$args[id]'");
//    //Очищаем кеш прав доступа группы
//    appVarDelCached('kernel', 'sec_levels');
//    return true;
//    }
//
//  /*
//   * Удаление праила группв
//  */
//  function groupPermsDelete($id)
//    {
//    sysExtLibLoad();
//    $dbdata = $this->groups_perms_get_info ($id);
//    //Удаление
//    $groups_perms_table = appDBGetTable('groups_perms');
//    $groups_perms_column = appDBGetColumns($groups_perms_table);
//    appDbDelete ($groups_perms_table, "WHERE $groups_perms_column[id]='$id'");
//    appDbWeightDelete ($groups_perms_table, $dbdata['weight'],'');
//    //Очищаем кеш прав доступа группы
//    appVarDelCached('kernel', 'sec_levels');
//    return true;
//    }
//
//  /*
//   * Увеличение вес правила группы
//  */
//  function groupPermsMoveUp($id)
//    {
//    sysExtLibLoad();
//    $groups_perms_table = sysDBGetTable('groups_perms');
//    $groups_perms_column = sysDBGetColumns($groups_perms_table);
//    $dbdata = $this->groups_perms_get_info ($id);
//
//    appDbWeightMoveUp ($groups_perms_table, $dbdata['weight']);
//
//    appVarDelCached('kernel', 'sec_levels');
//    return true;
//    }
//
//  /*
//   * Уменьшыли вес правила группы
//  */
//  function groupPermsMoveDown($id)
//    {
//    sysExtLibLoad();
//    $groups_perms_table = sysDBGetTable('groups_perms');
//    $groups_perms_column = sysDBGetColumns($groups_perms_table);
//    $dbdata = $this->groups_perms_get_info ($id);
//
//    appDbWeightMoveDown ($groups_perms_table, $dbdata['weight']);
//
//    appVarDelCached('kernel', 'sec_levels');
//    return true;
//    }


