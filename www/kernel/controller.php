<?php

abstract class Controller extends AppObject
  {
  private   $message = '';
  private   $start_debug_time = 0;
  public    $defaultAction = '';
  protected $errors;
  protected $registry;
  protected $smarty;
  protected $module_dir;
  public    $root_dir;
  public    $current_theme;
  protected $vars = array();
  protected $modname;
  protected $object_name;
  protected $type;
  protected $action;
  public    $input_vars = array();
  protected $input_vars_clear = array();
  private   $lang;
  private   $lang_default = 'rus';
  public    $config = null;
  private   $mod_vars = array();
  public    $controllerName = 'IndexController';
  
  public    $permissionLavel = 0;
  
  public $URL;
  public $prevURL;

  protected $lib;

  protected $page = 'index';
  
  protected $block = array(
                          'top'   =>array(),
                          'left'  =>array(),
                          'center'=>array(),
                          'right' =>array(),
                          'bottom'=>array()
                          );
  public $models= array();
  protected $libs = array();
  protected $tpls = array();
  
  // FILES 
  public $input_files; 
  public $input_images;
  
  public $image_size = array(
                            array('width'=>'640', 'height'=>'480'),
                            array('width'=>'320', 'height'=>'150'),
                            array('width'=>'100', 'height'=>'100')
                            );
  
  
  function __construct($mod)
    {
    date_default_timezone_set('Europe/Moscow');
    //APP_DIRECTORY = dirname(__FILE__);
    //print_r('wwww');exit;
    //$this->start_debug_time = time();
    $current_time = microtime();
    // Отделяем секунды от миллисекунд
    $current_time = explode(" ",$current_time);
    // Складываем секунды и миллисекунды
    $this->start_debug_time =$current_time[1] + $current_time[0];
    
    $this->setConfig();
    //$coreConfig['debug.enabled']-Статус дебагера;  
    //Init Errors
    $this->errors =& ErrorHandler::getInstance();
    
    $this->root_dir = APP_DIRECTORY.'/';
    
    define('LIB_DIR',APP_DIRECTORY.'/lib/');
    
    define('DB_DIR',APP_DIRECTORY.'/lib/DBConnector/');
    require_once(DB_DIR.'DBConnector.class.php');
    
    //define('SMARTY_DIR',APP_DIRECTORY.'/lib/Smarty/');
    require_once(SMARTY_DIR.'Smarty.class.php');

    define('SESSION_DIR',APP_DIRECTORY.'/lib/UserSession/');
    require_once(SESSION_DIR.'UserSession.class.php');
    
    define('KERNEL_DIR',APP_DIRECTORY.'/kernel/');
    require_once(KERNEL_DIR.'block.php');
    require_once(KERNEL_DIR.'view.php');

    $this->type = 'user';

    $this->modname = $mod;//strtolower(get_class($this));

    $this->module_dir = 'modules/'.$this->modname.'/';
    
    if($this->config['debug.enabled'])
      {
      require_once(KERNEL_DIR.'debuger.php');
      
      $this->debuger = & Debuger::getInstance();
      $this->debuger->startRenderPage();
      }
 
    //Session init
    $this->sessinInit();
    //?????????????? ?????? ???????? ??????
    //$this->usesModel();
    $this->usesModule($mod);

    //?????? ????????? ????? ?????????????
    $this->smarty = new viewTpl();
    //??????? ???? ???????????
//    $this->current_theme = 'green';
    $this->setTheme();
    //$this->current_theme = 'blog_theme1';
    
    //Установим язык
    $this->setLang($this->config['lang']);
    $this->loadLang();
    
    $this->loadModuleLang($this->modname);
    
    //$this->loadModVars('kernel');
    
    $this->setModConfig();
    $this->setTplUserInfo();
    
    //$this->object_name = $this->getObjectName();

    //??????? ??? ????????? ? ??????? ?????????? ? ???????? input_vars
    $this->input_vars = $_REQUEST;
    //?????? ??? ?????? ? ???????? ???????
    unset ($this->input_vars['module']);
    unset ($this->input_vars['action']);
    unset ($this->input_vars['type']);
    //unset ($this->input_vars['submit']);
    unset ($this->input_vars['PHPSESSID']);
    
    $this->getCurrentURL();
    
    $this->displayMessage();
    }
    
  function __destruct()
    {
    if($this->config['debug.enabled'] && !isAjax())
      {
        
      $current_time = microtime();
      $current_time = explode(" ",$current_time);
      $end_debug_time = $current_time[1] + $current_time[0];
      
      $debug_time = $end_debug_time - $this->start_debug_time;
      
      $debuger = Debuger::getInstance();
      
      $debuger->endRenderPage();
      
      $mysql_querys = array();
      $mysql_query_count = 0;
      $mysql_query_time = 0;
      foreach($debuger->mysql as $key=>$value)
        {
        $key_sufix = $key +1;
        $mysql_querys['query_'.$key_sufix] = $value;
        $mysql_query_count++;
        $mysql_query_time += $value['exec_time'];
        }
        
      $debuger->debugAdd("PHP Execute Time (".$debug_time." sec)", '');
      
      $debuger->debugAddCreateGroup("Callisto Debug Detail");
        $debuger->debugAdd('Controller: '.$this->modname, null, INFO);
        $debuger->debugAdd('Action: '.$this->action, null, INFO);
        $debuger->debugAdd('Object Name: '.$this->object_name, null, INFO);
        $debuger->debugAdd('Theme: '.$this->current_theme, null, INFO);
        //
        $debuger->debugAddCreateGroup("Uses Tpls (".sizeof($this->tpls).")");
        if($this->tpls)
          foreach($this->tpls as $value)
            $debuger->debugAdd($value, null, INFO);
        $debuger->debugAddEndGroup();
        //
        $debuger->debugAddCreateGroup("Uses Models (".sizeof($this->models).")");
        if($this->models)
          foreach($this->models as $value)
            $debuger->debugAdd($value, null, INFO);
        $debuger->debugAddEndGroup();
        //
        $debuger->debugAddCreateGroup("Uses Libs (".sizeof($this->libs).")");
        if($this->libs)
          foreach($this->libs as $value)
            $debuger->debugAdd($value, null, WARN);
        else
           $debuger->debugAdd('Libraries Are Not Used', null, INFO);
        $debuger->debugAddEndGroup();
       // 
      $debuger->debugAddEndGroup();
      
      $debuger->debugAddCreateGroup("MySQL ($mysql_query_count) $mysql_query_time sec");
        $debuger->debugAddDir($mysql_querys);
      $debuger->debugAddEndGroup();
      
      $debuger->debugAddCreateGroup("Input Vars (".sizeof($this->input_vars).")");
        $debuger->debugAddDir($this->input_vars);
      $debuger->debugAddEndGroup();
      
      $debuger->debugAddCreateGroup("Template Vars (".sizeof($this->vars).")");
        $debuger->debugAddDir($this->vars);
      $debuger->debugAddEndGroup();
     
      $debuger->debugAddCreateGroup("Session (".sizeof($_SESSION).")");
        $debuger->debugAddDir($_SESSION);
      $debuger->debugAddEndGroup();
      
      //
      $debuger->debugAddCreateGroup("PHP WARNINGS (".sizeof($debuger->warnings).")");
      foreach($debuger->warnings as $key=>$value)
        {
        $debuger->debugAdd($value, null,WARN);;
        }
      $debuger->debugAddEndGroup();
      
      $debuger->debugAddCreateGroup("PHP NOTICES (".sizeof($debuger->notices).")");
      foreach($debuger->notices as $key=>$value)
        {
        $debuger->debugAdd($value, null, INFO);        
        }
      $debuger->debugAddEndGroup();
      
      $debuger->render();  
      }
    }
    
  function __set($name, $value)
    {
    if(property_exists($this, $name))
      {
      $this->$name = $value;
      return true;
      }
    $this->assign($name, $value);
    return true;
    }
    
  final function assign($var_name = null, $var_value = '')
    {
    if(empty($var_name))
      {
      return true;
      }
    if(is_array($var_name))
      {
      $this->vars = array_merge($this->vars, $var_name);
      }
    else
      {
      $this->vars[$var_name] = $var_value;
      }
    
    }
    
  final public function action($action_name)
    {
    if(empty($action_name) || $action_name == 'index')
      {
      if(!empty($this->defaultAction))
        {
        $action_name = $this->defaultAction;
        }
      else
        {
        $action_name = 'index';
        }
      }

    //Заменим - и _ на Большие буквы, тоесть приобразуем урл в Камелкейсподобный вид  
    $action_name = $this->urlToCamelCase($action_name);
      
    if(!method_exists($this, 'action'.$action_name))
      $this->errors->setError('Action "'.$action_name.'" is not exist in this module "'.$this->modname.'", conroller "'.$this->controllerName.'"');
    
    $this->action = $action_name;
    $this->object_name = $this->getObjectName();
    $this->permissionLavel = $GLOBALS['permissionLavel'] = $this->getPermissionLavel($this->object_name);
    
    $this->smarty->assign('config', $this->config);
    
    //Подключим джаваскрипты
    appJsLoad('kernel', 'jQuery');
    appJsLoad('kernel', 'main');
    
    //Подключим стили
    //Стили ядра
    //appCssLoad('kernel', 'bootstrap');
    appCssLoad('kernel'); 
     
    //Без аргументов подключится стиль текущей темы
    appCssLoad();
    
    call_user_method_array('action'.$action_name, $this, $this->input_vars);
    }
  final public function setViewType($type = 'user')
    {
    $this->type = $type;
    }

  final private function urlToCamelCase($string)
    {
    return preg_replace("/[\_,\-](.)/e", "strtoupper('\\1')", $string);
    }
  final public function setTheme()
    {
    $this->usesModel('theme');
    $this->current_theme = $this->theme->getActiveName();
    }
  final public function getThemeName()
    {
    return $this->current_theme;
    }
  final public function getModName()
    {
    return $this->modname;
    }
  final public function getActionName()
    {
    return $this->action;
    }
    
  final function setConfig()
    {
    global $appConfig;
    $this->config = &$appConfig;
    }
  final function setModConfig()
    {
    $this->usesModel('configuration');
    $db_conf = $this->configuration->getModConfiguration('main');
    if(!empty($db_conf))
      {
      $this->config = array_merge($this->config, $db_conf);
      }
    unset($db_conf);
    }
  final function setTplUserInfo()
    {
    $currentUserInfo['currentUserInfo']['id']   = $this->session->userId();
    $currentUserInfo['currentUserInfo']['name'] = $this->session->userName();
    $currentUserInfo['currentUserInfo']['gid']  = $this->session->userGid();
    $this->assign($currentUserInfo);
    return $this;
    }
    
  final function getInput($var, $default)
    {
    if(empty($var))
      {
      return $this->input_vars;
      }
    return isset($this->input_vars[$var]) ? $this->input_vars[$var] : $default;
    }
  //////////////////////////////////////////////////////////////////////////////
  ////////////////////////////   TEMPLATES  ////////////////////////////////////
  //////////////////////////////////////////////////////////////////////////////
  final public function paginate($model=false)
    {
    if(empty($model))
      return;
    
    //appDebug($model->pagination);exit;
    $this->assign('pagination', $model->pagination);
    }
    
  final public function isCached()
    {
    $tpl_dir = $this->tplFileName();
    $ObjectName = $this->getTplObjectName();
    
    return $this->smarty->is_cached($tpl_dir, $ObjectName);
    }
    
  final public function deleteCache($ObjectName = false)
    {
    //$tpl_dir = $this->tplFileName();
    
    if(empty($ObjectName))
      $ObjectName = $this->modname.'|'.$this->type;
 
    if(empty($ObjectName)) 
      return;
    
    return $this->smarty->clear_cache(null, $ObjectName);
    }
    
  final public function viewCached()
    {
    $tpl_dir = $this->tplFileName();
    $ObjectName = $this->getTplObjectName();
    
    if(!$this->smarty->is_cached($tpl_dir, $ObjectName))
      return false;
    
    echo $this->smarty->fetch($tpl_dir, $ObjectName);
    exit;
    }
    
  final public function viewCachedPage()
    {
    $tpl_dir = $this->tplFileName();
    $ObjectName = $this->getTplObjectName();
  
    if(!$this->smarty->is_cached($tpl_dir, $ObjectName))
      return false;
    
    $this->viewPage();
    }
    
  final public function view()
    {
    $tpl_dir = $this->tplFileName();
    $this->allVarToTpl();
    $ObjectName = $this->getTplObjectName();
    echo $this->smarty->fetch($tpl_dir, $ObjectName);
    }
    
  /**
   * Получить значение  из словаря в Smarty (lang.conf)
   * @param string $const Ключ словаря
   * @return string Результат, предложение в текущей локали
   */
  final public function t($const)
    {
    $result = $this->smarty->get_config_vars($const);
    if($result) return ''.$result;
    return '';
    }
    
  final public function viewJSON()
    {
    $obj =  $this->vars;
    app_cp1251_utf8($obj);
    echo json_encode($obj);
    }

  final public function viewPage($page_template = null)
    {
    if($page_template)
      {
      $this->page = $page_template; 
      }
    $tpl_dir = $this->tplFileName();
    $this->allVarToTpl();
    $this->blockToTpl();
    $ObjectName = $this->getTplObjectName();
    
    //Прикрепим меседж в тело.
    $modContent = $this->message.$this->smarty->fetch($tpl_dir, $ObjectName);
   
    //Если это запрос через AJAX, то выводим только результат работы модуля
    if(isAjax())
      {
      echo $modContent;
      exit;
      }
    else
      {
      if($this->type == 'admin')
        {
        $pageTplFile = $this->root_dir.'themes/admin/pages/'.$this->page.'.tpl';
        $this->tpls[] = '(Main Template)themes/admin/pages/'.$this->page.'.tpl';
        
        $ObjectThemeName = 'themes|admin|pages|'.$this->page;
        }
      else
        {
        $pageTplFile = $this->root_dir."themes/".$this->current_theme.'/pages/'.$this->page.'.tpl';
        $this->tpls[] = '(Main Template)'."themes/".$this->current_theme.'/pages/'.$this->page.'.tpl';
        
        $ObjectThemeName = 'themes|'.$this->current_theme.'|pages|'.$this->page.'';
        }

      $this->smarty->assign('module_content', $modContent);
      
      $this->smarty->caching = false;
      echo $this->smarty->fetch($pageTplFile);
      }
    exit(); 
    }
  

  final public function tplFileName($debug=false)
    {
    $view_file_name = $this->action;
    if($this->type == 'admin')
      {
      if(file_exists($this->root_dir.$this->module_dir.'views/default/admin/'.$view_file_name.'.tpl'))
        {
        $this->tpls[] = '(Original Module TPL) '.$this->module_dir.'themes/default/admin/'.$view_file_name.'.tpl';
        return $this->root_dir.$this->module_dir.'views/default/admin/'.$view_file_name.'.tpl';
        }
      elseif(!empty($debug))
        {
        $this->tpls[] = '(TPL file is not exist!) '.$this->module_dir.'views/default/admin/'.$view_file_name.'.tpl';
        return 'TPL file is not exist! '.$this->root_dir.$this->module_dir.'views/default/admin/'.$view_file_name.'.tpl <br> You most created tpl file <b>"'.$view_file_name.'.tpl"</b> for module <b>'.$this->modname.'</b><br>';
        }
      else
        {
        $this->tpls[] = '(TPL file is not exist!) '.$this->module_dir.'views/default/admin/'.$view_file_name.'.tpl';
        echo 'TPL file is not exist! '.$this->root_dir.$this->module_dir.'views/default/admin/'.$view_file_name.'.tpl <br> You most created tpl file <b>"'.$view_file_name.'.tpl"</b> for module <b>'.$this->modname.'</b><br>';
        echo "Values for TPL:<br>";
        echo "<pre>";
        print_r($this->vars);
        echo "</pre>";
        die();
        }
      }
    else
      {
      if(file_exists($this->root_dir.'themes/'.$this->current_theme.'/'.$this->module_dir.$view_file_name.'.tpl'))
        {
        $this->tpls[] = '(Overridden by Theme) '.'themes/'.$this->current_theme.'/'.$this->module_dir.$view_file_name.'.tpl';
        return $this->root_dir.'themes/'.$this->current_theme.'/'.$this->module_dir.$view_file_name.'.tpl';
        }
      elseif(file_exists($this->root_dir.$this->module_dir.'views/default/'.$view_file_name.'.tpl'))
        {
        $this->tpls[] = '(Original Module TPL) '.$this->module_dir.'themes/default/'.$view_file_name.'.tpl';
        return $this->root_dir.$this->module_dir.'views/default/'.$view_file_name.'.tpl';
        }
      elseif(!empty($debug))
        {
        $this->tpls[] = '(TPL file is not exist!) '.$this->module_dir.'views/default/'.$view_file_name.'.tpl';
        return 'TPL file is not exist! '.$this->root_dir.$this->module_dir.'views/default/'.$view_file_name.'.tpl <br> You most created tpl file <b>"'.$view_file_name.'.tpl"</b> for module <b>'.$this->modname.'</b><br>';
        }
      else
        {
        $this->tpls[] = '(TPL file is not exist!) '.$this->module_dir.'views/default/'.$view_file_name.'.tpl';
        echo 'TPL file is not exist! '.$this->root_dir.$this->module_dir.'views/default/'.$view_file_name.'.tpl <br> You most created tpl file <b>"'.$view_file_name.'.tpl"</b> for module <b>'.$this->modname.'</b><br>';
        echo "Values for TPL:<br>";
        echo "<pre>";
        print_r($this->vars);
        echo "</pre>";
        die();
        }
      }

    }
   
  final public function getObjectName()
    {
    //$url_result = $this->GetCallingMethodName(3, true);
    $action = $this->action;//$url_result['function'];
    $args = '';
    foreach($this->input_vars as $value)
      {
      $args .= '::'.$value;
      }
      
    return $this->modname.'::'.$this->type.'::'.$action.$args;
    }
    
  final public function getTplObjectName()
    {
    //$url_result = $this->GetCallingMethodName(3, true);
    $action = $this->action;//$url_result['function'];
    $args = '';
    if(isset($url_result['args']) && $url_result['args'])
      foreach($url_result['args'] as $value)
        {
        $args .= '|'.$value;
        }
    return $this->modname.'|'.$this->type.'|'.$action.$args.'|ACCESS_LEVEL_'.$this->permissionLavel;
    }
    
    
  //////////////////////////////////////////////////////////////////////////////
  ///////////////////////////// Languages //////////////////////////////////////
  function setLang($lang='rus')
    {
    $this->lang = $lang;
    $this->assign('lang', $lang);
    }
  function loadLang()
    {
    if (file_exists ("lang/$this->lang/lang.conf"))
      {
      $this->smarty->config_load("lang/$this->lang/lang.conf");
      }
    elseif (($this->lang !=$this->lang_default) && file_exists("lang/$this->lang_default/lang.conf"))
      {
      $this->smarty->config_load("lang/$this->lang_default/lang.conf");
      }
    return true;
    }
    
  function loadBlockLang($blockName)
    {
    if (file_exists ("blocks/$blockName/lang/$this->lang/lang.conf"))
      {
      $this->smarty->config_load("blocks/$blockName/lang/$this->lang/lang.conf");
      }
    elseif (($this->lang !=$this->lang_default) && file_exists("blocks/$blockName/lang/$this->lang_default/lang.conf"))
      {
      $this->smarty->config_load("blocks/$blockName/lang/$this->lang_default/lang.conf");
      }
    return true;
    }
    
  function loadModuleLang($moduleName)
    {
    if(file_exists ("modules/$moduleName/lang/$this->lang/lang.conf"))
      {
      $this->smarty->config_load("modules/$moduleName/lang/$this->lang/lang.conf");
      }
    elseif(($this->lang !=$this->lang_default) && file_exists("modules/$moduleName/lang/$this->lang_default/lang.conf"))
      {
      $this->smarty->config_load("modules/$moduleName/lang/$this->lang_default/lang.conf");
      }
    return true;
    }

  //////////////////////////////////////////////////////////////////////////////
  ////////////////////////////   ACCESS     ////////////////////////////////////
  //////////////////////////////////////////////////////////////////////////////  
  final private function getPermissionLavel($object=false)
    {
    if(empty($object))
      $object = $this->getObjectName();
    
    $this->usesModel('permissions');
    return $this->permissionLavel = $this->permissions->objectGetPermsLevel($object);
    }
  final public function getAccess($access_type=ACCESS_READ, $admin = true)
    {
    $object = $this->getObjectName();
    
    $this->usesModel('permissions');
    if($this->permissions->getAccess($object, $access_type)==true)
      return true;
    
    $this->notAccess($access_type, $admin);
    return false;
    }
    
  final public function notAccess($access_type=ACCESS_READ, $admin = false)
    {
    $logedin = $this->session->isLogin();
    if(empty($logedin))
      {
      if($admin)
        {
        $this->showMessage($this->t('page_not_access_most_login'), '/admin/users/login');
        }
      else
        {
        $this->showMessage($this->t('page_not_access_most_login'), '/users/login');
        }
      }
      
    $this->errors->setError($this->t('page_not_access'));
    }

    
  //////////////////////////////////////////////////////////////////////////////
  final public function print_vars()
    {
    echo 'Debuging:<br><pre>';
    print_r($this);
    echo '</pre>';
    exit;
    }
    
    
//  final public function GetCallingMethodName($position = null, $with_args = false)
//    {
//    $e = new Exception();
//    $trace = $e->getTrace();
//    
//    $position = ($position) ? $position : (sizeof($trace)-1);
//    if(empty($with_args))
//      return $trace[$position]['function'];
//    
//    return array('function'=>$trace[$position]['function'], 'args' => $trace[$position]['args']);
//    print_r($trace);
//    }
 
  //////////////////////////////////////////////////////////////////////////////
  ////////////////////////////   URLS       ////////////////////////////////////
  //////////////////////////////////////////////////////////////////////////////
  function setReferer($url)
    {
    if(empty($url))
      $url = $_SERVER['HTTP_REFERER'];
    $this->session->setVar('app_referer', $url);
    }
  function getReferer($url='/')
    {
    $url_ = $this->session->getVar('app_referer');
    if(!empty($url_))
      $url= $url_;
    return $url;
    }
    
  function getCurrentURL()
    {
    if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off')
      {
      $proto = 'https://';
      }
    else
      {
      $proto = 'http://';
      }
      
    $this->URL = $proto.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']; 
    
    $this->prevURL = $this->session->getVar('prevURL');
    $this->session->setVar('prevURL', $this->URL);
    
    return $proto.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
    }
    
  function getBaseURI()
    {
    // Start of with REQUEST_URI
    if (isset($_SERVER['REQUEST_URI']))
      {
      $path = $_SERVER['REQUEST_URI'];
      }
    else
      {
      $path = getenv('REQUEST_URI');
      }
      
    if ((empty($path)) || (substr($path, -1, 1) == '/'))
      {
      // REQUEST_URI was empty or pointed to a path
      // Try looking at PATH_INFO
      $path = getenv('PATH_INFO');
      if (empty($path))
        {
        // No luck there either
        // Try SCRIPT_NAME
        if (isset($_SERVER['SCRIPT_NAME']))
          {
          $path = $_SERVER['SCRIPT_NAME'];
          }
          else
            {
            $path = getenv('SCRIPT_NAME');
            }
        }
      }

      $path = preg_replace('/[#\?].*/', '', $path);
      $path = dirname($path);

      if (preg_match('!^[/\\\]*$!', $path))
        {
        $path = '';
        }

    return $path;
    }  
    
  function getBaseURL($with_path=true)
    {
    if (empty($_SERVER['HTTP_HOST']))
      {
      $server = getenv('HTTP_HOST');
      }
    else
      {
      $server = $_SERVER['HTTP_HOST'];
      }
    if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off')
      {
      $proto = 'https://';
      }
    else
      {
      $proto = 'http://';
      }
    
    if($with_path)
     $path = $this->getBaseURI();

       
    return "$proto$server$path";
    }  
    
    
    
  final public function redirect($url=NULL, $code = 200)
    {
    static $http = array (
                            100 => "HTTP/1.1 100 Continue",
                            101 => "HTTP/1.1 101 Switching Protocols",
                            200 => "HTTP/1.1 200 OK",
                            201 => "HTTP/1.1 201 Created",
                            202 => "HTTP/1.1 202 Accepted",
                            203 => "HTTP/1.1 203 Non-Authoritative Information",
                            204 => "HTTP/1.1 204 No Content",
                            205 => "HTTP/1.1 205 Reset Content",
                            206 => "HTTP/1.1 206 Partial Content",
                            300 => "HTTP/1.1 300 Multiple Choices",
                            301 => "HTTP/1.1 301 Moved Permanently",
                            302 => "HTTP/1.1 302 Found",
                            303 => "HTTP/1.1 303 See Other",
                            304 => "HTTP/1.1 304 Not Modified",
                            305 => "HTTP/1.1 305 Use Proxy",
                            307 => "HTTP/1.1 307 Temporary Redirect",
                            400 => "HTTP/1.1 400 Bad Request",
                            401 => "HTTP/1.1 401 Unauthorized",
                            402 => "HTTP/1.1 402 Payment Required",
                            403 => "HTTP/1.1 403 Forbidden",
                            404 => "HTTP/1.1 404 Not Found",
                            405 => "HTTP/1.1 405 Method Not Allowed",
                            406 => "HTTP/1.1 406 Not Acceptable",
                            407 => "HTTP/1.1 407 Proxy Authentication Required",
                            408 => "HTTP/1.1 408 Request Time-out",
                            409 => "HTTP/1.1 409 Conflict",
                            410 => "HTTP/1.1 410 Gone",
                            411 => "HTTP/1.1 411 Length Required",
                            412 => "HTTP/1.1 412 Precondition Failed",
                            413 => "HTTP/1.1 413 Request Entity Too Large",
                            414 => "HTTP/1.1 414 Request-URI Too Large",
                            415 => "HTTP/1.1 415 Unsupported Media Type",
                            416 => "HTTP/1.1 416 Requested range not satisfiable",
                            417 => "HTTP/1.1 417 Expectation Failed",
                            500 => "HTTP/1.1 500 Internal Server Error",
                            501 => "HTTP/1.1 501 Not Implemented",
                            502 => "HTTP/1.1 502 Bad Gateway",
                            503 => "HTTP/1.1 503 Service Unavailable",
                            504 => "HTTP/1.1 504 Gateway Time-out"
                        );
   
    if (headers_sent())
      {
      die('<script type="text/javascript">window.location=\'' . $url . '\';</script>');
      }
    
    if(empty($url))
      $url = $_SERVER['HTTP_REFERER'];
    if(empty($url))
      $url = '/';
    
    echo $url.' ';
    $url = str_replace('&amp;', '&', $url);

    if (preg_match('!^http!', $url))
      {
      Header($http[$code]);
      Header("Location: $url");
      die();
      }
    else
      {
      $with_path = true;
      if($url[0] == '/')
        $with_path = false;

       // Removing leading slashes from redirect url
      $url = preg_replace('!^/*!', '', $url);
      // Get base URL
      $baseurl = $this->getBaseURL($with_path);
   
//      echo $baseurl/$url;
//      die();
      
      Header($http[$code]);
      Header("Location: $baseurl/$url");
      die();
      }
    exit;
    }  
    
  //////////////////////////////////////////////////////////////////////////////
  //////////////////////   SYSTEM MESSAGES  ////////////////////////////////////
  //////////////////////////////////////////////////////////////////////////////  
  final public function showMessage($message='', $url='', $data='', $type = MESSAGE_INFO)
    {
    $this->session->setVar('appMessage', $message);
    $this->session->setVar('appMessageData', $data);
    $this->session->setVar('appRedirectUrl', $url);
    $this->session->setVar('appMessageType', $type);
    
    if($url)
      $this->redirect($url);
    return true;
    }

  final private function displayMessage()
    {
    $message  = $this->session->getVar('appMessage');
    $data     = $this->session->getVar('appMessageData');
    $url      = $this->session->getVar('appRedirectUrl'); 
    $type     = $this->session->getVar('appMessageType'); 
    
    //Clean session vars
    $this->session->delVar('appMessage');
    $this->session->delVar('appMessageData');
    $this->session->delVar('appRedirectUrl');
    $this->session->delVar('appMessageType');
    
    if(!empty($data))
      {
      foreach($data as $key=>$value)
        {
        $this->assign($key, $value);
        }
      }
    
    if($this->config['Message.type']=='js')
      {
      if($message)
        {
        $this->message = "<div style='display:none;' id='appMessage_'>
                          <input type='hidden' id='appMessageType' value='$type'>
                          <input type='hidden' id='appMessageText' value='$message'>
                          </div>";

        $this->assign('appMessage', $message);
        }
      }
    else
      {
      /////////////////////////////////////////////////////
      /////// Для вывода сообщений в отдельном окне ///////
      if(empty($message))
        return;
      if(empty($url))
        {
        $url = $this->session->getVar('prevURL');
        }
      $time = 2;
      $this->smarty->caching = false;
      $this->smarty->assign('url', $url);
      $this->smarty->assign('message', $message);
      $this->smarty->assign('time', $time);
      //Смотрим че у нас в сесии (Какая тема)
      //$themename = sysUserTheme ();
      //$sysTpl->display("themes/test/messages/normal.tpl");
      $this->smarty->display("themes/green/messages/normal.tpl");
      exit;
      }
    }
    
    
  //////////////////////////////////////////////////////////////////////////////
  ////////////////////////////   POST DATA  ////////////////////////////////////
  //////////////////////////////////////////////////////////////////////////////
  final public function getPostData()
    {
    define('VALIDATOR_DIR',APP_DIRECTORY.'/lib/validateForm/');
    require_once(VALIDATOR_DIR.'validateForm.class.php');
   
    $form = new validateForm($_POST);

    $resarray = array();
    $func_args = func_get_args();
    foreach ($func_args as $var)
      {
      if(is_array($var))
        {
        foreach($var as $key=>$value)
          {

          //Delete spaces
          $value = trim($value);
          //explode by space
          $validators  = explode(' ', $value);

          foreach($validators as $validator)
            {
            
            $validator_clean = preg_replace ("/[^a-z]/ui","", $validator);

            if(method_exists($form, $validator_clean))
              {
              if(preg_match("/min\((.*)\)/sim", $validator, $matches))
                {
                $form->min($matches[1],$key);
                }
              elseif(preg_match("/max\((.*)\)/sim", $validator, $matches))
                {
                $form->max($matches[1],$key);
                }
              else
                {
                $form->$validator($key);
                }
              }
            }
            
          if(empty($_POST[$key]))
            continue;
          
          $resarray["$key"] = $_POST[$key];
          }
        }
      else
        {
        if(empty($_POST[$var]))
          continue;
        
        $resarray["$var"] = $_POST[$var];
        }
        
      if($form->pass == true)
        {
        $ok = true;
        }
      else
        {
        $error_msg = $form->allErrors();
        $this->showMessage($error_msg, '', $form->input);
        }
            
      }

    // Return value or array
    if (func_num_args() == 1)
      {
      if(is_array($func_args[0]) && count($func_args[0]) == 1 )
        foreach ($resarray as $key => $value)
          {
          return $value;
          }
      else
        {
        return $resarray;
        }
      }
		else
			return $resarray;
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
    Block::blockShowAll($this->smarty, $this->object_name, $this->current_theme);
    //$this->smarty->assign('blocks', $this->block, false);
    }
  
    
  //////////////////////////////////////////////////////////////////////////////
  ////////////////////////////   FILES      ////////////////////////////////////
  //////////////////////////////////////////////////////////////////////////////
  final public function getFile($name = false, $type=false)
    {
    $result = $_FILES;
 
    if(!empty($type))
      {
      $temp = array();
      foreach($result as $value)
        {
        if($value['type'] == $type)
          {
          $temp[] = $value;
          }
        }
      $result = $temp;
      }
      
    if(!empty($name))
      $result = $_FILES[$name];

    $this->input_files = $result;
    return $result;
    }
    
  final public function saveFile($id = null, $name = null)
    {
    if(empty($id))
      $this->errors->setError('OBJECT ID CAN NOT BE NULL!');
    if(!is_numeric($id))
      $this->errors->setError('OBJECT ID CAN BE INTEGER!');
    
    $type = $this->input_files['type'];
    
    $temp = explode('/', $type);
    $path_files_type = $temp[0].'s';
    
    $id8 = sprintf('%08d',$id);
    
    $path = "files/$path_files_type/{$id8[7]}/{$id8[6]}/$id8/";

    if (!mkdir($path, 0777, true)) 
      {
      $this->errors->setError('Failed to create folders...');
      }
      
    $ext = substr(strrchr($this->input_files['name'], '.'), 1);
    
    $name = (empty($name)) ? $id8 : $name;
    
    $dst = $path.$name.'.'.$ext;
    
    move_uploaded_file($this->input_files['tmp_name'], $dst);
    return $dst;
    }
 
  //////////////////////////////////////////////////////////////////////////////
  ////////////////////////////   IMAGES     ////////////////////////////////////
  //////////////////////////////////////////////////////////////////////////////
  /**
   * Функция получения изображения с формы
   * @param string $name Имя поля получаемого файла
   * @return boolean
   */
  final public function getImage($name = false)
    {
    if(empty($name))
      $this->errors->setError('FILE NAME CAN NOT BE NULL!');

    $img_type = array("image/gif", "image/jpeg", "image/png", "image/pjpeg");

    $result = $_FILES[$name];
    
    if(empty($result) || $result['error'])
      return false;
    
    if(!in_array($result['type'], $img_type))
       $this->errors->setError('FILE "'.$name.'" IS NOT EXIST!'); 
 
    $this->input_images = $result;
    return $result;
    }
    
  /**
   * Функция сохранения файла
   * @param string $poatFileName Имя поля получаемого файла
   * @param integer $id Ид обьекта к которому относится изображение
   * @param string $newName Новое имя сохраняемого файла файла 
   * @return string|boolean
   */ 
  final public function saveImage($poatFileName, $id = null, $newName = null)
    {
    $this->getImage($poatFileName);
    
    if(empty($this->input_images))
      return false;
    
    if(empty($id))
      $this->errors->setError('OBJECT ID CAN NOT BE NULL!');
    if(!is_numeric($id))
      $this->errors->setError('OBJECT ID CAN BE INTEGER!');
    
    $type = $this->input_images['type'];
    
    $temp = explode('/', $type);
    $path_files_type = $temp[0].'s';
    
    $id8 = sprintf('%08d',$id);
    
    $path = "images/{$this->modname}/{$id8[7]}/{$id8[6]}/$id8/";

    if(!is_dir($path))
      if (!mkdir($path, 0777, true)) 
        {
        $this->errors->setError('Failed to create folders...');
        }
      
    $ext = substr(strrchr($this->input_images['name'], '.'), 1);
    
    $newName = (empty($newName)) ? $id8 : $newName;
    
    $dst = $path.$newName.'.'.$ext;
    
    move_uploaded_file($this->input_images['tmp_name'], $dst);
    
    require_once LIB_DIR.'Image/Image.class.php';
    
    $img = new Image();
    
    $result_files = array();
    $result_files['original'] = $dst;
    
    foreach($this->image_size as $value)
      {
      $img->load($dst);
      //$img->resize($value['width'], $value['height']);
      $img->resizeToWidth($value['width']);
      $result_files[$value['width']] = $fname = $path.$newName.'_w'.$value['width'].'.'.$ext;
      $img->save($fname);
      }
    
    return $result_files;
    }
  
  final public function getImageSrc($id=null, $w=null, $name=null)
    {
    $id8 = sprintf('%08d', $id);
    $path = "images/".$this->modname."/".$id8[7]."/".$id8[6]."/".$id8."/";
    
    
    } 
    
  ///////////////////////////// MOD VARS ///////////////////////////////////////
//  final public function loadModVars($mod='')
//    {
//    if(empty($mod))
//      {
//      return false;
//      }
//    $this->usesModel('modconfig');
//    
//    $vars = $this->modconfig->getVars($mod);
//    $this->mod_vars[$mod] = $vars[$mod];
//    }
//    
//  final public function getModVars($mod='')
//    {
//    if(empty($mod))
//      {
//      return false;
//      }
//    
//    if(empty($this->mod_vars[$mod])) 
//      {
//      $this->loadModVars($mod);
//      }
//    return isset($this->mod_vars[$mod]) ? $this->mod_vars[$mod] : array();
//    }
//    
//  final public function getModVar($mod='', $key='')
//    {
//    if(empty($key) && empty($mod))
//      {
//      return false;
//      }
//    if(empty($key))
//      {
//      $key = $mod;
//      $mod = false;
//      }
//    if(empty($mod))
//      {
//      $mod = $this->modname;
//      }
//    if(empty($this->mod_vars[$mod])) 
//      {
//      $this->loadModVars($mod);
//      }
//    return isset($this->mod_vars[$mod][$key]) ? $this->mod_vars[$mod][$key] : null;
//    }
//    
//  final public function setModVar($mod='', $key='', $var)
//    {
//    if(empty($key) && empty($mod))
//      {
//      return false;
//      }
//    if(func_num_args() == 2)
//      {
//      $mod = false;
//      $key = func_get_arg(0);
//      $var = func_get_arg(1);
//      }
//    if(empty($mod))
//      {
//      $mod = $this->modname;
//      }
//      
//    $this->usesModel('modconfig');
//    
//    $this->modconfig->setVar($mod, $key, $var);
//    $this->loadModVars($mod);
//    return true;
//    }
   
  
  //////////////////////////////////////////////////////////////////////////////
  ////////////////////////////   DEBUG      ////////////////////////////////////
  //////////////////////////////////////////////////////////////////////////////
  final public function debugGetModelVars(&$model = null)
    {
    if(empty($model))
      {
      $mod = $this->modname;
      $model = & $this->$mod;
      }
    echo "<h2>ALL MODEL VARS (THIS VARIABLES VAS WRITE TO DB)</h2>";
    echo "<pre>";
    print_r($model->vars);
    echo "</pre>";
    die();
    }
    
  final public function debugGetViewVars()
    {
    echo "<h2>ALL VIEW VARS (THIS VARIABLES VAS RETURN TO TEMPLATE)</h2>";
    echo $this->tplFileName(true);
    echo "<pre>";
    print_r($this->vars);
    echo "</pre>";
    die();
    }
    
    
    
    
    
  public function actionGroupOperation()
    {
    $data = $this->input_vars;
    
    $model_name = $this->modname;
    
    switch($data['action_name'])
      {
      case 'delete':
        $this->$model_name->groupActionDelete($data['entities']);
        $this->showMessage($this->t('sys_elements_is_removed'));
        break;
        
      case 'activate':
        $this->$model_name->groupActionActivate($data['entities']);
        $this->showMessage($this->t('sys_elements_is_actived'));
        break;
      
      case 'deactivate':
        $this->$model_name->groupActionDeactivate($data['entities']);
        $this->showMessage($this->t('sys_elements_is_deactived'));
        break;
      
      case 'install':
        $this->$model_name->groupActionInstall($data['entities']);
        $this->showMessage($this->t('sys_elements_is_installed'));
        break;

      default:
        break;
      }
    }
  public function actionDelete($id)
    {
    if(empty($id))
      $this->errors->setError("ID of object is missing!");
    
    $model_name = $this->modname;
    
    $this->$model_name->delete($id);
    $this->showMessage($this->t('sys_element_is_removed'));
    $this->redirect();
    }
    
  public function actionActivation($id)
    {
    if(empty($id))
      $this->errors->setError("ID of user is missing!");
    
    $model_name = $this->modname;
     
    $this->$model_name->activation($id);
    $this->redirect();
    }
  }

