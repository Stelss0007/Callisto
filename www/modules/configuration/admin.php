<?php
class AdminController extends Controller
  {
  public $defaultAction = 'config_edit';
  
  function configEdit($module = 'main')
    {
    $config_view = $this->root_dir.'modules/'.$module.'/views/default/admin/config.tpl';
    $ObjectName = $module.'::views::default::admin::config';
    if(!file_exists($config_view))
      {
      $this->errors->setError('Config view file "'.$config_view.'" is not exist!');
      }
      
    $this->loadModuleLang($module);  
      
    $this->assign('module_name', $module);
    $this->assign('config_body', $this->smarty->fetch($config_view, $ObjectName));
    
    $browsein   = array();
    $browsein[] = array('url' => "/admin/main", 'displayname' => 'Dashboard');
    $browsein[] = array('url' => '', 'displayname' => 'Files');

    $this->module_browsein = $browsein;
    $this->viewPage();
    }
    
  function saveConfiguration()
    {
    $params = $this->getInput('config');
    print_r($params);
    }
  }
?>
