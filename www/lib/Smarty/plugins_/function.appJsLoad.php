<?php
/**
 * Smarty {appJsLoad} function plugin
 * @version  1.0
 * @param array
 * @param Smarty
 * $modname                - �������� ������ � �������� ��������� ������, ����������� (kernel), ��� ������ ��� ���� ����� � ����� � js ��������� �� ���� (/public/js/��������/��������.js).
 *                           ���� ������� �������� ������, �� ���� ����� �� ���� /modules/��������_������/js/��������_�������.js
 * $scriptname             - �������� �������, ����������� main.js, ���� ������ kernel, �� /public/js/main.js
 * @return string
 */
function smarty_function_appJsLoad($params, &$smarty)
	{
	$smarty->appJsLoad($params['modname'], $params['scriptname']);
	}

?>