<?php

class Router
  {

  // Хранит конфигурацию маршрутов.
  private static  $routes = array();
  private $fileExt = '';
  
  function __construct($routesPath = 'config-router.php')
    {
    // Получаем конфигурацию из файла.
    $this->includeRotes();
    }

  function includeRotes()
    {
    $dir_handler = opendir('modules');
    while ($dir = readdir($dir_handler))
      {
      if ((is_dir("modules/$dir")) &&
                    ($dir != '.') &&
                    ($dir != '..') &&
                    ($dir != 'CVS') &&
                    (file_exists ("modules/$dir/router.php")))
        {
        include_once ("modules/$dir/router.php");
        }
      }
    closedir($dir_handler);
    }
    
  public static function add($template, $params)
    {
    self::$routes[] = array($template, $params);
    }
    
  function runModuleRoutes()
    {
    $fullURL = parse_url($_SERVER["REQUEST_URI"]);
    
    foreach(self::$routes as $route)
      {
      $mod = $route[1]['controller'];
      $action = $route[1]['action'];
      $type = $route[1]['type'];
      $pattern = str_replace("/", "\/", $route[0]);  
      $route_vars =array();
      $parameters = array();
      
      if(preg_match_all('/<(\w+):?(.*?)?>/',$pattern,$matches))
        {
        $tokens=array_combine($matches[1],$matches[2]);

        foreach($tokens as $name=>$value)
          {
          if($value==='')
            $value='[^\/]+';
          
          $tr["<$name:$value>"]="(?P<$name>$value)";
          $route_vars[] = $name;
          }
        $routePattern = strtr($pattern, $tr);
        }
      else
        {
        $routePattern = $pattern;
        }
        
      
      
      preg_match("/^$routePattern$/u", $fullURL['path'], $matches);
      
      if($matches)
        {
        if($matches['controller'])
          {
          $mod = $matches['controller'];
          unset($matches['controller']);
          }
        if($matches['action'])
          {
          $action = $matches['action'];
          unset($matches['action']);
          }

        foreach($route_vars as $var)
          {
          $parameters[$var] = $matches[$var];
          }   

        if($type == 'admin')
          {
          if(!file_exists("modules/$mod/admin.php"))
            {
            trigger_error ("Module '".$mod."' or module controller 'AdminController' not exist", E_USER_ERROR);
            }
          include_once "modules/$mod/admin.php";
          $module = new AdminController($mod);
          $module->controllerName = 'AdminController';
          $module->setViewType($type);
          }
        else
          {
          if(!file_exists("modules/$mod/index.php"))
            {
            trigger_error ("Module '".$mod."' or module controller 'IndexController' not exist", E_USER_ERROR);
            }
          include_once "modules/$mod/index.php";
          $module = new IndexController($mod);
          $module->controllerName = 'IndexController';
          $module->setViewType($type);
          }
               
        global $mod_controller;
        $mod_controller = $module;

        $module->input_vars = array_merge($parameters, $module->input_vars);

//        if(empty($_REQUEST['type']))
//          $module->type = 'user';
//        else  
//          $module->type = ($_REQUEST['type'] == 'user' || $_REQUEST['type'] == 'admin'  || $_REQUEST['type'] == 'ajax') ? $_REQUEST['type'] : 'user';

        $module->action($action);

        exit; 
        }
      }

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
    global $router_vars;
    
    $this->runModuleRoutes();
    
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
      if($mod == 'admin')
        {
        $type = 'admin';
        $mod = array_shift($segments);
        
        if(empty($mod))
          {
          header("HTTP/1.1 302 Found");
          header("Location: /admin/main");
          exit;
          }
        }
      // Второй — действие.
      $action = str_replace($this->fileExt, '', array_shift($segments));
      
      if(empty($action))
        $action = 'index';
      // Остальные сегменты — параметры.
      $parameters = $segments;
      }

    if($type)
      {
      if(!file_exists("modules/$mod/admin.php"))
        {
        trigger_error ("Module '".$mod."' or module controller 'AdminController' not exist", E_USER_ERROR);
        }
      include_once "modules/$mod/admin.php";
      $module = new AdminController($mod);
      $module->controllerName = 'AdminController';
      }
    else
      {
      if(!file_exists("modules/$mod/index.php"))
        {
        trigger_error ("Module '".$mod."' or module controller 'IndexController' not exist", E_USER_ERROR);
        }
      include_once "modules/$mod/index.php";
      $module = new IndexController($mod);
      $module->controllerName = 'IndexController';
      }
      
    global $mod_controller;
    $mod_controller = $module;
    
    $router_vars['type'] = $type; 
    $router_vars['module'] = $mod; 
    $router_vars['action'] = $action; 
    
    $module->input_vars = array_merge($parameters, $module->input_vars);
    
    if($type)
      {
      $module->type = $type;
      }
    elseif(empty($_REQUEST['type']))
      {
      $module->type = 'user';
      }
    else
      {
      $module->type = ($_REQUEST['type'] == 'user' || $_REQUEST['type'] == 'admin'  || $_REQUEST['type'] == 'ajax') ? $_REQUEST['type'] : 'user';
      }
    
    $module->action($action);

    exit; 
 

    // Ничего не применилось. 404.
    header("HTTP/1.0 404 Not Found");
    exit;
    }

  }

?>
