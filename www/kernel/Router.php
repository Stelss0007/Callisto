<?php

class Router
{
    /**
     * Хранит конфигурацию маршрутов.
     *
     * @var array
     */
    private static $routes = [];

    /**
     * @var string
     */
    private $fileExt = '';

    /**
     * @param string $routesPath
     */
    public function __construct($routesPath = 'config-router.php')
    {
        // Получаем конфигурацию из файла.
        \App::$global['route.module'] = '';
        \App::$global['route.type'] = '';
        \App::$global['route.action'] = '';

        $this->includeRoutes();
    }

    public function includeRoutes()
    {
        $dir_handler = opendir('modules');
        while ($dir = readdir($dir_handler)) {
            if ((is_dir("modules/$dir")) &&
                ($dir !== '.') &&
                ($dir !== '..') &&
                ($dir !== 'CVS') &&
                (file_exists("modules/$dir/router.php"))
            ) {
                include_once("modules/$dir/router.php");
            }
        }
        closedir($dir_handler);
    }

    public static function add($template, $params)
    {
        self::$routes[] = [$template, $params];
    }

    public function runModuleRoutes()
    {
        $fullURL = parse_url($_SERVER['REQUEST_URI']);

        foreach (self::$routes as $route) {
            $mod = $route[1]['controller'];
            $action = $route[1]['action'];
            $type = $route[1]['type'];
            $pattern = str_replace('/', '\/', $route[0]);
            $route_vars = [];
            $parameters = [];

            if (preg_match_all('/<(\w+):?(.*?)?>/', $pattern, $matches)) {
                $tokens = array_combine($matches[1], $matches[2]);

                foreach ($tokens as $name => $value) {
                    if ($value === '') {
                        $value = '[^\/]+';
                    }

                    $tr["<$name:$value>"] = "(?P<$name>$value)";
                    $route_vars[] = $name;
                }
                $routePattern = strtr($pattern, $tr);
            } else {
                $routePattern = $pattern;
            }


            preg_match("/^$routePattern$/u", $fullURL['path'], $matches);

            if ($matches) {
                if (isset($matches['controller']) && $matches['controller']) {
                    $mod = $matches['controller'];
                    unset($matches['controller']);
                }
                if (isset($matches['action']) && $matches['action']) {
                    $action = $matches['action'];
                    unset($matches['action']);
                }

                foreach ($route_vars as $var) {
                    $parameters[$var] = $matches[$var];
                }

                if ($type === 'admin') {
                    if (!file_exists("modules/$mod/admin.php")) {
                        trigger_error(
                            "Module '" . $mod . "' or module controller 'AdminController' not exist",
                            E_USER_ERROR
                        );
                    }
                    include_once "modules/$mod/admin.php";
                    $module = new AdminController($mod);
                    $module->controllerName = 'AdminController';
                    $module->setViewType($type);
                } else {
                    if (!file_exists("modules/$mod/index.php")) {
                        trigger_error(
                            "Module '" . $mod . "' or module controller 'IndexController' not exist",
                            E_USER_ERROR
                        );
                    }
                    include_once "modules/$mod/index.php";
                    $module = new IndexController($mod);
                    $module->controllerName = 'IndexController';
                    $module->setViewType($type);
                }

                global $mod_controller;
                $mod_controller = $module;

                $module->inputVars = array_merge($parameters, $module->inputVars);
                $module->action($action);
                exit;
            }
        }

    }

    public function curPageURL()
    {
        $pageURL = 'http';
        if ($_SERVER["HTTPS"] == "on") {
            $pageURL .= "s";
        }
        $pageURL .= "://";
        if ($_SERVER["SERVER_PORT"] !== "80") {
            $pageURL .= $_SERVER["SERVER_NAME"] . ":" . $_SERVER["SERVER_PORT"] . $_SERVER["REQUEST_URI"];
        } else {
            $pageURL .= $_SERVER["SERVER_NAME"] . $_SERVER["REQUEST_URI"];
        }

        return $pageURL;
    }


    // Метод получает URI. Несколько вариантов представлены для надёжности.
    public function getURI()
    {
        if (!empty($_SERVER['REQUEST_URI'])) {
            return trim($_SERVER['REQUEST_URI'], '/');
        }

        if (!empty($_SERVER['PATH_INFO'])) {
            return trim($_SERVER['PATH_INFO'], '/');
        }

        if (!empty($_SERVER['QUERY_STRING'])) {
            return trim($_SERVER['QUERY_STRING'], '/');
        }
    }

