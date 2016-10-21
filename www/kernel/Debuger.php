<?php

class Debuger
  {
  public $mysql = array();
  public $warnings = array();
  public $notices = array();
  public $debug_private_messages = '';
  
  static $instance;
  
  static $startTime;
  static $endTime;
  static $workTime;

  public static function debugMode()
    {
    if(static::$instance)
        {
        return true;
        }
        
    return false;
    }
    
  public static function start()
    {
    if(!self::debugMode())
        return;
    
    // Считываем текущее время
    $currentTime = microtime();
    // Отделяем секунды от миллисекунд
    $currentTime = explode(" ",$currentTime);
    // Складываем секунды и миллисекунды
    self::$startTime = $currentTime[1] + $currentTime[0];
    }
    
  public static function end()
    {
    if(!self::debugMode())
        return;
    
    // Считываем текущее время
    $currentTime = microtime();
    // Отделяем секунды от миллисекунд
    $currentTime = explode(" ",$currentTime);
    // Складываем секунды и миллисекунды
    self::$endTime = $currentTime[1] + $currentTime[0];
    
    self::$workTime = self::$endTime - self::$startTime;
    }
    
    public static function logMySQL($sgl, $result, $className = 'Unknown')
        {
        if(!self::debugMode())
            return;
        
        $debug = static::$instance;
        $debug->mysql[] = [
                            'query'=>  trim(preg_replace('!\s+!', ' ', $sgl)), 
                            'exec_time'=>self::$workTime, 
                            'result_count' => (!is_bool($result)) ? mysqli_num_rows($result) : 0,
                            'class' => $className,
                        ];
        }
        
        
        

    public static function getInstance()
       {
         if (empty(self::$instance))
          {
          self::$instance = new self;
          }
         return self::$instance;
       }
   
  function __construct()
    {
    if(appIsAjax())
      return;
    
    if (!defined("LOG")) define("LOG", 1);
    if (!defined("INFO")) define("INFO", 2);
    if (!defined("WARN")) define("WARN", 3);
    if (!defined("ERROR")) define("ERROR", 4);

    define("NL", "\r\n");
    echo '<script type="text/javascript">'.NL;

    /// Данный код предназначен для браузеров без консоли
    echo 'if (!window.console) console = {};';
    echo 'console.log = console.log || function(){};';
    echo 'console.warn = console.warn || function(){};';
    echo 'console.error = console.error || function(){};';
    echo 'console.info = console.info || function(){};';
    echo 'console.debug = console.debug || function(){};';
    echo '</script>';
    /// Конец секции для браузеров без консоли
    }

  function debug($name, $var = null, $type = LOG)
    {
    if(empty(\App::$config['debug.enabled']))
      return;

    echo '<script type="text/javascript">'.NL;
    $name = addslashes($name);
    switch ($type) 
      {
      case LOG:
        echo 'console.log("'.$name.'");'.NL;
        break;
      case INFO:
        echo 'console.info("'.$name.'");'.NL;
        break;
      case WARN:
        echo 'console.warn("'.$name.'");'.NL;
        break;
      case ERROR:
        echo 'console.error("'.$name.'");'.NL;
        break;
      }
    
    
    if (!empty($var))
      {
      if (is_object($var) || is_array($var))
        {
        $object = json_encode($var);
        echo 'var object'.preg_replace('~[^A-Z|0-9]~i', "_", $name).' = \''.str_replace("'", "\'", $object).'\';'.NL;
        echo 'var val'.preg_replace('~[^A-Z|0-9]~i', "_", $name).' = eval("(" + object'.preg_replace('~[^A-Z|0-9]~i', "_", $name).' + ")" );'.NL;
        switch ($type) 
          {
          case LOG:
            echo 'console.debug(val'.preg_replace('~[^A-Z|0-9]~i', "_", $name).');'.NL;
            break;
          case INFO:
            echo 'console.info(val'.preg_replace('~[^A-Z|0-9]~i', "_", $name).');'.NL;
            break;
          case WARN:
            echo 'console.warn(val'.preg_replace('~[^A-Z|0-9]~i', "_", $name).');'.NL;
            break;
          case ERROR:
            echo 'console.error(val'.preg_replace('~[^A-Z|0-9]~i', "_", $name).');'.NL;
            break;
          }
        }
      else
        {
        $var = trim(preg_replace('!\s+!', ' ', str_replace('\\','\\\\',$var)));
        
        switch ($type) 
          {
          case LOG:
            echo 'console.debug("'.str_replace('"', '\\"', $var).'");'.NL;
            break;
          case INFO:
            echo 'console.info("'.str_replace('"', '\\"', $var).'");'.NL;
            break;
          case WARN:
            echo 'console.warn("'.str_replace('"', '\\"', $var).'");'.NL;
            break;
          case ERROR:
            echo 'console.error("'.str_replace('"', '\\"', $var).'");'.NL;
            break;
          }
        }
      }
    echo '</script>'.NL;
    }
    
  function debugAdd($name, $var = null, $type = LOG)
    {
    if(empty(\App::$config['debug.enabled']))
      return;

    
    $name = addslashes($name);
    switch ($type) 
      {
      case LOG:
        $this->debug_private_messages .= 'console.log("'.$name.'");'.NL;
        break;
      case INFO:
        $this->debug_private_messages .=  'console.info("'.$name.'");'.NL;
        break;
      case WARN:
        $this->debug_private_messages .=  'console.warn("'.$name.'");'.NL;
        break;
      case ERROR:
        $this->debug_private_messages .=  'console.error("'.$name.'");'.NL;
        break;
      }
    
    
    if (!empty($var))
      {
      if (is_object($var) || is_array($var))
        {
        $object = json_encode($var);
        $this->debug_private_messages .=   'var object'.preg_replace('~[^A-Z|0-9]~i', "_", $name).' = \''.str_replace("'", "\'", $object).'\';'.NL;
        $this->debug_private_messages .=   'var val'.preg_replace('~[^A-Z|0-9]~i', "_", $name).' = eval("(" + object'.preg_replace('~[^A-Z|0-9]~i', "_", $name).' + ")" );'.NL;
        switch ($type) 
          {
          case LOG:
            $this->debug_private_messages .=  'console.debug(val'.preg_replace('~[^A-Z|0-9]~i', "_", $name).');'.NL;
            break;
          case INFO:
            $this->debug_private_messages .=  'console.info(val'.preg_replace('~[^A-Z|0-9]~i', "_", $name).');'.NL;
            break;
          case WARN:
            $this->debug_private_messages .=  'console.warn(val'.preg_replace('~[^A-Z|0-9]~i', "_", $name).');'.NL;
            break;
          case ERROR:
            $this->debug_private_messages .=  'console.error(val'.preg_replace('~[^A-Z|0-9]~i', "_", $name).');'.NL;
            break;
          }
        }
      else
        {
        $var = trim(preg_replace('!\s+!', ' ', str_replace('\\','\\\\',$var)));
        
        switch ($type) 
          {
          case LOG:
            $this->debug_private_messages .=  'console.debug("'.str_replace('"', '\\"', $var).'");'.NL;
            break;
          case INFO:
            $this->debug_private_messages .=  'console.info("'.str_replace('"', '\\"', $var).'");'.NL;
            break;
          case WARN:
            $this->debug_private_messages .=  'console.warn("'.str_replace('"', '\\"', $var).'");'.NL;
            break;
          case ERROR:
            $this->debug_private_messages .=  'console.error("'.str_replace('"', '\\"', $var).'");'.NL;
            break;
          }
        }
      }
    }
    
  function debugAddCreateGroup($group_name)
    {
    $this->debug_private_messages .=  'console.groupCollapsed("'.$group_name.'");'.NL;
    }
    
  function debugAddEndGroup()
    {
    $this->debug_private_messages .=  'console.groupEnd();'.NL;
    }
    
  function debugAddDir($obj)
    {
    appCp1251Utf8($obj);
    $object = json_encode($obj);
    
    $this->debug_private_messages .=   'console.dir('.$object.');'.NL;
    }
    
  function render()
    {
    $this->renderMySQL();
    
    echo '<script type="text/javascript">'.NL;
    echo $this->debug_private_messages;
    echo '</script>'.NL;
    }
   
  function renderMySQL()
    {
    $mysql_querys = array();
    $mysql_query_count = 0;
    $mysql_query_time = 0;
  
    foreach($this->mysql as $key=>$value)
        {
        $key_sufix = $key +1;
        $mysql_querys['query_'.$key_sufix] = $value;
        $mysql_query_count++;
        $mysql_query_time += $value['exec_time'];
        }
    $this->debugAddCreateGroup("MySQL ($mysql_query_count) $mysql_query_time sec");
    $this->debugAddDir($mysql_querys);
    $this->debugAddEndGroup();
    }
  function startRenderPage()
    {
    if(appIsAjax())
      return;
    
    echo '<script type="text/javascript">'.NL.' var startRenderPage = new Date().getTime();'.NL.'</script>'.NL;
    }
  function endRenderPage()
    {
    if(appIsAjax())
      return;
    
    echo '<script type="text/javascript">'.NL.' window.onload = function() { var endRenderPage = new Date().getTime(); var timeRenderPage = (endRenderPage - startRenderPage)/1000; console.log("Time Render Page "+timeRenderPage+" sec")}'.NL.'</script>'.NL;
    }
  }

