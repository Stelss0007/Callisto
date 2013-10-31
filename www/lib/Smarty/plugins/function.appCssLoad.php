<?php
/**
 * Smarty {appCssLoad} function plugin
 * @version  1.0
 * @param array
 * @param Smarty
 * $modname                - Название модуля к которому относится скрипт, поумолчанию (kernel), это значит что файл лежит в папке с css скриптами по пути (/public/css/название/название.css).
 *                           Если указано название модуля, то файл лежит по пути /modules/название_модуля/css/название_скрипта.css
 * $scriptname             - Название скрипта, поумолчанию main.css, если модуль kernel, то /public/js/main.css
 * @return string
 */
function smarty_function_appCssLoad($params, &$smarty)
	{
	appCssLoad($params['modname'], $params['scriptname']);
	}


?>