    public function run()
    {
        $type = '';

        $this->runModuleRoutes();

        $fullURL = parse_url($_SERVER["REQUEST_URI"]);

//    if($fullURL['path'] == '/' || $fullURL['path'] == '' || $fullURL['path'] == '/index.php')
        if ($fullURL['path'] == '/index.php') {
            $get_data = $_GET;
            $mod = $get_data['module'];
            $action = $get_data['action'];

            unset($get_data['module']);
            unset($get_data['action']);

            $parameters = '';

            foreach ($get_data as $key => $value) {
                $parameters .= '/' . $value;
            }
            $current_url = "/$mod/$action$parameters";

            if (!empty($this->fileExt)) {
                $current_url .= $this->fileExt;
            }

            header("HTTP/1.1 302 Found");
            header("Location: $current_url");
        } else {
            if (!empty($this->fileExt)) {
                $current_url = $fullURL['path'];
                if (!strstr($current_url, $this->fileExt)) {
                    $query = (!empty($fullURL['query'])) ? '?' . $fullURL['query'] : '';

                    header("HTTP/1.1 302 Found");
                    header("Location: $current_url$this->fileExt" . $query);
                }
            }

            // Разбиваем внутренний путь на сегменты.
            $segments = explode('/', trim($fullURL['path'], '/'));
            // Первый сегмент — модуль.
            $mod = array_shift($segments);
            //if($mod == 'admin')
            if ($mod == \App::$config['admin.path']) {
                $type = 'admin';
                $mod = array_shift($segments);

                if (empty($mod)) {
                    header('HTTP/1.1 302 Found');
                    header('Location: /' . \App::$config['admin.path'] . '/main');
                    exit;
                }
            } elseif ($mod == 'api') {
                $type = 'api';
                $mod = array_shift($segments);
            }

            // Второй — действие.
            $action = str_replace($this->fileExt, '', array_shift($segments));

            if (empty($action)) {
                $action = 'index';
            }
            // Остальные сегменты — параметры.
            $parameters = $segments;
        }


        \App::$global['route.type'] = $type;

        if ($type === 'admin') {
            if (!file_exists("modules/$mod/admin.php")) {
                trigger_error("Module '" . $mod . "' or module controller 'AdminController' not exist", E_USER_ERROR);
            }
            include_once "modules/$mod/admin.php";
            $module = new AdminController($mod);
            $module->controllerName = 'AdminController';
        } elseif ($type === 'api') {
            if (!file_exists("modules/$mod/api.php")) {
                trigger_error("Module '" . $mod . "' or module controller 'APIController' not exist", E_USER_ERROR);
            }
            include_once "modules/$mod/api.php";
            $module = new APIController($mod);
            $module->controllerName = 'APIController';
        } else {
            if (empty($mod)) {
                $mod = 'main';
            }

            if (!file_exists("modules/$mod/index.php")) {
                trigger_error("Module '" . $mod . "' or module controller 'IndexController' not exist", E_USER_ERROR);
            }
            include_once "modules/$mod/index.php";
            $module = new IndexController($mod);
            $module->controllerName = 'IndexController';
        }

        global $mod_controller;
        $mod_controller = $module;


        \App::$global['route.module'] = $mod;
        \App::$global['route.action'] = $action;

        $module->inputVars = array_merge($parameters, $module->inputVars);

        if ($type) {
            $module->type = $type;
        } elseif (empty($_REQUEST['type'])) {
            $module->type = 'user';
        } else {
            $module->type = ($_REQUEST['type'] == 'user' || $_REQUEST['type'] == 'admin' || $_REQUEST['type'] == 'api') ? $_REQUEST['type'] : 'user';
        }

        if ($type == 'api') {
            header('Access-Control-Allow-Origin: ' . $_SERVER['HTTP_ORIGIN']);
            echo json_encode($module->action($action));
            exit;
        }

        $module->action($action);

        exit;


        // Ничего не применилось. 404.
        header("HTTP/1.0 404 Not Found");
        exit;
    }

}

