<?php
class App {
    public static $config = [];
    public static $global = [];
    
    private static function initAutoloader()
    {
        spl_autoload_register(function ($class) {
            $namespace = $class;

            $class = explode('\\', $class);

            if(!isset($class[0]) || $class[0] != 'app') {
                return;
            }
            unset($class[0]);

            if($class[1] == 'lib') {
                $class = implode('/', $class);
                $class = $class.'.class.php';
                echo $class; 
                exit;
                include $class;
                return true;
            }

            $class = implode('/', $class);    
            include $class.'.php';
            AppObject::addModelList($namespace, $class);
        });
    }


    public static function init() 
    {
        self::initAutoloader();
        self::$config = include 'kernel/Config.php';
    }
}

