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
    
    if(!$autocreate)
      return true;
    
    $className = $modulename;
    //$this->$modelname = & new $className($className);
    $this->$modelname = & new $className($className);
    $this->$modelname->type = $modulename;
    
    $this->$modelname->session = & $this->session;
    
    //echo $modelname;
    //print_r(get_class_methods($this->$modelname));
    $this->models[] = key($usedResult)." ({$usedResult[key($usedResult)]})";
    return $this->$modelname;
    }
  
  final public function arrayToModel(&$model, $array)
    {
    if(empty($array))
      return false;
    foreach($array as $key=>$value)
      {
      $model->$key = $value;
      }
    }
    
  //////////////////////////////////////////////////////////////////////////////
  ////////////////////////////   LIB        ////////////////////////////////////
  //////////////////////////////////////////////////////////////////////////////
  final public function usesLib($libname=null)
    {
    require_once 'lib/'.$libname.'/'.$libname.'.class.php';
    $className = $libname;
    $obj = & new $className();
    $this->lib->$libname = $obj;
    $this->libs[] = $className.' (lib/'.$libname.'/'.$libname.'.class.php)';
    return $obj;
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
