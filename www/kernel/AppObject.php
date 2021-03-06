<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
use app\lib\UserSession\UserSession;

/**
 * Description of appObject
 *
 * @author Your Name <your.name at your.org>
 */
class AppObject
{
    /**
     * @var string
     */
    protected $message = '';

    /**
     * @var
     */
    protected $errors;

    /**
     * @var array
     */
    public $config = null;

    /**
     * @var string
     */
    public $theme;

    /**
     * @var UserSession
     */
    public $session;

    /**
     * @var array
     */
    protected $libs = [];

    /**
     * @var array
     */
    public static $models = [];

    /**
     * @var string
     */
    protected $modname;

    /**
     * @var array
     */
    public $pagination = [];


    final public function getCallingMethodName($position = 0, $with_args = false)
    {
        $e = new Exception();
        $trace = $e->getTrace();

        $position = $position ? $position : (count($trace) - 1);
        if (empty($with_args)) {
            return $trace[$position]['function'];
        }

        return ['function' => $trace[$position]['function'], 'args' => $trace[$position]['args']];
        appDebug($trace);
    }

    final public function allVarToTpl()
    {
        foreach ($this->vars as $name => $value) {
            $this->smarty->assign($name, $value, false);
        }
    }

    //////////////////////////////////////////////////////////////////////////////
    ////////////////////////////   MODELS     ////////////////////////////////////
    //////////////////////////////////////////////////////////////////////////////
    /*
     final public function usesModel($modulename=null, $autocreate=true)
       {
       return;
       switch ($modulename) {
           case 'Users':
           case 'Groups':
           case 'Permissions':
           case 'Configuration':
           case 'Theme':
           case 'Blocks':
           case 'Menu':
           case 'Main':
           case 'Comments':
           case 'comments':
           case 'payments':
           case 'Modules':
               return;
       }

       //echo $this->modname;exit;
       $modelname = (!empty($modulename)) ? $modulename : $this->modname;
       $modulename = (!empty($modulename)) ? $modulename : $this->modname;

       $usedResult = appUsesModel($modulename);
       //require_once 'modules/'.$modulename.'/class.php';

       $className = $modulename;

       if(!$autocreate)
         return new $className($className);

       $this->$modelname = new $className($className);
       $this->$modelname->type = $modulename;

       //$this->$modelname->session = & $this->session;

       //echo $modelname;
       //print_r(get_class_methods($this->$modelname));
       if(!empty($usedResult) && is_array($usedResult))
         $this->models[] = key($usedResult)." ({$usedResult[key($usedResult)]})";

       return $this->$modelname;
       }

     final public function usesModule($modulename=null, $autocreate=true)
       {
       return;
       $models = appUsesModule($modulename);

       if($autocreate)
         {
         foreach($models as $model=>$src)
           {

           switch ($model) {
               case 'Users':
               case 'Groups':
               case 'Permissions':
               case 'Configuration':
               case 'Theme':
               case 'Blocks':
               case 'Menu':
               case 'Main':
               case 'Comments':
               case 'UserBankInfo':
               case 'Modules':
               case 'Articles':
               case 'ArticleCategory':
                   return;
                   break;
           }

           $this->$model = new $model($model);
           $this->$model->type = 'user';

           //$this->$model->session = & $this->session;

           //echo $modelname;
           //print_r(get_class_methods($this->$modelname));
           $this->models[] =$model." ({$src})";
           }
         }
       return true;
       }
     *
     */

    final public static function addModelList($namespace, $realPath)
    {
        self::$models[] = $namespace . " ({$realPath}.php)";
    }

    final public function arrayToModel(&$model, $array)
    {
        if (empty($array)) {
            return false;
        }
        foreach ($array as $key => $value) {
            $model->$key = $value;
        }
    }

    //////////////////////////////////////////////////////////////////////////////
    ////////////////////////////   LIB        ////////////////////////////////////
    //////////////////////////////////////////////////////////////////////////////
    final public function usesLib($libname = 'extlib', $autocreate = true, $file = false)
    {
        $file_src = appUsesLib($libname, $file);

        $className = $libname;

        $this->libs[] = $className . ' (' . $file_src . ')';

        $obj = new $className();

        if (empty($autocreate)) {
            return $obj;
        }

        $this->lib->$libname = $obj;

        return $this->lib->$libname;
    }

    public function getInput($input_var, $default = false)
    {
        if (!empty($_REQUEST[$input_var])) {
            return $_REQUEST[$input_var];
        }
        $session = app\lib\UserSession\UserSession::getInstance();

        return $session->getVar($input_var, $default);
    }

    public function setInput($input_var, $value = '')
    {
        $this->session->setVar($input_var, $value);

        return true;
    }

    //////////////////////////////////////////////////////////////////////////////
    ////////////////////////////   SESSIONS    ///////////////////////////////////
    //////////////////////////////////////////////////////////////////////////////
    final public function sessinInit()
    {
        $this->session = app\lib\UserSession\UserSession::getInstance();
        //$this->session = & new UserSession;
        //print_r(get_class_methods($this->$modelname));
    }
}

