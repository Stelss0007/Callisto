<?php
//Загрузка Js
//modname
//scriptname
function smarty_function_appJsLoad($params, &$smarty)
	{
	appJsLoad($params['modname'], $params['scriptname']);
	}

?>