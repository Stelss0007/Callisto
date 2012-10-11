<?php
//Загрузка CSS
//modname
//cssname
function smarty_function_sysCssLoad($params, &$smarty)
	{
	sysCssLoad($params['modname'], $params['cssname']);
	}

?>