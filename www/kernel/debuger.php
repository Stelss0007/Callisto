<?php

class Debuger
  {
  public $mysql = array();
  public $warnings = array();
  public $notices = array();
  public $debug_private_messages = '';
  
  static $instance;

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
    if(isAjax())
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
    global $appConfig;
    if(empty($appConfig['debug.enabled']))
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
    global $appConfig;
    if(empty($appConfig['debug.enabled']))
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
    echo '<script type="text/javascript">'.NL;
    echo $this->debug_private_messages;
    echo '</script>'.NL;
    }
    
  function startRenderPage()
    {
    if(isAjax())
      return;
    
    echo '<script type="text/javascript">'.NL.' var startRenderPage = new Date().getTime();'.NL.'</script>'.NL;
    }
  function endRenderPage()
    {
    if(isAjax())
      return;
    
    echo '<script type="text/javascript">'.NL.' window.onload = function() { var endRenderPage = new Date().getTime(); var timeRenderPage = (endRenderPage - startRenderPage)/1000; console.log("Time Render Page "+timeRenderPage+" sec")}'.NL.'</script>'.NL;
    }
  }

