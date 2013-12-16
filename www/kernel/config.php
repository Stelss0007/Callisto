<?php

//��������� �������
$appConfig['debug.enabled'] = true;

//��������� ������
$appConfig['lang'] = 'rus';
$appConfig['locale.lc_all'] = 'ru_RU.CP1251';

// ��� ������������ ���� ������
$appConfig['DB.UserName'] = 'root';

// ������ ������������ ���� ������
$appConfig['DB.Password'] = 'root32pass';

// ������ ���� ������
$appConfig['DB.Host'] = 'localhost';

// ��� ���� ������
$appConfig['DB.Name'] = 'test';

// ������� ��� ���� ������
$appConfig['DB.TablePrefix'] = '';

// ���������� ���������� ("none", "disk", "xcache", "apc", "eaccelerator")
$appConfig['Var.caching'] = 'disk';

//����� ����������� ���������� (�������)
$appConfig['Var.cache_lifetime'] = 10800;

//��������� ������ memcache+nginx
$appConfig['memcache.enabled'] = false;
$appConfig['memcache.host'] = '127.0.0.1';
$appConfig['memcache.port'] = 11211;

//��������� E-Tag
$appConfig['etag.enabled'] = false;

//��������� Last-Modified ��� �����������
$appConfig['lastmodified.enabled'] = false;

//����� �� ��������� �� �����
$appConfig['default.file.perms'] = 0755;

//����� �� ��������� �� ����������
$appConfig['default.dir.perms'] = 0755;

//��������� ������������� ��� ����������� �����.
$appConfig['coretpl.use_sub_dirs'] = 1;

//����� ����������� �������� (�������)
$appConfig['coretpl.cache_lifetime'] = 10800;

//������ ����������������� ������� (������ ��� �������)
$appConfig['coretpl.force_compile'] = true;

//���������� �������� � ��������� ��������� ����� _ ������
$appConfig['log.slow_page_time'] = 10.00;

//���������� SQL ������� �� ��������� � ��������� ��������� ����� _ ������
$appConfig['log.slow_page_sql'] = true;

//������ js �������� ������������� �� �����
$appConfig['js.version'] = 10;

//������ css �������� ������������� �� �����
$appConfig['css.version'] = 10;

//��� ��������� ("js", "page")
//"js" ��������� ��������� � ������� ������������ ����
//"page" ��������� ��������� � ������� ��������� �������� (/themes/����/messages/normal.tpl)
$appConfig['Message.type'] = 'js';

?>
