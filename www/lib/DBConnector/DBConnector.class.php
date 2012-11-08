<?php

class DBConnector
  {

  var $Host = '';
  var $Database = '';
  var $User = '';
  var $Password = '';
  var $Error = "";
  var $Link_ID = null;
  var $QueryResult = null;

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

  function query()
    {
    global $coreConfig;

    $args = func_get_args();
    $template = array_shift($args);
    foreach ($args as $key => $value)
      {
      if (!get_magic_quotes_runtime())
        $args[$key] = mysql_real_escape_string($value);

      $args[$key] = addslashes(str_replace("\\r\\n",' ',$args[$key]));
      }
    $valid_sql = vsprintf($template, array_values($args));
    
    if(!empty($coreConfig['debug.enabled']))
      $debug_start_time = time();
    
    $result = mysql_query($valid_sql);
    
    if(!empty($coreConfig['debug.enabled']))
      $debug_start_time = time();
    
    if(mysql_error())
      {
      echo 'Ошибка запроса:<br><pre>';
      print_r(mysql_error());
      echo '</pre>';
      exit;
      }
    return $this->QueryResult = $result;
    }

  function fetch_object()
    {
    return mysql_fetch_object($this->QueryResult);
    }

  function fetch_array($type=1)
    {
    while ($row = mysql_fetch_array($this->QueryResult, $type))
      {
      foreach ($row as $key => $value)
        {
        $row[$key] = stripslashes($value);
        }
      $result[] = $row;
      }
      
    return $result;
    }

  function num_rows()
    {
    return mysql_num_rows($this->QueryResult);
    }

  function insert($table, $array)
    {
    $sql = 'SHOW COLUMNS FROM '.$table;
    $this->query($sql);
    $result = $this->fetch_array();
    
    $columns = array();
    foreach ($result as $value)
      {
      $columns[] = $value['Field'];
      }
    
    $keys = '';
    $values = '';

    foreach($array as $key=>$value)
      {
      if (!$value)
        continue;
      if(!in_array($key, $columns))
        continue;

      $keys .= $key.',';

      if (!get_magic_quotes_runtime())
        $value = mysql_real_escape_string($value);

      $value = addslashes(str_replace("\\r\\n",'<br>',$value));

      $values .=  "'".$value."',";
      }
      $values = rtrim($values, ',');
      $keys = rtrim($keys, ',');

      $sql = "INSERT INTO $table ($keys) VALUES ($values)";
      $this->query($sql);

      return mysql_insert_id();
    }


  function update($table, $array, $where)
    {
    $where = 'WHERE '.str_ireplace('where', '', $where);
    $sql = 'SHOW COLUMNS FROM '.$table;
    $this->query($sql);
    $result = $this->fetch_array();

    $columns = array();
    foreach ($result as $value)
      {
      $columns[] = $value['Field'];
      }

    $keys = '';
    $values = '';

    foreach($array as $key=>$value)
      {
      if (!$value)
        continue;
      if(!in_array($key, $columns))
        continue;

      $keys .= $key." = ";

      if (!get_magic_quotes_runtime())
        $value = mysql_real_escape_string($value);

      $value = addslashes(str_replace("\\r\\n",'<br>',$value));

      $keys .=  "'".$value."',";
      }
      
      $keys = rtrim($keys, ',');

      $sql = "UPDATE $table SET $keys $where";

      $this->query($sql);
    }

  }

?>
