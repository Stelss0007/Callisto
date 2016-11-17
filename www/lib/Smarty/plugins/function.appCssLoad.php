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
function smarty_function_appCssLoad($params, &$smarty)
    {
    if(!isset($params['modname'])) {$params['modname'] = '';}
    if(!isset($params['scriptname'])) {$params['scriptname'] = 'main';}
    if(!isset($params['dir'])) {$params['dir'] = '';}
    
    $smarty->appCssLoad($params['modname'], $params['scriptname'], $params['dir']);
    }


?>
