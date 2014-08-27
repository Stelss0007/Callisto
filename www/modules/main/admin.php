<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of admin
 *
 * @author Your Name <your.name at your.org>
 */
class AdminController extends Controller
  {
  function actionIndex()
    {
    $this->getAccess(ACCESS_ADMIN);
    
    $browsein[] =array('url'=>"/admin/main", 'displayname'=>  $this->t('dashboard'));
    
    $cache['cache_var_size']  = appFolderSize('./cache/vars');
    $cache['cache_tpl_size']  = appFolderSize('./cache/content');
    $cache['cache_cpl_size']  = appFolderSize('./cache/templates');
    
    $cache['cache_all']       = $cache['cache_var_size'] 
                              + $cache['cache_tpl_size'] 
                              + $cache['cache_cpl_size'];
        
    $this->assign('cache_size', $cache);
    $this->assign('module_browsein', $browsein);
    
    $this->viewPage();
    }
    
  function actionClearCache($type='all')
    {
    $this->getAccess(ACCESS_ADMIN);

    switch($type)
      {
      case 'vars':
        appDirDelete('./cache/vars');
        break;
      case 'templates':
        appDirDelete('./cache/content');
        break;
      case 'compiles':
        appDirDelete('./cache/templates');
        break;

      default:
        appDirDelete('./cache/vars');
        appDirDelete('./cache/content');
        appDirDelete('./cache/templates');
        break;
      }
    
    $this->showMessage($this->t('sys_operation_complate'));
    $this->redirect();
    }
  }

