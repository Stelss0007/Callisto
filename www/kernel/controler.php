<?php

abstract class Controller
  {
  protected $errors;
  protected $registry;
  protected $smarty;
  protected $module_dir;
  public    $root_dir;
  protected $theme;
  protected $vars = array();
  protected $modname;
  protected $object_name;
  protected $type;
  protected $action;
  protected $input_vars = array();
  protected $input_vars_clear = array();
  
  protected $page = 'index';
  
  protected $block = array(
                          'top'   =>array(),
                          'left'  =>array(),
                          'center'=>array(),
                          'right' =>array(),
                          'bottom'=>array()
                          );

  function __construct($mod)
    {
    //Init Errors
    $this->errors =& ErrorHandler::getInstance();
    
    $this->root_dir = $_SERVER['DOCUMENT_ROOT'].'/';
    //????????? ???? DBConnector
    define('DB_DIR',$_SERVER['DOCUMENT_ROOT'].'/lib/DBConnector/');
    require_once(DB_DIR.'DBConnector.class.php');
    //????????? ???? ??????
    define('SMARTY_DIR',$_SERVER['DOCUMENT_ROOT'].'/lib/Smarty/');
    require_once(SMARTY_DIR.'Smarty.class.php');

    define('SESSION_DIR',$_SERVER['DOCUMENT_ROOT'].'/lib/UserSession/');
    require_once(SESSION_DIR.'UserSession.class.php');
    
    define('KERNEL_DIR',$_SERVER['DOCUMENT_ROOT'].'/kernel/');
    require_once(KERNEL_DIR.'view.php');

    $this->type = 'user';

    $this->modname = $mod;//strtolower(get_class($this));

    $this->module_dir = 'modules/'.$this->modname.'/';
    
    //Session init
    $this->sessinInit();
    //?????????????? ?????? ???????? ??????
    $this->modelInit();

    //?????? ????????? ????? ?????????????
    $this->smarty = new viewTpl();
    //??????? ???? ???????????
    $this->theme = 'green';

    //??????? ??? ????????? ? ??????? ?????????? ? ???????? input_vars
    $this->input_vars = $_REQUEST;
    //?????? ??? ?????? ? ???????? ???????
    unset ($this->input_vars['module']);
    unset ($this->input_vars['action']);
    unset ($this->input_vars['type']);
    unset ($this->input_vars['PHPSESSID']);
    }
  
  function __set($name, $value)
    {
    if(property_exists($this, $name))
      {
      $this->$name = $value;
      return true;
      }
    $this->vars[$name] = $value;
    return true;
    }
    
  final public function action($action_name)
    {
    $this->action = $action_name;
    call_user_method_array($action_name, $this, $this->input_vars);
    }
    
  final public function view()
    {
    $tpl_dir = $this->tplFileName();
    $this->allVarToTpl();
    $ObjectName = $this->getTplObjectName();
    echo $this->smarty->fetch($tpl_dir, $ObjectName);
    }

  final public function viewPage()
    {
    $tpl_dir = $this->tplFileName();
    $this->allVarToTpl();
    $this->blockToTpl();
    $ObjectName = $this->getTplObjectName();
    $modresult['content'] = $this->smarty->fetch($tpl_dir, $ObjectName);
    
    $pageTplFile = $this->root_dir."themes/".$this->theme.'/pages/'.$this->page.'.tpl';
    $this->smarty->assign('module_content', $modresult['content']);
    echo $this->smarty->fetch($pageTplFile);
    }

  final public function tplFileName()
    {
    $view_file_name = $this->action;
    if(file_exists($this->root_dir.'themes/'.$this->theme.'/'.$this->module_dir.$view_file_name.'.tpl'))
      return $this->root_dir.'themes/'.$this->theme.'/'.$this->module_dir.$view_file_name.'.tpl';
    elseif(file_exists($this->root_dir.$this->module_dir.'themes/default/'.$view_file_name.'.tpl'))
      return $this->root_dir.$this->module_dir.'themes/default/'.$view_file_name.'.tpl';
    else
      {
      echo 'TPL file is not exist! '.$this->root_dir.$this->module_dir.'themes/default/'.$view_file_name.'.tpl <br> You most created tpl file <b>"'.$view_file_name.'.tpl"</b> for module <b>'.$this->modname.'</b><br>';
      echo "Values for TPL:<br>";
      echo "<pre>";
      print_r($this->vars);
      echo "</pre>";
      die();
      }
    }
    
  final public function allVarToTpl()
    {
    foreach ($this->vars as $name => $value)
      {
      $this->smarty->assign($name, $value, false);
      }
    }

  final public function getObjectName()
    {
    $url_result = $this->GetCallingMethodName(3, true);
    $action = $url_result['function'];
    $args = '';
    foreach($url_result['args'] as $value)
      {
      $args .= '::'.$value;
      }
      
    return $this->modname.'::'.$this->type.'::'.$action.$args;
    }
    
  final public function getTplObjectName()
    {
    $url_result = $this->GetCallingMethodName(3, true);
    $action = $url_result['function'];
    $args = '';
    foreach($url_result['args'] as $value)
      {
      $args .= '|'.$value;
      }
      
    return $this->modname.'|'.$this->type.'|'.$action.$args;
    }

  final public function getAccess($access_type=ACCESS_READ)
    {
    $object = $this->getObjectName();
    if(getAccess($object, $access_type)==true)
      return true;
    
    $this->notAccess();
    return false;
    }
  final public function notAccess($access_type=ACCESS_READ)
    {
    $this->errors->setError("Access to the page is forbidden. You are not allowed!");
    }

  final public function print_vars()
    {
    echo 'Debuging:<br><pre>';
    print_r($this);
    echo '</pre>';
    exit;
    }
    
    
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
    
    
  //////////////////////////////////////////////////////////////////////////////
  ////////////////////////////   MODELS     ////////////////////////////////////
  //////////////////////////////////////////////////////////////////////////////
  final public function modelInit($modulename=null)
    {
    //echo $this->modname;exit;
    $modelname = (!empty($modulename)) ? $modulename : $this->modname; 
    $modulename = (!empty($modulename)) ? $modulename : $this->modname; 
    require_once 'modules/'.$modulename.'/class.php';
    $className = $modulename;
    $this->$modelname = & new $className($className);
    $this->$modelname->type = $modulename;
    //echo $modelname;
    //print_r(get_class_methods($this->$modelname));
    }
    

  //////////////////////////////////////////////////////////////////////////////
  ////////////////////////////   Sessions   ////////////////////////////////////
  //////////////////////////////////////////////////////////////////////////////
  final public function sessinInit()
    {

    $this->session = & new UserSession;
    //print_r(get_class_methods($this->$modelname));
    }
  
  //////////////////////////////////////////////////////////////////////////////
  ////////////////////////////   BLOCKS     ////////////////////////////////////
  //////////////////////////////////////////////////////////////////////////////
  
  //Create default block array
  final public function blockAdd($block='center', $blockContent)
    {
    array_push($this->block[$block], $blockContent);
    }
  //Add all blocks to tpl
  final public function blockToTpl()
    {
    $this->smarty->assign('blocks', $this->block, false);
    }
    
  }

?>
