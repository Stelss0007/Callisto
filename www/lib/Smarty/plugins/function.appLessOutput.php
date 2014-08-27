<?php

/**
 * Smarty {appCssOutput} function plugin
 * @version  1.0
 * @param array
 * @param Smarty
 * $debug_age       - ����� ����� ��� ����� � ������ ������� (4�)
 * $age             - ����� ����� ��� ����� � ������ �� ������� (3600�)
 * @return string
 */
function smarty_function_appLessOutput($params, &$smarty)
  {
  global $lessLoaded, $appConfig, $mod_controller, $cssLoadedHasModScript;
  
  if(empty($lessLoaded))
    return true;
  
  $modname          = $mod_controller->getModName();
  $action           = $mod_controller->getActionName();
  $time             = time();
  
  //appDebugExit($lessLoaded);
  
  appUsesLib('LessCompiler');
  $less = new LessCompiler();
  
  foreach($lessLoaded as $key=>$lessFile) 
    {
    if(appVarIsCached('lessCompiler', $key))
      {
      $cssFile = appVarGetCached('lessCompiler', $key);
      }
    else
      {
      $cssFile = $lessFile.'.'.$time.'.css';
      $less->checkedCompile('.'.$lessFile, '.'.$cssFile);
      appVarSetCached('lessCompiler', $key, $cssFile);
      }
    
    echo "<link type='text/css' href='$cssFile' rel='stylesheet'>";
    }
  }

?>
