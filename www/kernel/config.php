<?php

//��������� �������
$coreConfig['debug.enabled'] = false;

//��������� ������
$coreConfig['locale.lc_all'] = 'ru_RU.CP1251';

// ��� ������������ ���� ������
$coreConfig['DB.UserName'] = 'root';

// ������ ������������ ���� ������
$coreConfig['DB.Password'] = '';

// ������ ���� ������
$coreConfig['DB.Host'] = 'localhost';

// ��� ���� ������
$coreConfig['DB.Name'] = 'test';

// ������� ��� ���� ������
$coreConfig['DB.TablePrefix'] = '';

// ���������� ���������� ("none", "disk", "xcache", "apc", "eaccelerator")
$coreConfig['Var.caching'] = 'disk';

//����� ����������� ���������� (�������)
$coreConfig['Var.cache_lifetime'] = 10800;

//��������� ������ memcache+nginx
$coreConfig['memcache.enabled'] = false;
$coreConfig['memcache.host'] = '127.0.0.1';
$coreConfig['memcache.port'] = 11211;

//��������� E-Tag
$coreConfig['etag.enabled'] = false;

//��������� Last-Modified ��� �����������
$coreConfig['lastmodified.enabled'] = false;

//����� �� ��������� �� �����
$coreConfig['default.file.perms'] = 0755;

//����� �� ��������� �� ����������
$coreConfig['default.dir.perms'] = 0755;

//��������� ������������� ��� ����������� �����.
$coreConfig['coretpl.use_sub_dirs'] = 1;

//����� ����������� �������� (�������)
$coreConfig['coretpl.cache_lifetime'] = 10800;

//������ ����������������� ������� (������ ��� �������)
$coreConfig['coretpl.force_compile'] = true;

//���������� �������� � ��������� ��������� ����� _ ������
$coreConfig['log.slow_page_time'] = 10.00;

//���������� SQL ������� �� ��������� � ��������� ��������� ����� _ ������
$coreConfig['log.slow_page_sql'] = true;

//������ js �������� ������������� �� �����
$coreConfig['js.version'] = 10;

//������ css �������� ������������� �� �����
$coreConfig['css.version'] = 10;

?>
