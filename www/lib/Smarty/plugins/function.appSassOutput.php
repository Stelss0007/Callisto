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
function smarty_function_appSassOutput($params, &$smarty)
  {
  global $sassLoaded, $appConfig, $mod_controller, $cssLoadedHasModScript;
  
  if(empty($sassLoaded))
    return true;
  
  $modname          = $mod_controller->getModName();
  $action           = $mod_controller->getActionName();
  $time             = time();
  
  //appDebugExit($sassLoaded);
  
  appUsesLib('Scssc');
  $scss = new Scssc();
  
  foreach($sassLoaded as $key=>$sassFile) 
    {
    if(appVarIsCached('sassCompiler', $key))
      {
      $cssFile = appVarGetCached('sassCompiler', $key);
      }
    else
      {
      $cssFile = $sassFile.'.'.$time.'.css';
      file_put_contents('.'.$cssFile, $scss->compile(file_get_contents('.'.$sassFile)));
      appVarSetCached('sassCompiler', $key, $cssFile);
      }
    
    echo "<link type='text/css' href='$cssFile' rel='stylesheet'>";
    }
  }

?>
