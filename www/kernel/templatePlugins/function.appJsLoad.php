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
        if(!isset($params['modname'])) {$params['modname'] = 'kernel';}
        if(!isset($params['scriptname'])) {$params['scriptname'] = 'main';}
        if(!isset($params['$realscriptname'])) {$params['$realscriptname'] = '';}
    
	$smarty->appJsLoad($params['modname'], $params['scriptname']);
	}

?>