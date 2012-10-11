<?php
//Загрузка Js
//modname
//scriptname
function smarty_function_sysJsLoad($params, &$smarty)
	{
	sysJsLoad($params['modname'], $params['scriptname']);
	}

?>