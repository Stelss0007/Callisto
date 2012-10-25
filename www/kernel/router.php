<?php

class Router
  {

  // Хранит конфигурацию маршрутов.
  private $routes;
  private $fileExt = '.html';
  
  function __construct($routesPath)
    {
    // Получаем конфигурацию из файла.
    $this->routes = include($routesPath);
    }

  function curPageURL() {
    $pageURL = 'http';
    if ($_SERVER["HTTPS"] == "on") {$pageURL .= "s";}
    $pageURL .= "://";
    if ($_SERVER["SERVER_PORT"] != "80") {
      $pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
    } else {
      $pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
    }
    return $pageURL;
    }
 
    
  // Метод получает URI. Несколько вариантов представлены для надёжности.
  function getURI()
    {
    if (!empty($_SERVER['REQUEST_URI']))
      {
      return trim($_SERVER['REQUEST_URI'], '/');
      }

    if (!empty($_SERVER['PATH_INFO']))
      {
      return trim($_SERVER['PATH_INFO'], '/');
      }

    if (!empty($_SERVER['QUERY_STRING']))
      {
      return trim($_SERVER['QUERY_STRING'], '/');
      }
    }

  function run()
    {
    $fullURL = parse_url($_SERVER["REQUEST_URI"]);
    
    if($fullURL['path'] == '/' || $fullURL['path'] == '' || $fullURL['path'] == '/index.php')
      {
      $get_data =  $_GET;
      $mod = $get_data['module'];
      $action= $get_data['action'];
      
      unset($get_data['module']);
      unset($get_data['action']);
      
      $parameters = '';
      
      foreach($get_data as $key=>$value)
        {
        $parameters .='/'.$value;
        }
      $current_url = "/$mod/$action$parameters";
      
      if(!empty($this->fileExt))
        {
        $current_url .= $this->fileExt;
        }
        
      header("HTTP/1.1 302 Found");
      header("Location: $current_url");
      }
    else
      {
      if(!empty($this->fileExt))
        {
        $current_url = $fullURL['path'];
        if (!strstr($current_url, $this->fileExt))
          {
          $query = (!empty($fullURL['query'])) ? '?'.$fullURL['query'] : '';

          header("HTTP/1.1 302 Found");
          header("Location: $current_url$this->fileExt".$query);
          }
        }

      // Разбиваем внутренний путь на сегменты.
      $segments = explode('/', trim($fullURL['path'], '/'));
      // Первый сегмент — модуль.
      $mod = array_shift($segments);
      // Второй — действие.
      $action = str_replace($this->fileExt, '', array_shift($segments));
      
      if(empty($action))
        $action = 'default';
      // Остальные сегменты — параметры.
      $parameters = $segments;
      }

    if(!file_exists("modules/$mod/index.php"))
      trigger_error ("Module '".$mod."' or module controler not exist", E_USER_ERROR);

    include_once "modules/$mod/index.php";
    //$module = new $mod();
    $module = new Index($mod);
    
    $module->input_vars = array_merge($parameters, $module->input_vars);
    
    
    if(empty($_REQUEST['type']))
      $module->type = 'user';
    else  
      $module->type = ($_REQUEST['type'] == 'user' || $_REQUEST['type'] == 'admin'  || $_REQUEST['type'] == 'ajax') ? $_REQUEST['type'] : 'user';

    $module->action($action);

    exit; 
 

    // Ничего не применилось. 404.
    header("HTTP/1.0 404 Not Found");
    exit;
    }

  }

?>
