<?php
/**
 * ??????
 */
class viewTpl extends Smarty
  {
  public $template_file;
  /**
   * Constructor
  **/
  function viewTpl()
    {
    global $appConfig;

    //???????? ??????????? ??????
    //$this->Smarty();
    
    //????????? ???? ?????????? ???????????
    $this->caching_type = $appConfig['coretpl.caching_type'];
    $this->use_sub_dirs = $appConfig['coretpl.use_sub_dirs'];
    $this->cache_lifetime = $appConfig['coretpl.cache_lifetime'];
    if($appConfig['debug.enabled'])
        { 
        //$this->debugging = $appConfig['debug.enabled'];
        $this->setCaching(Smarty::CACHING_LIFETIME_CURRENT);
        $this->force_compile = true;//$appConfig['coretpl.force_compile'];
        }
    else 
        {
        $this->setCaching(Smarty::CACHING_LIFETIME_CURRENT);
        $this->setCacheLifetime($appConfig['coretpl.cache_lifetime']);
        $this->setCompileCheck($appConfig['coretpl.force_compile']);    
        }
    
    //$this->compile_check = $appConfig['coretpl.compile_check'];
    $this->template_dir = '';
    $this->config_dir='';
    $this->cache_dir = 'cache/content';
    $this->compile_dir = 'cache/templates';
    $this->_file_perms  = $appConfig['default.file.perms'];
    $this->_dir_perms = $appConfig['default.dir.perms'];
    $this->cache_lifetime =  $appConfig['coretpl.cache_lifetime'];

    //????????????? ???????? ???????????
//    if ($coreConfig['Var.caching']=='xcache')
//      {
//      include_once('kernel/smarty/plugins/smarty_cache_xcache.php');
//      $this->cache_handler_func = 'smarty_cache_xcache';
//      }
//    elseif ($coreConfig['Var.caching']=='eaccelerator')
//      {
//      include_once('kernel/smarty/plugins/smarty_cache_eaccelerator.php');
//      $this->cache_handler_func = 'smarty_cache_eaccelerator';
//      }
//		elseif ($coreConfig['Var.caching']=='apc')
//      {
//      include_once('kernel/smarty/plugins/smarty_cache_apc.php');
//      $this->cache_handler_func = 'smarty_cache_apc';
//      }

    parent::__construct();
    }
    
    
    
  /**
   * Fetching
   **/
  function fetch ($template = null, $cache_id = null)
    {
    //$this->setCaching(3600);
    //$this->template_file = $template;
 
//    if($this->caching && $this->is_cached($tpl_file, $cache_id ))
    if($this->caching && $this->isCached($template, $cache_id ))
      {
      $this->runCachedScripts();
      }
    
    return (parent::fetch($template, $cache_id));
    }

   
//  /**
//   * ?????????? ?????????? ????????????? ? ?????????????? ????????
//   **/
//  function fetch_cached_vars ()
//    {
//    return ($this->_cache_info[core_tpl_vars]);
//    }
//  /**
//   * DISPLAY
//   **/
//  function display ($tpl_file, $cache_id = null, $compile_id = null)
//    {
//    if (!$tpl_file) coreException ('core_tpl->display', BAD_PARAM, "Tpl file name empty");
//
//    //$coreSecLevel = coreSecGetLevel ($cache_id);
//    $cache_id = str_replace('::', '|', $cache_id);
//    $cache_id.= "|$coreSecLevel";
//    return (Smarty::display($tpl_file, $cache_id, $compile_id));
//    }
  /**
   * clear_cache
  **/
  function clearCache ($tpl_file = null, $cache_id = null, $compile_id = null, $exp_time = null)
    {
    $cache_id = str_replace('::', '|', $cache_id);
    return (Smarty::clear_cache($tpl_file, $cache_id, $compile_id, $exp_time));
    }
  /**
   * is_cached
   **/
  function isCached ($template = null, $cache_id = null, $compile_id = null, $parent = null)
    {
    return (parent::isCached($template, $cache_id, $compile_id, $parent));
    }
   
  function runCachedScripts()
    {

    //Run Cached JS
    $tplScripts = appVarGetCached('templateScripts', 'appJsLoad');
    if(!empty($tplScripts[$this->template_file]))
      foreach($tplScripts[$this->template_file] as $script)
        {
        appJsLoad($script['modname'], $script['scriptname'], $script['realscriptname']);
        }
        
    //Run Cached Css
    $tplScripts = appVarGetCached('templateScripts', 'appCssLoad');
    if(!empty($tplScripts[$this->template_file]))
      foreach($tplScripts[$this->template_file] as $script)
        {
        appCssLoad($script['modname'], $script['scriptname'], $script['dir']);
        }
        
    //Run Cached Less
    $tplScripts = appVarGetCached('templateScripts', 'appLessLoad');
    if(!empty($tplScripts[$this->template_file]))
      foreach($tplScripts[$this->template_file] as $script)
        {
        appLessLoad($script['modname'], $script['scriptname'], $script['dir']);
        }
        
    //Run Cached Less
    $tplScripts = appVarGetCached('templateScripts', 'appSassLoad');
    if(!empty($tplScripts[$this->template_file]))
      foreach($tplScripts[$this->template_file] as $script)
        {
        appSassLoad($script['modname'], $script['scriptname'], $script['dir']);
        }
        
    unset($tplScripts);   
    }
    
  function appJsLoad($modname='kernel', $scriptname='main', $realscriptname='')
    {
    $tplScripts = appVarGetCached('templateScripts', 'appJsLoad');
    $tplScripts[$this->template_file]["$modname.$scriptname.$realscriptname"] = array(
                                                'modname'=>$modname,
                                                'scriptname'=>$scriptname,
                                                'realscriptname'=>$realscriptname
                                                );
        
    appVarSetCached('templateScripts','appJsLoad', $tplScripts);
    unset($tplScripts);
    appJsLoad($modname, $scriptname, $realscriptname);
    }
    
  function appCssLoad($modname='', $scriptname='main', $dir='')
    {
    $tplCss = appVarGetCached('templateScripts', 'appCssLoad');
    $tplCss[$this->template_file]["$modname.$scriptname"] = array(
                                            'modname'=>$modname,
                                            'scriptname'=>$scriptname,
                                            'dir'=>$dir
                                            );
        
    appVarSetCached('templateScripts', 'appCssLoad', $tplCss);
    unset($tplCss);
    appCssLoad($modname, $scriptname, $dir);
    }
    
  function appLessLoad($modname='', $scriptname='main', $dir='')
    {
    $tplCss = appVarGetCached('templateScripts', 'appLessLoad');
    $tplCss[$this->template_file]["$modname.$scriptname"] = array(
                                            'modname'=>$modname,
                                            'scriptname'=>$scriptname,
                                            'dir'=>$dir
                                            );
        
    appVarSetCached('templateScripts', 'appLessLoad', $tplCss);
    unset($tplCss);
    appLessLoad($modname, $scriptname, $dir);
    }
    
  function appSassLoad($modname='', $scriptname='main', $dir='')
    {
    $tplCss = appVarGetCached('templateScripts', 'appSassLoad');
    $tplCss[$this->template_file]["$modname.$scriptname"] = array(
                                            'modname'=>$modname,
                                            'scriptname'=>$scriptname,
                                            'dir'=>$dir
                                            );
        
    appVarSetCached('templateScripts', 'appSassLoad', $tplCss);
    unset($tplCss);
    appSassLoad($modname, $scriptname, $dir);
    }
  }

