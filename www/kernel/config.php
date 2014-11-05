<?php
//Настройки отладки
$appConfig['debug.enabled'] = true;

//Параметры для форматирования даты поумолчанию
$appConfig['date_format'] = '%d.%m.%Y';
$appConfig['time_format'] = '%H:%M';

$appConfig['date_time_format'] = '%d.%m.%Y в %H:%M';

//Параметры для форматирования даты поумолчанию в javascript (например в datepicker)
$appConfig['date_format_js'] = 'dd.mm.yy';
$appConfig['time_format_js'] = 'H:M';

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

/**
 * КЕШИРОВАНИЕ
 */

//Включение кеширования шаблонов
$appConfig['coretpl.caching'] = true;

//Создавать поддиректории при организации кэшей.
$appConfig['coretpl.use_sub_dirs'] = true;

//Время кэширования шаблонов (секунды)
$appConfig['coretpl.cache_lifetime'] = 10800;

//Всегда проверять шаблоны на измение (только для отладки)
/*
 * Учтите, что если вы присвоите этой переменной значение "false", 
 * и файл шаблона будет изменен, вы *НЕ* увидите изменений в выводе шаблона 
 * до тех пор, пока шаблон не будет перекомпилирован. Если caching и compile_check активированы, 
 * файлы кэша будут регенерированы при обновлении связанных с ним шаблонов или конфигурационных файлов.
 */
$appConfig['coretpl.compile_check'] = false;

//Всегда перекомпилировать шаблоны (только для отладки)
/*
 * Указывает Smarty (пере)компилировать шаблоны при каждом вызове. 
 * Этот параметр перекрывает действие $compile_check и по умолчанию не активирован. 
 */
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

