<?php
/**
 * ??????
 */
class viewTpl extends Smarty
  {
  /**
   * Constructor
  **/
  function viewTpl()
    {
    global $appConfig;

    //???????? ??????????? ??????
    $this->Smarty();
    //????????? ???? ?????????? ???????????
    $this->debugging = false;
    $this->caching = $appConfig['coretpl.caching'];
    $this->use_sub_dirs = $appConfig['coretpl.use_sub_dirs'];
    $this->force_compile = $appConfig['coretpl.force_compile'];
    $this->compile_check = $appConfig['coretpl.compile_check'];
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


    }
  /**
   * Fetching
   **/
//  function fetch ($tpl_file, $cache_id = null, $vars = null, $compile_id = null, $display = false)
//    {
////    if (!$tpl_file)
////			coreException ('core_tpl->fetch', BAD_PARAM, "Tpl file name empty (\$coreObject = $cache_id)");
//
////    if ($cache_id)
////      {//???? ? ??? ???????? ?? ????????, ??????? ??????????????
////      $coreSecLevel = $this->get_template_vars('curuser_sec_level');
////      if (!isset($coreSecLevel)) //???? ??????? ??????? ?? ??????? - ?????????? ????
////        {
////        //$coreSecLevel = coreSecGetLevel ($cache_id);
////        $coreSecLevel = 1;
////        $this->assign('curuser_sec_level', $coreSecLevel);
////        }
////      $this->assign('coreObject', $cache_id);
////
////      $cache_id = str_replace('::', '|', $cache_id);
////      $cache_id.= "|$coreSecLevel";
////      }
////    $this->_core_tpl_vars = $vars;
//    return (Smarty::fetch($tpl_file, $cache_id, $compile_id, $display));
//    }
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
  function clear_cache ($tpl_file = null, $cache_id = null, $compile_id = null, $exp_time = null)
    {
    $cache_id = str_replace('::', '|', $cache_id);
    return (Smarty::clear_cache($tpl_file, $cache_id, $compile_id, $exp_time));
    }
  /**
   * is_cached
   **/
  function is_cached ($tpl_file, $cache_id = null, $compile_id = null)
    {
    if (!$tpl_file) appException ('core_tpl->is_cached', BAD_PARAM, "Tpl file name empty");

    //echo $tpl_file.' '.$cache_id;
    return (Smarty::is_cached($tpl_file, $cache_id, $compile_id));
    }

  }
?>
