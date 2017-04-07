<?php

/**
 * Smarty {appJsOutput} function plugin
 * @version  1.0
 * @param array
 * @param Smarty
 * $debug_age       - ����� ����� ��� ����� � ������ ������� (4�)
 * $age             - ����� ����� ��� ����� � ������ �� ������� (3600�)
 * @return string
 */
function smarty_function_appJsOutput($params, &$smarty)
  {
  global $jsLoaded, $mod_controller, $jsLoadedHasModScript;
  $modname          = $mod_controller->getModName();
  $action           = $mod_controller->getActionName();
  $params['input']  = $jsLoaded;
 
  if(isset($jsLoadedHasModScript) && !empty($jsLoadedHasModScript))
    {
    $params['output'] = "/public/cache/$modname.$action.main.js";
    }
  else
    {
    $params['output'] = "/public/cache/main.js";
    }
 

  if(\App::$config['debug.enabled'])
    {
    if(isset($params['debug_age']) && !empty($params['debug_age']))
      {
      $params['age'] = $params['debug_age'];
      }
    else
      {
      $params['age'] = 4;
      }
    }


  if(!function_exists('sfc_print_out_nocache'))
    {
    function sfc_print_out_nocache($params)
      {
      foreach($params['input'] as $item)
        {
        echo "<script type='text/javascript' src='$item'></script>";
        }
      }

    }

  if(!function_exists('sfc_print_out'))
    {

    function sfc_print_out($params)
      {
      $last_mtime      = file_get_contents(APP_DIRECTORY . $params['cache_file_name']);
      $output_filename = preg_replace("/\.(js|css)$/i", date("_YmdHis.", $last_mtime) . "$1", $params['output']);
      echo "<script type='text/javascript' src='$output_filename'></script>";
      }

    }

  if(!function_exists('sfc_build_combine'))
    {

    function sfc_build_combine($params)
      {
      $filelist      = array();
      $lastest_mtime = 0;
      foreach($params['input'] as $item)
        {
        $mtime         = filemtime(APP_DIRECTORY . $item);
        $lastest_mtime = max($lastest_mtime, $mtime);
        $filelist[]    = array('name' => $item, 'time' => $mtime);
        }
      $last_cmtime = file_get_contents(APP_DIRECTORY . $params['cache_file_name']);
      if($lastest_mtime > $last_cmtime)
        {
        $glob_mask        = preg_replace("/\.(js|css)$/i", "_*.$1", $params['output']);
        $files_to_cleanup = glob(APP_DIRECTORY . $glob_mask);
        foreach($files_to_cleanup as $cfile)
          {
          if(is_file(APP_DIRECTORY . $cfile) && file_exists(APP_DIRECTORY . $cfile))
            @unlink(APP_DIRECTORY . $cfile);
          }
        $output_filename = preg_replace("/\.(js|css)$/i", date("_YmdHis.", $lastest_mtime) . "$1", $params['output']);
        $fh              = fopen(APP_DIRECTORY . $output_filename, "a+");
        if(flock($fh, LOCK_EX))
          {
          foreach($filelist as $file)
            {
            fputs($fh, PHP_EOL . PHP_EOL . "/* " . $file['name'] . " @ " . date("c", $file['time']) . " */" . PHP_EOL . PHP_EOL);
            fputs($fh, file_get_contents(APP_DIRECTORY . $file['name']));
            }
          flock($fh, LOCK_UN);
          file_put_contents(APP_DIRECTORY . $params['cache_file_name'], $lastest_mtime, LOCK_EX);
          }
        fclose($fh);
        clearstatcache();
        }
      touch(APP_DIRECTORY . $params['cache_file_name']);
      sfc_print_out($params);
      }

    }

  if(!isset($params['cache']) || empty($params['cache']))
    sfc_print_out_nocache($params);
  else
  if(isset($params['input']))
    {
    if(is_array($params['input']) && count($params['input']) > 0)
      {
      $ext = pathinfo($params['input'][0], PATHINFO_EXTENSION);
      if(true || in_array($ext, array('js', 'css')))
        {
        $params['type']            = $ext;
        if(!isset($params['output']))
          $params['output']          = dirname($params['input'][0]) . '/combined.' . $ext;
        if(!isset($params['age']))
          $params['age']             = 3600;
        if(!isset($params['cache_file_name']))
          $params['cache_file_name'] = $params['output'] . '.cache';
        $cache_file_name           = $params['cache_file_name'];
        if(file_exists(APP_DIRECTORY . $cache_file_name))
          {
          $cache_mtime = filemtime(APP_DIRECTORY . $cache_file_name);
          if($cache_mtime + $params['age'] < time())
            {
            sfc_build_combine($params);
            }
          else
            {
            sfc_print_out($params);
            }
          }
        else
          {
          sfc_build_combine($params);
          }
        }
      else
        {
        $smarty->_trigger_fatal_error("input file must have js or css extension");
        return;
        }
      }
    else
      {
      //$smarty->_trigger_fatal_error("input must be array and have one item at least");
      return;
      }
    }
  else
    {
    //$smarty->_trigger_fatal_error("input cannot be empty");
    return;
    }
  }

?>
