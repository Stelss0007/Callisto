<?php
/*
 * Smarty plugin
 * -------------------------------------------------------------
 * File:     function.eightball.php
 * Type:     function
 * Name:     eightball
 * Purpose:  outputs a random magic answer
 * -------------------------------------------------------------
 */
function smarty_function_mod_getvar($params, &$smarty)
{
$result = sysModGetVar ($params[modname], $params[name]);
return $result;
}
?>