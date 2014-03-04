<?php

//Настройки отладки
$appConfig['debug.enabled'] = true;

//Настройки локали
$appConfig['lang'] = 'rus';
$appConfig['locale.lc_all'] = 'ru_RU.CP1251';

// Имя пользователя базы данных
$appConfig['DB.UserName'] = 'root';

// Пароль пользователя базы данных
$appConfig['DB.Password'] = 'root32pass';
//$appConfig['DB.Password'] = '';

// Сервер базы данных
$appConfig['DB.Host'] = 'localhost';

// Имя базы данных
$appConfig['DB.Name'] = 'test';

// Префикс для имен таблиц
$appConfig['DB.TablePrefix'] = '';

// Кэшировать переменные ("none", "disk", "xcache", "apc", "eaccelerator")
$appConfig['Var.caching'] = 'disk';

//Время кэширования переменных (секунды)
$appConfig['Var.cache_lifetime'] = 10800;

//Настройки связки memcache+nginx
$appConfig['memcache.enabled'] = false;
$appConfig['memcache.host'] = '127.0.0.1';
$appConfig['memcache.port'] = 11211;

//Настройки E-Tag
$appConfig['etag.enabled'] = false;

//Настройки Last-Modified для поисковиков
$appConfig['lastmodified.enabled'] = false;

//Права по умолчанию на файлы
$appConfig['default.file.perms'] = 0755;

//Права по умолчанию на директории
$appConfig['default.dir.perms'] = 0755;

//Создавать поддиректории при организации кэшей.
$appConfig['coretpl.use_sub_dirs'] = 1;

//Время кэширования шаблонов (секунды)
$appConfig['coretpl.cache_lifetime'] = 10800;

//Всегда перекомпилировать шаблоны (только для отладки)
$appConfig['coretpl.force_compile'] = true;

//Логировать страницы с временнем генерации более _ секунд
$appConfig['log.slow_page_time'] = 10.00;

//Логировать SQL запросы на страницах с временнем генерации более _ секунд
$appConfig['log.slow_page_sql'] = true;

//Версия js скриптов используеммых на сайте
$appConfig['js.version'] = 10;

//Версия css скриптов используеммых на сайте
$appConfig['css.version'] = 10;

//Тип сообщений ("js", "page")
//"js" Сообщение выводится с помощью всплывающего окна
//"page" Сообщение выводится с помощью отдельной страницы (/themes/тема/messages/normal.tpl)
$appConfig['Message.type'] = 'js';

?>
