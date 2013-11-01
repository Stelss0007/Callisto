<?php

/**
 * Smarty {appCssOutput} function plugin
 * @version  1.0
 * @param array
 * @param Smarty
 * $debug_age       - Время жизни кеш файла в режиме отладки (4с)
 * $age             - Время жизни кеш файла в режиме не отладки (3600с)
 * @return string
 */
function smarty_function_appCssOutput($params, &$smarty)
  {
  global $cssLoaded, $coreConfig, $mod_controller, $cssLoadedHasModScript;
  $modname          = $mod_controller->getModName();
  $params['input']  = $cssLoaded;
  if(isset($cssLoadedHasModScript) && !empty($cssLoadedHasModScript))
    {
    $params['output'] = "/public/cache/$modname.main.css";
    }
  else
    {
    $params['output'] = "/public/cache/main.css";
    }

  if($coreConfig['debug.enabled'])
    {
    if($params['debug_age'])
      {
      $params['age'] = $params['debug_age'];
      }
    else
      {
      $params['age'] = 4;
      }
    }


  if(!function_exists('sfc_print_out_css_nocache'))
    {

    function sfc_print_out_css_nocache($params)
      {
      foreach($params['input'] as $item)
        {
        echo "<link type='text/css' href='$item' rel='stylesheet'>";
        }
      }

    }

  if(!function_exists('sfc_print_out_css'))
    {

    function sfc_print_out_css($params)
      {
      $last_mtime      = file_get_contents($_SERVER['DOCUMENT_ROOT'] . $params['cache_file_name']);
      $output_filename = preg_replace("/\.(css)$/i", date("_YmdHis.", $last_mtime) . "$1", $params['output']);
      echo "<link type='text/css' href='$output_filename' rel='stylesheet'>";
      }

    }



  if(!function_exists('sfc_build_combine_css'))
    {

    function sfc_build_combine_css($params)
      {

      $filelist      = array();
      $lastest_mtime = 0;
      foreach($params['input'] as $item)
        {
        $mtime         = filemtime($_SERVER['DOCUMENT_ROOT'] . $item);
        $lastest_mtime = max($lastest_mtime, $mtime);
        $filelist[]    = array('name' => $item, 'time' => $mtime);
        }
      $last_cmtime = file_get_contents($_SERVER['DOCUMENT_ROOT'] . $params['cache_file_name']);
      if($lastest_mtime > $last_cmtime)
        {
        $glob_mask        = preg_replace("/\.(css)$/i", "_*.$1", $params['output']);
        $files_to_cleanup = glob($_SERVER['DOCUMENT_ROOT'] . $glob_mask);
        foreach($files_to_cleanup as $cfile)
          {
          if(is_file($_SERVER['DOCUMENT_ROOT'] . $cfile) && file_exists($_SERVER['DOCUMENT_ROOT'] . $cfile))
            @unlink($_SERVER['DOCUMENT_ROOT'] . $cfile);
          }
        $output_filename = preg_replace("/\.(css)$/i", date("_YmdHis.", $lastest_mtime) . "$1", $params['output']);
        $fh              = fopen($_SERVER['DOCUMENT_ROOT'] . $output_filename, "a+");
        if(flock($fh, LOCK_EX))
          {
          foreach($filelist as $file)
            {
            fputs($fh, PHP_EOL . PHP_EOL . "/* " . $file['name'] . " @ " . date("c", $file['time']) . " */" . PHP_EOL . PHP_EOL);
            //Получаем содержимое файла исходника и пишем файл кеша
            $buf = file_get_contents($_SERVER['DOCUMENT_ROOT'] . $file['name']);
            //А теперь поменяем все пути с относительных на абсолютные
            $uri_path = dirname($file['name']);
            $buf = preg_replace('/(:?\s*url\s*\()[\'"\s]*([^\/\'"].*)[\'"\s]*\)/isU', '$1' . ($uri_path == '/' ? '/' : $uri_path . '/') . '$2)', $buf);
            //Сохраним результат в файл кеша
            fputs($fh, $buf);
            }
          flock($fh, LOCK_UN);
          file_put_contents($_SERVER['DOCUMENT_ROOT'] . $params['cache_file_name'], $lastest_mtime, LOCK_EX);
          }
        fclose($fh);
        clearstatcache();
        }
      touch($_SERVER['DOCUMENT_ROOT'] . $params['cache_file_name']);
      sfc_print_out_css($params);
      }

    }

  if(!isset($params['cache']) || empty($params['cache']))
    sfc_print_out_css_nocache($params);
  else
  if(isset($params['input']))
    {

    if(is_array($params['input']) && count($params['input']) > 0)
      {

      $ext = pathinfo($params['input'][0], PATHINFO_EXTENSION);
      if(true || in_array($ext, array('js', 'css')))
        {

        $params['type']   = $ext;
        if(!isset($params['output']))
          $params['output'] = dirname($params['input'][0]) . '/combined.' . $ext;

        if(!isset($params['age']))
          $params['age'] = 3600;

        if(!isset($params['cache_file_name']))
          $params['cache_file_name'] = $params['output'] . '.cache';

        $cache_file_name = $params['cache_file_name'];
        if(file_exists($_SERVER['DOCUMENT_ROOT'] . $cache_file_name))
          {
          $cache_mtime = filemtime($_SERVER['DOCUMENT_ROOT'] . $cache_file_name);
          if($cache_mtime + $params['age'] < time())
            {
            sfc_build_combine_css($params);
            }
          else
            {
            sfc_print_out_css($params);
            }
          }
        else
          {
          sfc_build_combine_css($params);
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
      $smarty->_trigger_fatal_error("input must be array and have one item at least");
      return;
      }
    }
  else
    {
    $smarty->_trigger_fatal_error("input cannot be empty");
    return;
    }
  }

?>
