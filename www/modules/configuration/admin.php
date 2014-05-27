<?php
class AdminController extends Controller
  {
  public $defaultAction = 'config_edit';
  
  function actionConfigEdit($module = 'main')
    {
    $config_view = $this->root_dir.'modules/'.$module.'/views/default/admin/config.tpl';
    $ObjectName = $module.'::views::default::admin::config';
    if(!file_exists($config_view))
      {
      $this->errors->setError('Config view file "'.$config_view.'" is not exist!');
      }
      
    $this->loadModuleLang($module);  
      
    $timeformat_list['g:i a'] = date("g:i a", time());
    $timeformat_list['g:i:s a'] = date("g:i:s a", time());
    $timeformat_list['H:i'] = date("H:i", time());
    $timeformat_list['H:i:s'] = date("H:i:s", time());
    
    $dateformat_list['Y-m-d'] = date("Y-m-d", time());
    $dateformat_list['d-m-Y'] = date("d-m-Y", time());
    $dateformat_list['d/m/Y'] = date("d/m/Y", time());
    $dateformat_list['m/d/Y'] = date("m/d/Y", time());
    $dateformat_list['d.m.Y'] = date("d.m.Y", time());
    $dateformat_list['d.m.y'] = date("d.m.y", time());
    $dateformat_list['d M Y'] = date("d M Y", time());
    $dateformat_list['d F Y'] = date("d F Y", time());
    
    $this->smarty->assign('site_timeformat_list', $timeformat_list);
    $this->smarty->assign('site_dateformat_list', $dateformat_list);
    
    $this->assign('module_name', $module);
    $this->smarty->assign('modconfig', $this->configuration->getModConfigurationAll());   
    $this->assign('config_body', $this->smarty->fetch($config_view, $ObjectName));
    
    $browsein   = array();
    $browsein[] = array('url' => "/admin/main", 'displayname' => $this->t('dashboard'));
    $browsein[] = array('url' => '', 'displayname' => 'Files');

    $this->module_browsein = $browsein;
    $this->viewPage();
    }
    
  function actionSaveConfiguration()
    {
    $params = $this->getInput('modconfig');
    //appDebug($params);exit;
    foreach($params as $module => $values)
      {
      $this->configuration->saveConfiguration($module, $values);
      }
      
    $this->showMessage($this->t('sys_saved'));
    $this->redirect();
    }
  }

