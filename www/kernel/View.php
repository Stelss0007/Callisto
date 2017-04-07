<?php

/**
 * ??????
 */
class ViewTpl extends Smarty
{
    public $template_file;

    /**
     * Constructor
     **/
    public function __construct()
    {
        if (\App::$config['debug.enabled']) {
            //$this->debugging = \App::$config['debug.enabled'];
            $this->setCaching(Smarty::CACHING_LIFETIME_CURRENT);
            $this->force_compile = true;//\App::$config['coretpl.force_compile'];
        } else {
            $this->setCaching(Smarty::CACHING_LIFETIME_CURRENT);
            $this->setCacheLifetime(\App::$config['coretpl.cache_lifetime']);
            $this->setCompileCheck(\App::$config['coretpl.force_compile']);
        }

        //$this->compile_check = \App::$config['coretpl.compile_check'];
        $this->addPluginsDir(APP_DIRECTORY . '/kernel/templatePlugins/');
        $this->setTemplateDir('');
        $this->setConfigDir('');
        $this->setCacheDir('cache/content');
        $this->setCompileDir('cache/templates');
        $this->_file_perms = \App::$config['default.file.perms'];
        $this->_dir_perms = \App::$config['default.dir.perms'];
        $this->cache_lifetime = \App::$config['coretpl.cache_lifetime'];
        $this->caching_type = \App::$config['coretpl.caching_type'];
        $this->use_sub_dirs = \App::$config['coretpl.use_sub_dirs'];


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
    public function fetch($template = null, $cache_id = null)
    {
        //$this->setCaching(3600);
        //$this->template_file = $template;

//    if($this->caching && $this->is_cached($tpl_file, $cache_id ))
        if ($this->caching && $this->isCached($template, $cache_id)) {
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
    public function clearCache($tpl_file = null, $cache_id = null, $compile_id = null, $exp_time = null)
    {
        $cache_id = str_replace('::', '|', $cache_id);

        return (Smarty::clearCache($tpl_file, $cache_id, $compile_id, $exp_time));
    }

    /**
     * is_cached
     **/
    public function isCached($template = null, $cache_id = null, $compile_id = null, $parent = null)
    {
        return (parent::isCached($template, $cache_id, $compile_id, $parent));
    }

    public function runCachedScripts()
    {

        //Run Cached JS
        $tplScripts = appVarGetCached('templateScripts', 'appJsLoad');
        if (!empty($tplScripts[$this->template_file])) {
            foreach ($tplScripts[$this->template_file] as $script) {
                appJsLoad($script['modname'], $script['scriptname'], $script['realscriptname']);
            }
        }

        //Run Cached Css
        $tplScripts = appVarGetCached('templateScripts', 'appCssLoad');
        if (!empty($tplScripts[$this->template_file])) {
            foreach ($tplScripts[$this->template_file] as $script) {
                appCssLoad($script['modname'], $script['scriptname'], $script['dir']);
            }
        }

        //Run Cached Less
        $tplScripts = appVarGetCached('templateScripts', 'appLessLoad');
        if (!empty($tplScripts[$this->template_file])) {
            foreach ($tplScripts[$this->template_file] as $script) {
                appLessLoad($script['modname'], $script['scriptname'], $script['dir']);
            }
        }

        //Run Cached Less
        $tplScripts = appVarGetCached('templateScripts', 'appSassLoad');
        if (!empty($tplScripts[$this->template_file])) {
            foreach ($tplScripts[$this->template_file] as $script) {
                appSassLoad($script['modname'], $script['scriptname'], $script['dir']);
            }
        }

        unset($tplScripts);
    }

    public function appJsLoad($modname = 'kernel', $scriptname = 'main', $realscriptname = '')
    {
        $tplScripts = appVarGetCached('templateScripts', 'appJsLoad');
        $tplScripts[$this->template_file]["$modname.$scriptname.$realscriptname"] = [
            'modname' => $modname,
            'scriptname' => $scriptname,
            'realscriptname' => $realscriptname,
        ];

        appVarSetCached('templateScripts', 'appJsLoad', $tplScripts);
        unset($tplScripts);
        appJsLoad($modname, $scriptname, $realscriptname);
    }

    public function appCssLoad($modname = '', $scriptname = 'main', $dir = '')
    {
        $tplCss = appVarGetCached('templateScripts', 'appCssLoad');
        $tplCss[$this->template_file]["$modname.$scriptname"] = [
            'modname' => $modname,
            'scriptname' => $scriptname,
            'dir' => $dir,
        ];

        appVarSetCached('templateScripts', 'appCssLoad', $tplCss);
        unset($tplCss);
        appCssLoad($modname, $scriptname, $dir);
    }

    public function appLessLoad($modname = '', $scriptname = 'main', $dir = '')
    {
        $tplCss = appVarGetCached('templateScripts', 'appLessLoad');
        $tplCss[$this->template_file]["$modname.$scriptname"] = [
            'modname' => $modname,
            'scriptname' => $scriptname,
            'dir' => $dir,
        ];

        appVarSetCached('templateScripts', 'appLessLoad', $tplCss);
        unset($tplCss);
        appLessLoad($modname, $scriptname, $dir);
    }

    public function appSassLoad($modname = '', $scriptname = 'main', $dir = '')
    {
        $tplCss = appVarGetCached('templateScripts', 'appSassLoad');
        $tplCss[$this->template_file]["$modname.$scriptname"] = [
            'modname' => $modname,
            'scriptname' => $scriptname,
            'dir' => $dir,
        ];

        appVarSetCached('templateScripts', 'appSassLoad', $tplCss);
        unset($tplCss);
        appSassLoad($modname, $scriptname, $dir);
    }
}

