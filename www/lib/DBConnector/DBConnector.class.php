<?php

class DBConnector extends AppObject
  {

  var $Host = '';
  var $Database = '';
  var $User = '';
  var $Password = '';
  var $Error = "";
  var $Link_ID = null;
  var $QueryResult = null;
  
  var $debug_array = array();

  static $instance;

  public static function getInstance()
   {
     if (empty(self::$instance))
      {
      self::$instance = new self;
      }
     return self::$instance;
   }

  function connect()
    {
    //echo "pass=".$this->Password;exit;
    global $DBType;
    if ($this->Link_ID == 0)
      {
      $this->Link_ID = mysql_connect($this->Host,
                      $this->User,
                      $this->Password);
      mysql_set_charset('cp1251', $this->Link_ID);
      //mysql_query("SET character_set_results = 'utf8', character_set_client = 'utf8', character_set_connection = 'utf8', character_set_database = 'utf8', character_set_server = 'utf8'", $this->Link_ID);
      $SelectResult = mysql_select_db($this->Database, $this->Link_ID);
      if (!$SelectResult)
        {
        echo "Ошибка подключения "; die ('NOT CONNECT TO DB');
        }
      }
    }
    
  function disconect()
    {
    //mysql_close();
    }

  function prepareValue($value)
    {
    if(is_array($value))
      {
      foreach($value as $k=>$v)
        {
        if (!get_magic_quotes_runtime())
          {
          $value[$k] = mysql_real_escape_string($value[$k]);
          }
        if(!get_magic_quotes_gpc())
          {
          $value[$k] = addslashes($value[$k]);
          }

        $value[$k] = str_replace("\\r\\n",'<br>', $value[$k]);
        }
      }
    else
      {
      if (!get_magic_quotes_runtime())
        {
        $value = mysql_real_escape_string($value);
        }
      if(!get_magic_quotes_gpc())
        {
        $value = addslashes($value);
        }

      $value = str_replace("\\r\\n",'<br>', $value);
      }

    
    return $value;
    }
 
  function query()
    {
    global $appConfig;

    $args = func_get_args();
    $template = array_shift($args);
    foreach ($args as $key => $value)
      {
      if (!get_magic_quotes_runtime())
        $args[$key] = mysql_real_escape_string($value);

      $args[$key] = addslashes(str_replace("\\r\\n",' ',$args[$key]));
      }
      
    if($args) 
      {
      $valid_sql = vsprintf($template, array_values($args));
      }
    else
      {
      $valid_sql = $template;
      }
    
    if(!empty($appConfig['debug.enabled']))
      {
      // Считываем текущее время
      $current_time = microtime();
      // Отделяем секунды от миллисекунд
      $current_time = explode(" ",$current_time);
      // Складываем секунды и миллисекунды
      $start_time = $current_time[1] + $current_time[0];
      }
 
    $result = mysql_query($valid_sql);
    
    
    if(!empty($appConfig['debug.enabled']))
      {
      // То же, что и в 1 части
      $current_time = microtime();
      $current_time = explode(" ",$current_time);
      $current_time = $current_time[1] + $current_time[0];

      // Вычисляем время выполнения скрипта
      $result_time = ($current_time - $start_time);
     
      $debug = Debuger::getInstance();
      
      $debug->mysql[] = array('query'=>  trim(preg_replace('!\s+!', ' ', $valid_sql)), 'exec_time'=>$result_time, 'result_count'=>mysql_num_rows($result));
      //print_r($debug->mysql);
      }
    
    if(mysql_error())
      {
      echo 'Ошибка запроса:<br><pre>';
      echo '<b>'.$valid_sql.'</b>'.'<br><br>';
      echo '<font color="red">';
      print_r(mysql_error());
      echo '</font>';
      echo '</pre>';
      exit;
      }
    $this->QueryResult = $result;
    unset($result);
    }

    
  final function select($table, $column=array(), $where='', $multi = false, $join='', $field_is_index = false)
    {
    if(is_array($column))
      {
      $columns_string = implode(', ', $column);
      }
    else
      {
      $columns_string = $column;
      }
      
    if (empty ($columns_string)) 
      $columns_string = '*';

    //Производим выборку
    $sql = "SELECT $columns_string
              FROM $table
              $join
              $where";
    
    if (!$multi) $sql.= ' LIMIT 1';
//echo $sql;
    $this->query($sql);

    //RESULT
    if (!$multi)
      {
      return $this->fetch_row();
      }
    else //Много записей возвращаем как массив масивов
      {
      return $this->fetch_array(1, $field_is_index);
      }
    }
  
  
  function fetch_object()
    {
    return mysql_fetch_object($this->QueryResult);
    }
    
  function fetch_row()
    {
    return mysql_fetch_array($this->QueryResult);
    }

  function fetch_array($type=1, $field_is_index = false)
    {
    $result = array();
    while ($row = mysql_fetch_array($this->QueryResult, $type))
      {
      foreach ($row as $key => $value)
        {
        $row[$key] = stripslashes($value);
        }
      if($field_is_index)
        $result[$row[$field_is_index]][] = $row;
      else  
        $result[] = $row;
      }
      
    return $result;
    }

  function num_rows()
    {
    return mysql_num_rows($this->QueryResult);
    }

  function getFields($table)
    {
    if(appVarIsCached('dbTableFields', $table))
      {
      return appVarGetCached('dbTableFields', $table);
      }
    
    $sql = 'SHOW COLUMNS FROM '.$table;
    $this->query($sql);
    $result = $this->fetch_array();
    
    $columns = array();
    foreach ($result as $value)
      {
      $columns[] = $value['Field'];
      }
    appVarSetCached('dbTableFields', $table, $columns);
    
    return $columns;
    }
    
  function hasTableField($table, $field)
    {
    if(is_array($field))
      {
      $table_fields = $this->getFields($table);
      foreach($field as $value)
        {
        if(in_array($value, $table_fields, true))
          return $value;
        }
      return false;
      }
    else
      {
      return in_array($field, $this->getFields($table), true);
      }
    }
    
  function insert($table, $array)
    {
    $columns = $this->getFields($table);
    $keys = '';
    $values = '';

    foreach($array as $key=>$value)
      {
      if ($value === '')
        continue;
      
      if(!in_array($key, $columns))
        continue;

      $keys .= $key.',';

      $value = $this->prepareValue($value);

      $values .=  "'".$value."',";
      }
      $values = rtrim($values, ',');
      $keys = rtrim($keys, ',');

      $sql = "INSERT INTO $table ($keys) VALUES ($values)";
      $this->query($sql);

      return mysql_insert_id();
    }


  function update($table, $array, $where = '1=1')
    {
    if(empty($where))
      $where = '1 = 1';
    $where = 'WHERE '.str_ireplace('where', '', $where);
    
    $columns = $this->getFields($table);

    $keys = '';
    $values = '';

    foreach($array as $key=>$value)
      {
//      if ($value==='')
//        continue;
      
      if(!in_array($key, $columns, true))
        continue;

      $keys .= $key." = ";

      $value = $this->prepareValue($value);

      $keys .=  "'".$value."',";
      }
      
      $keys = rtrim($keys, ',');

      $sql = "UPDATE $table SET $keys $where";

      $this->query($sql);
    }
    
  function __destruct() 
    {
    if(isset($this->QueryResult) && !empty($this->QueryResult))
      mysql_free_result($this->QueryResult);
    }

  }

?>
