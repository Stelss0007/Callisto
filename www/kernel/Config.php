<?php
return [
    'bootstrap.enabled' => true,
    'admin.path' => 'admin',
    //Настройки отладки
    'debug.enabled' => true,

    //Параметры для форматирования даты поумолчанию
    'date_format' => '%d.%m.%Y',
    'time_format' => '%H:%M',

    'date_time_format' => '%d.%m.%Y в %H:%M',

    //Параметры для форматирования даты поумолчанию в javascript (например в datepicker)
    'date_format_js' => 'dd.mm.yy',
    'time_format_js' => 'H:M',

    //Настройки локали
    'lang' => 'rus',
    'locale.lc_all' => 'ru_RU.CP1251',

    // Имя пользователя базы данных
    'DB.UserName' => 'root',

    // Пароль пользователя базы данных
    'DB.Password' => 'root32pass',
    //'DB.Password' => '',

    // Сервер базы данных
    'DB.Host' => 'localhost',

    // Имя базы данных
    'DB.Name' => 'test',

    // Префикс для имен таблиц
    'DB.TablePrefix' => '',

    // Кэшировать переменные ("none", "disk", "xcache", "apc", "eaccelerator")
    'Var.caching' => 'disk',

    //Время кэширования переменных (секунды)
    'Var.cache_lifetime' => 10800,

    //Настройки связки memcache+nginx
    'memcache.enabled' => false,
    'memcache.host' => '127.0.0.1',
    'memcache.port' => 11211,

    //Настройки E-Tag
    'etag.enabled' => false,

    //Настройки Last-Modified для поисковиков
    'lastmodified.enabled' => false,

    //Права по умолчанию на файлы
    'default.file.perms' => 0755,

    //Права по умолчанию на директории
    'default.dir.perms' => 0755,

    /**
     * КЕШИРОВАНИЕ
     */

    //Включение кеширования шаблонов
    'coretpl.caching' => true,
    //Кешировать шаблоны ('file', 'mysql', 'memcache', 'apc')
    'coretpl.caching_type' => 'file',

    //Создавать поддиректории при организации кэшей.
    'coretpl.use_sub_dirs' => true,

    //Время кэширования шаблонов (секунды)
    'coretpl.cache_lifetime' => 10800,

    //Всегда проверять шаблоны на измение (только для отладки)
    /*
     * Учтите, что если вы присвоите этой переменной значение "false", 
     * и файл шаблона будет изменен, вы *НЕ* увидите изменений в выводе шаблона 
     * до тех пор, пока шаблон не будет перекомпилирован. Если caching и compile_check активированы, 
     * файлы кэша будут регенерированы при обновлении связанных с ним шаблонов или конфигурационных файлов.
     */
    'coretpl.compile_check' => true,
    'coretpl.compile_check' => false,

    //Всегда перекомпилировать шаблоны (только для отладки)
    /*
     * Указывает Smarty (пере)компилировать шаблоны при каждом вызове. 
     * Этот параметр перекрывает действие $compile_check и по умолчанию не активирован. 
     */
    //'coretpl.force_compile' => true, //Переопределено в классе viewTpl (kernel/view.php), Если включен 'debug.enabled' то этот параметр тоже включается


    //Логировать страницы с временнем генерации более _ секунд
    'log.slow_page_time' => 10.00,

    //Логировать SQL запросы на страницах с временнем генерации более _ секунд
    'log.slow_page_sql' => true,

    //Версия js скриптов используеммых на сайте
    'js.version' => 10,

    //Версия css скриптов используеммых на сайте
    'css.version' => 10,

    //Тип сообщений ("js", "page")
    //"js" Сообщение выводится с помощью всплывающего окна
    //"page" Сообщение выводится с помощью отдельной страницы (/themes/тема/messages/normal.tpl)
    'Message.type' => 'page',
    'Message.type' => 'js',

    'gzip' => false,
];