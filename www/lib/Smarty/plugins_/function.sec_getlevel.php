<?php
/*
 * Smarty plugin
 * -------------------------------------------------------------
 * ������� ������� � �������
 * $testobject
 * $assign
 */
function smarty_function_sec_getlevel($params, &$smarty)
{
extract ($params);
$smarty->assign ($assign, sysSecGetLevel ($testobject));
return;
}
?>