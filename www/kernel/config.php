<?php

//Настройки отладки
$coreConfig['debug.enabled'] = false;

//Настройки локали
$coreConfig['locale.lc_all'] = 'ru_RU.CP1251';

// Имя пользователя базы данных
$coreConfig['DB.UserName'] = 'root';

// Пароль пользователя базы данных
$coreConfig['DB.Password'] = '';

// Сервер базы данных
$coreConfig['DB.Host'] = 'localhost';

// Имя базы данных
$coreConfig['DB.Name'] = 'test';

// Префикс для имен таблиц
$coreConfig['DB.TablePrefix'] = '';

// Кэшировать переменные ("none", "disk", "xcache", "apc", "eaccelerator")
$coreConfig['Var.caching'] = 'disk';

//Время кэширования переменных (секунды)
$coreConfig['Var.cache_lifetime'] = 10800;

//Настройки связки memcache+nginx
$coreConfig['memcache.enabled'] = false;
$coreConfig['memcache.host'] = '127.0.0.1';
$coreConfig['memcache.port'] = 11211;

//Настройки E-Tag
$coreConfig['etag.enabled'] = false;

//Настройки Last-Modified для поисковиков
$coreConfig['lastmodified.enabled'] = false;

//Права по умолчанию на файлы
$coreConfig['default.file.perms'] = 0755;

//Права по умолчанию на директории
$coreConfig['default.dir.perms'] = 0755;

//Создавать поддиректории при организации кэшей.
$coreConfig['coretpl.use_sub_dirs'] = 1;

//Время кэширования шаблонов (секунды)
$coreConfig['coretpl.cache_lifetime'] = 10800;

//Всегда перекомпилировать шаблоны (только для отладки)
$coreConfig['coretpl.force_compile'] = true;

//Логировать страницы с временнем генерации более _ секунд
$coreConfig['log.slow_page_time'] = 10.00;

//Логировать SQL запросы на страницах с временнем генерации более _ секунд
$coreConfig['log.slow_page_sql'] = true;

//Версия js скриптов используеммых на сайте
$coreConfig['js.version'] = 10;

//Версия css скриптов используеммых на сайте
$coreConfig['css.version'] = 10;

?>
