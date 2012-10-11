<?php
// Проверяет - залогинелсяли юзер в систему
//assign
function smarty_function_ismodavailable($params, &$smarty)
{
extract($params);
$bool = sysModAvailable($modname);
if($assign)
  $smarty->assign($assign, $bool);
else
  return $bool;

}
?>