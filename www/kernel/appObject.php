<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of appObject
 *
 * @author Your Name <your.name at your.org>
 */
class AppObject
  {
  private   $message = '';
  private   $errors;
  //private   $module_dir;
  //private   $vars = array();
  public    $config = null;
  public    $theme;
  public    $session;
  protected $libs = array();
  public   $models = array();
  protected $modname;
  
 
  final public function GetCallingMethodName($position = null, $with_args = false)
    {
    $e = new Exception();
    $trace = $e->getTrace();
    
    $position = ($position) ? $position : (sizeof($trace)-1);
    if(empty($with_args))
      return $trace[$position]['function'];
    
    return array('function'=>$trace[$position]['function'], 'args' => $trace[$position]['args']);
    print_r($trace);
    }
    
  final public function allVarToTpl()
    {
    foreach ($this->vars as $name => $value)
      {
      $this->smarty->assign($name, $value, false);
      }
    }
    
  //////////////////////////////////////////////////////////////////////////////
  ////////////////////////////   MODELS     ////////////////////////////////////
  //////////////////////////////////////////////////////////////////////////////
  final public function usesModel($modulename=null, $autocreate=true)
    {
    //echo $this->modname;exit;
    $modelname = (!empty($modulename)) ? $modulename : $this->modname; 
    $modulename = (!empty($modulename)) ? $modulename : $this->modname; 
    
    $usedResult = appUsesModel($modulename);
    //require_once 'modules/'.$modulename.'/class.php';
    
    $className = $modulename;
    
    if(!$autocreate)
      return new $className($className);
  
    //$this->$modelname = & new $className($className);
    $this->$modelname = & new $className($className);
    $this->$modelname->type = 'user';//$modulename;
    
    $this->$modelname->session = & $this->session;
    
    //echo $modelname;
    //print_r(get_class_methods($this->$modelname));
    $this->models[] = key($usedResult)." ({$usedResult[key($usedResult)]})";
    return $this->$modelname;
    }
    
  final public function usesModule($modulename=null, $autocreate=true)
    {
    $models = appUsesModule($modulename);
    if($autocreate)
      {
      foreach($models as $model=>$src)
        {
        $this->$model = & new $model($model);
        $this->$model->type = 'user';

        $this->$model->session = & $this->session;

        //echo $modelname;
        //print_r(get_class_methods($this->$modelname));
        $this->models[] =$model." ({$src})";
        }
      }
    return true;
    }
    
  final public function arrayToModel(&$model, $array)
    {
    if(empty($array))
      {
      return false;
      }
    foreach($array as $key=>$value)
      {
      $model->$key = $value;
      }
    }
    
  //////////////////////////////////////////////////////////////////////////////
  ////////////////////////////   LIB        ////////////////////////////////////
  //////////////////////////////////////////////////////////////////////////////
  final public function usesLib($libname = 'extlib', $autocreate=true, $file=false)
    {
    $file_src = appUsesLib($libname, $file);
       
    $className = $libname;
    
    $this->libs[] = $className.' ('.$file_src.')';

    $obj = & new $className();
    
    if(empty($autocreate))
      return $obj;
      
    $this->lib->$libname = $obj;
    
    return $this->lib->$libname;
    }  
    
  //////////////////////////////////////////////////////////////////////////////
  ////////////////////////////   SESSIONS    ///////////////////////////////////
  //////////////////////////////////////////////////////////////////////////////
  final public function sessinInit()
    {
    $this->session = & new UserSession;
    //print_r(get_class_methods($this->$modelname));
    }
}
?>