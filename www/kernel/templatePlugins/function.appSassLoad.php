<?php
/**
 * Smarty {appCssLoad} function plugin
 * @version  1.0
 * @param array
 * @param Smarty
 * $modname                - �������� ������ � �������� ��������� ������, ����������� (kernel), ��� ������ ��� ���� ����� � ����� � css ��������� �� ���� (/public/css/��������/��������.css).
 *                           ���� ������� �������� ������, �� ���� ����� �� ���� /modules/��������_������/css/��������_�������.css
 * $scriptname             - �������� �������, ����������� main.css, ���� ������ kernel, �� /public/js/main.css
 * @return string
 */
function smarty_function_appSassLoad($params, &$smarty)
	{
	$smarty->appSassLoad($params['modname'], $params['scriptname'], $params['dir']);
	}

