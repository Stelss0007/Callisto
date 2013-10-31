<?php
/**
 * Smarty {appJsLoad} function plugin
 * @version  1.0
 * @param array
 * @param Smarty
 * $modname                - Название модуля к которому относится скрипт, поумолчанию (kernel), это значит что файл лежит в папке с js скриптами по пути (/public/js/название/название.js).
 *                           Если указано название модуля, то файл лежит по пути /modules/название_модуля/js/название_скрипта.js
 * $scriptname             - Название скрипта, поумолчанию main.js, если модуль kernel, то /public/js/main.js
 * @return string
 */
function smarty_function_appJsLoad($params, &$smarty)
	{
	appJsLoad($params['modname'], $params['scriptname']);
	}

?>