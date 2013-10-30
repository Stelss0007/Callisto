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

      $SelectResult = mysql_select_db($this->Database, $this->Link_ID);
      if (!$SelectResult)
        {
        echo "������ ����������� "; die ('NOT CONNECT TO DB');
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
    global $coreConfig;

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
    
    if(!empty($coreConfig['debug.enabled']))
      {
      // ��������� ������� �����
      $current_time = microtime();
      // �������� ������� �� �����������
      $current_time = explode(" ",$current_time);
      // ���������� ������� � ������������
      $start_time = $current_time[1] + $current_time[0];
      }
 
    $result = mysql_query($valid_sql);
    
    
    if(!empty($coreConfig['debug.enabled']))
      {
      // �� ��, ��� � � 1 �����
      $current_time = microtime();
      $current_time = explode(" ",$current_time);
      $current_time = $current_time[1] + $current_time[0];

      // ��������� ����� ���������� �������
      $result_time = ($current_time - $start_time);
     
      $debug = Debuger::getInstance();
      
      $debug->mysql[] = array('query'=>  trim(preg_replace('!\s+!', ' ', $valid_sql)), 'exec_time'=>$result_time, 'result_count'=>mysql_num_rows($result));
      //print_r($debug->mysql);
      }
    
    if(mysql_error())
      {
      echo '������ �������:<br><pre>';
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

    //���������� �������
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
    else //����� ������� ���������� ��� ������ �������
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
      if ($value==='')
        continue;
      
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
    mysql_free_result($this->QueryResult);
    }

  }

?>
