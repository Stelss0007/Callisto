<?php
//Count elements in a variable
//var
//pass
//assign
function smarty_function_accesskey($params, &$smarty)
  {
  extract($params);

  // Get (actual) client IP addr
  $ipaddr = $HTTP_SERVER_VARS['REMOTE_ADDR'];
  if (empty($ipaddr)) $ipaddr = getenv('REMOTE_ADDR');

  //—читаем сигнатуру
  $signature = md5 ($pass.$ipaddr);

  $smarty->assign($var, $signature);
  }
?>
