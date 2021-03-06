<?php
include_once 'kernel/Constants.php';
include_once './lib/PHPMailer/PHPMailerAutoload.php';

appUsesLib('DBConnector');
appUsesLib('UserSession');

function appDebug($value)
{
    echo '<pre>';
    var_dump($value);
    echo '</pre>';
}

function smarty_block_dynamic($param, $content, &$smarty)
{
    return $content;
}

function appIsAssoc($array)
{
    return array_keys($array) !== range(0, count($array) - 1);
}

//Constant Functions
function appGetAccessName($level = false)
{
    $levels = [];
    $levels[ACCESS_INVALID] = 'ACCESS_INVALID';
    $levels[ACCESS_NONE] = 'ACCESS_NONE';
    $levels[ACCESS_OVERVIEW] = 'ACCESS_OVERVIEW';
    $levels[ACCESS_READ] = 'ACCESS_READ';
    $levels[ACCESS_COMMENT] = 'ACCESS_COMMENT';
    $levels[ACCESS_ADD] = 'ACCESS_ADD';
    $levels[ACCESS_EDIT] = 'ACCESS_EDIT';
    $levels[ACCESS_DELETE] = 'ACCESS_DELETE';
    $levels[ACCESS_ADMIN] = 'ACCESS_ADMIN';

    if ($level !== false && $levels[$level]) {
        return $levels[$level];
    }

    return $levels;
}

function appDebugExit($value)
{
    echo "<pre>";
    print_r($value);
    echo "</pre>";
    exit;
}

function appIsAjax()
{

    if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) &&
        !empty($_SERVER['HTTP_X_REQUESTED_WITH']) &&
        strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest'
    ) {
        return true;
    }

    if (\App::$global['route.module'] === 'files' && \App::$global['route.action'] === 'get_list' || ($_SERVER['REQUEST_URI'] == '/admin/files/get_list') || \App::$global['route.type'] == 'api') {
        return true;
    }

    return false;
}

$ses_info = app\lib\UserSession\UserSession::getInstance();

function appGzippedOutput()
{
    $HTTP_ACCEPT_ENCODING = $_SERVER["HTTP_ACCEPT_ENCODING"];
    if (headers_sent()) {
        $encoding = false;
    } else {
        if (strpos($HTTP_ACCEPT_ENCODING, 'x-gzip') !== false) {
            $encoding = 'x-gzip';
        } else {
            if (strpos($HTTP_ACCEPT_ENCODING, 'gzip') !== false) {
                $encoding = 'gzip';
            } else {
                $encoding = false;
            }
        }
    }

    if ($encoding) {
        $contents = ob_get_clean();
        $_temp1 = strlen($contents);
        if ($_temp1 < 2048)    // no need to waste resources in compressing very little data
        {
            print($contents);
        } else {
            header('Content-Encoding: ' . $encoding);
            print("\x1f\x8b\x08\x00\x00\x00\x00\x00");
            $contents = gzcompress($contents, 9);
            $contents = substr($contents, 0, $_temp1);
            print($contents);
        }
    } else {
        ob_end_flush();
    }
}

function appTranslit($string)
{
    $table = [
        'А' => 'A',
        'Б' => 'B',
        'В' => 'V',
        'Г' => 'G',
        'Д' => 'D',
        'Е' => 'E',
        'Ё' => 'YO',
        'Ж' => 'ZH',
        'З' => 'Z',
        'И' => 'I',
        'Й' => 'J',
        'К' => 'K',
        'Л' => 'L',
        'М' => 'M',
        'Н' => 'N',
        'О' => 'O',
        'П' => 'P',
        'Р' => 'R',
        'С' => 'S',
        'Т' => 'T',
        'У' => 'U',
        'Ф' => 'F',
        'Х' => 'H',
        'Ц' => 'C',
        'Ч' => 'CH',
        'Ш' => 'SH',
        'Щ' => 'SCH',
        'Ь' => '',
        'Ы' => 'Y',
        'Ъ' => '',
        'Э' => 'E',
        'Ю' => 'YU',
        'Я' => 'YA',

        'а' => 'a',
        'б' => 'b',
        'в' => 'v',
        'г' => 'g',
        'д' => 'd',
        'е' => 'e',
        'ё' => 'yo',
        'ж' => 'zh',
        'з' => 'z',
        'и' => 'i',
        'й' => 'j',
        'к' => 'k',
        'л' => 'l',
        'м' => 'm',
        'н' => 'n',
        'о' => 'o',
        'п' => 'p',
        'р' => 'r',
        'с' => 's',
        'т' => 't',
        'у' => 'u',
        'ф' => 'f',
        'х' => 'h',
        'ц' => 'c',
        'ч' => 'ch',
        'ш' => 'sh',
        'щ' => 'sch',
        'ь' => '',
        'ы' => 'y',
        'ъ' => '',
        'э' => 'e',
        'ю' => 'yu',
        'я' => 'ya',
    ];

    $output = str_replace(
        array_keys($table),
        array_values($table),
        $string
    );

    // таеже те символы что неизвестны
    $output = preg_replace('/[^-a-z0-9._\[\]\'"]/i', ' ', $output);
    $output = preg_replace('/ +/', '-', $output);

    return $output;
}


function appStrToUrl($str)
{
    // переводим в транслит
    $str = appTranslit($str);
    // в нижний регистр
    $str = strtolower($str);
    // заменям все ненужное нам на "-"
    $str = preg_replace('~[^-a-z0-9_]+~u', '-', $str);
    // удаляем начальные и конечные '-'
    $str = trim($str, "-");

    return $str;
}


/**
 * @desc ??????? ?????????? ?? ???????? ?????
 * @return misc
 */
function appCleanFromInput()
{
    $search = [
        '|</?\s*SCRIPT.*?>|si',
        '|</?\s*FRAME.*?>|si',
        '|</?\s*OBJECT.*?>|si',
        '|</?\s*META.*?>|si',
        '|</?\s*APPLET.*?>|si',
        '|</?\s*LINK.*?>|si',
        '|</?\s*IFRAME.*?>|si',
        '|STYLE\s*=\s*"[^"]*"|si',
    ];

    $replace = [''];

    $resarray = [];
    foreach (func_get_args() as $var) {
        // ???????? ??????????
        global $$var;
        if (empty($var)) {
            return;
        }
        $vars = $$var;
        if (!isset($vars)) {
            array_push($resarray, null);
            continue;
        }
        if (empty($vars)) {
            array_push($resarray, $vars);
            continue;
        }

        // ??????? ??????????
        if (get_magic_quotes_gpc()) {
            appStripslashes($vars);
        }
        $vars = preg_replace($search, $replace, $vars);

        array_push($resarray, $vars);
    }

    // ?????????? ?????????
    if (func_num_args() == 1) {
        return $resarray[0];
    } else {
        return $resarray;
    }
}

/**
 * @desc ??????? ?????????? ?? ???????? ?????
 * @return misc
 */
function appCleanInputArray()
{
    $search = [
        '|</?\s*SCRIPT.*?>|si',
        '|</?\s*FRAME.*?>|si',
        '|</?\s*OBJECT.*?>|si',
        '|</?\s*META.*?>|si',
        '|</?\s*APPLET.*?>|si',
        '|</?\s*LINK.*?>|si',
        '|</?\s*IFRAME.*?>|si',
        '|STYLE\s*=\s*"[^"]*"|si',
    ];

    $replace = [''];

    $input_array = [];
    foreach (func_get_args() as $var) {
        $input_array = array_merge($input_array, $var);
    }

    foreach ($input_array as $key => $value) {
        // ??????? ??????????
        if (get_magic_quotes_gpc()) {
            appStripslashes($value);
        }
        $value = preg_replace($search, $replace, $value);
        $input_array[$key] = $value;
    }

    return $input_array;
}

/**
 * @desc Strip slashes ????????????? ? coreVarCleanFromInput
 * @return misc
 */
function appStripslashes(&$value)
{
    if (!is_array($value)) {
        $value = stripslashes($value);
    } else {
        array_walk($value, 'appStripslashes');
    }
}

function appCp1251Utf8(&$value)
{
    if (!is_array($value)) {
        $value = iconv('cp1251', 'utf-8', $value);
    } else {
        array_walk($value, 'appCp1251Utf8');
    }
}

function appUtf8Cp1251(&$value)
{
    if (!is_array($value)) {
        $value = iconv('utf-8', 'cp1251', $value);
    } else {
        array_walk($value, 'appUtf8Cp1251');
    }
}

function appStrReplaceTemplate($message, $values)
{
    preg_match_all('/%%([0-9A-Za-z_]+)%%/', $message, $matches);

    foreach ($matches[1] as $match) {
        if (isset($values[$match])) {
            $message = str_replace('%%' . $match . '%%', $values[$match], $message);
        } else {
            $message = str_replace('%%' . $match . '%%', '', $message);
        }
    }

    return $message;
}

/********************?????????, ?????????, ?????? *******************/

function appBuildHttpQuery($query)
{
    $query_array = [];
    foreach ($query as $key => $key_value) {
        if (empty($key)) {
            continue;
        }

        $query_array[] = $key . '=' . urlencode($key_value);
    }

    return implode('&', $query_array);
}

function appConvertUrlQuery($query)
{
    $query = parse_url($query, PHP_URL_QUERY);
    $queryParts = explode('&', $query);

    $params = [];
    if ($queryParts) {
        foreach ($queryParts as $param) {
            $item = explode('=', $param);
            if ($item && $item[0]) {
                $params[$item[0]] = (isset($item[1])) ? $item[1] : null;
            }
        }
    }

    return $params;
}

function appUpdateUrlQuery($query, $fields)
{
    if (empty($fields)) {
        return $query;
    }

    $current_fields = appConvertUrlQuery($query);
    foreach ($fields as $key => $value) {
        $current_fields[$key] = $value;
    }
    $curr_url_params = parse_url(appCurrentPageURL());

    return $curr_url_params['scheme'] . '://' . $curr_url_params['host'] . $curr_url_params['path'] . '?' . appBuildHttpQuery(
        $current_fields
    );
}

function appCurrentPageURL()
{
    $pageURL = 'http';
    if (isset($_SERVER["HTTPS"]) && $_SERVER["HTTPS"] == "on") {
        $pageURL .= "s";
    }
    $pageURL .= "://";
    if ($_SERVER["SERVER_PORT"] != "80") {
        $pageURL .= $_SERVER["SERVER_NAME"] . ":" . $_SERVER["SERVER_PORT"] . $_SERVER["REQUEST_URI"];
    } else {
        $pageURL .= $_SERVER["SERVER_NAME"] . $_SERVER["REQUEST_URI"];
    }

    return $pageURL;
}

function appShowMessage($url, $message = '', $time = 1)
{
    global $ses_info;
    $ses_info->setVar('appMsgUrl', $url);
    $ses_info->setVar('appMsgMessage', $message);
    $ses_info->setVar('appMsgTime', $time);
    appRedirect($url);

    exit;
}

;


function appRedirect($redirecturl)
{
    $redirecturl = str_replace('&amp;', '&', $redirecturl);
    if (preg_match('!^http!', $redirecturl)) {
        Header("Location: $redirecturl");
        //return true;
    } else {
        $redirecturl = preg_replace('!^/*!', '', $redirecturl);
        $baseurl = "http://" . appGetBaseURI();
        Header("Location: $baseurl$redirecturl");
    }
    exit;
}


function appGetBaseURI()
{
    global $_SERVER;

    // Start of with REQUEST_URI
    if (isset($_SERVER['REQUEST_URI'])) {
        $path = $_SERVER['REQUEST_URI'];
    } else {
        $path = getenv('REQUEST_URI');
    }
    if ((empty($path)) || (substr($path, -1, 1) == '/')) {
        // REQUEST_URI was empty or pointed to a path
        // Try looking at PATH_INFO
        $path = getenv('PATH_INFO');
        if (empty($path)) {
            // No luck there either
            // Try SCRIPT_NAME
            if (isset($_SERVER['SCRIPT_NAME'])) {
                $path = $_SERVER['SCRIPT_NAME'];
            } else {
                $path = getenv('SCRIPT_NAME');
            }
        }
    }

    $path = preg_replace('/[#\?].*/', '', $path);
    $path = dirname($path);

    if (preg_match('!^[/\\\]*$!', $path)) {
        $path = '';
    }
    $path = $_SERVER['HTTP_HOST'] . '/' . $path;

    return $path;
}


function appCaptureMessage()
{
    global $ses_info;

    $url = $ses_info->getVar('appMsgUrl');
    if (!isset ($url)) {
        return false;//??????? ???? ??? ???????
    };
    //?????? &amp; -> & HTML 4.01 :))
    $url = str_replace('&amp;', '&', $url);

    global $module;
    if (!empty($module) && strstr($url, 'index.php?') && !strstr($url, $module) && !strstr(
            $url,
            str_replace('app_', '', $module)
        )
    ) //?????
    {
        return false;//??????? ???? ??????? ?? ??? ?????? ??????
    };

    //???? ????? ?? ???? ?????????? ???????
    $message = $ses_info->getVar('appMsgMessage');
    $time = $ses_info->getVar('appMsgTime');
    //??????? ?? ?????? ??????????
    $ses_info->delVar('appMsgUrl');
    $ses_info->delVar('appMsgMessage');
    $ses_info->delVar('appMsgTime');
    //??????????? ????????
    header("Refresh: $time;url=$url");
    //????????
    $appTpl = new coreTpl();
    $appTpl->caching = false;
    $appTpl->assign('url', $url);
    $appTpl->assign('message', $message);
    $appTpl->assign('time', $time);
    //??????? ?? ? ??? ? ????? (????? ????)
    //$themename = appUserTheme ();
    //$appTpl->display("themes/test/messages/normal.tpl");
    $appTpl->display("themes/green_test/messages/normal.tpl");
//  $msgcontent = $appTpl->fetch("themes/test/messages/normal.tpl");
//  echo ($msgcontent);
    //????????????? ???????
    exit;
}

/******************** ?????????????? ???? **************************/

function appUsesModule($module_name)
{
    //$module_name = strtolower($module_name);

    $mod_identy_type = 'models_module';

    if (empty($module_name)) {
        return [];
    }
    //Предотвращаем повторные загрузки
    static $loaded = [];
    static $models = [];

    if (!empty($loaded["$module_name"])) {
        return true;
    }

    //Проверим кеш
    if (empty($models) && !appVarIsCached('app', 'models') || \App::$config['debug.enabled']) {
        $models = appGetModelList();
        appVarSetCached('app', 'models', $models);

        if (empty($models[$mod_identy_type][$module_name])) {
            return [];
        }
    } else {
        if (empty($models[$module_name])) {
            $models = appVarGetCached('app', 'models');

            if (empty($models[$mod_identy_type][$module_name])) {
                $models = appGetModelList();

                appVarSetCached('app', 'models', $models);
            }

            if (empty($models[$mod_identy_type][$module_name])) {
                return [];
            }
        }
    }

    foreach ($models[$mod_identy_type][$module_name] as $src) {
        require_once($src);
    }


    $loaded["$module_name"] = true;

    return $models[$mod_identy_type][$module_name];
}

/**
 * Загрузка мсторонних библиотек
 */
function appUsesLib($lib_name = 'extlib', $file = false)
{
    static $loaded = [];

    $file_src = '';
    if ($file) {
        $file = rtrim($file, ".php");
        $file_src = './lib/' . $lib_name . '/' . $file . '.php';
    } else {
        $file_src = './lib/' . $lib_name . '/' . $lib_name . '.class.php';
    }

    if (!empty($loaded["$file_src"])) {
        return true;
    }

    require_once($file_src);

    $loaded["$lib_name"] = true;

    return $file_src;
}

/**
 * Загрузка моделей
 */
function appUsesModel($model_name)
{
    $mod_identy_type = 'models_all';

    if (empty($model_name)) {
        return [];
    }
    //Предотвращаем повторные загрузки
    static $loaded = [];
    static $models = [];

    if (!empty($loaded["$model_name"])) {
        return true;
    }

    //Проверим кеш
    if (empty($models) && !appVarIsCached('app', 'models')) {
        $models = appGetModelList();
        appVarSetCached('app', 'models', $models);

        if (empty($models[$mod_identy_type][$model_name])) {
            return [];
        }
    } else {
        if (empty($models[$model_name])) {
            $models = appVarGetCached('app', 'models');

            if (empty($models[$mod_identy_type][$model_name])) {
                $models = appGetModelList();
                //print_r($models);
                appVarSetCached('app', 'models', $models);
            }
            if (empty($models[$mod_identy_type][$model_name])) {
                return [];
            }
        }
    }

    require_once($models[$mod_identy_type][$model_name]);

    $loaded["$model_name"] = true;

    return ["$model_name" => $models[$mod_identy_type][$model_name]];
}


function appGetModuleSrc(array $mod)
{
    return $mod[appGetModuleName($mod)];
}

function appGetModuleName(array $mod)
{
    return (key($mod));
}

function appGetModuleList()
{
    return appGetDirList('modules');
}

function appGetModelList()
{
    $modules = appGetModuleList();

    $models = [];
    foreach ($modules as $module) {
        $files = appGetFileList(appGetModuleSrc($module) . '/models');
        foreach ($files as $file) {
            $models['models_all'][str_replace('.php', '', appGetModuleName($file))] = appGetModuleSrc($file);
            $models['models_module'][appGetModuleName($module)][str_replace(
                '.php',
                '',
                appGetModuleName($file)
            )] = appGetModuleSrc($file);
            $models['module_model'][appGetModuleName($module) . '.' . str_replace(
                '.php',
                '',
                appGetModuleName($file)
            )] = appGetModuleSrc($file);
        }
    }

    return $models;
}

function appGetDirList($dir_ = null)
{
    //Взяли список с диска
    $dir_list = [];

    if (empty($dir_)) {
        return $dir_list;
    }

    $dir_ = APP_DIRECTORY . '/' . $dir_;

    $dir_handler = opendir($dir_);
    while ($dir = readdir($dir_handler)) {
        if ((is_dir("{$dir_}/$dir")) &&
            ($dir != '.') &&
            ($dir != '..') &&
            ($dir != 'CVS')
        ) {
            // Found
            $dir_list[] = ["$dir" => "{$dir_}/$dir"];
        }
    }
    closedir($dir_handler);

    return $dir_list;
}

function appGetFileList($dir_ = null)
{
    if (empty($dir_)) {
        return;
    }

    //Взяли список с диска
    $file_list = [];

    if (empty($dir_)) {
        return $file_list;
    }

    if (!file_exists($dir_) && !is_dir($dir_)) {
        return $file_list;
    }

    $dir_handler = opendir($dir_);
    while ($dir = readdir($dir_handler)) {
        if ((is_file("{$dir_}/$dir")) &&
            ($dir != '.') &&
            ($dir != '..') &&
            ($dir != 'CVS')
        ) {
            $file_list[] = ["$dir" => "{$dir_}/$dir"];
        }
    }
    closedir($dir_handler);

    return $file_list;
}

function appJsLoad($modname = 'kernel', $scriptname = 'main', $realscriptname = '')
{
    global $jsLoaded;
    global $jsLoadedHasModScript;

    if (empty($scriptname)) {
        $scriptname = 'main';
    }
    if (empty($modname)) {
        $modname = 'kernel';
    }

    if (!empty($jsLoaded["$modname.$scriptname"])) {
        return true;
    }

    if ($modname == 'kernel') {
        if ($scriptname == 'main') {
            $jsLoaded["$modname.$scriptname"] = "/public/js/$scriptname.js";
        } else {
            if (!empty($realscriptname)) {
                $jsLoaded["$modname.$scriptname"] = "/public/js/$scriptname/$realscriptname.js";
            } else {
                $jsLoaded["$modname.$scriptname"] = "/public/js/$scriptname/$scriptname.js";
            }
        }
    } else {
        $jsLoadedHasModScript = 1;
        $jsLoaded["$modname.$scriptname"] = "/modules/$modname/js/$scriptname.js";
    }

    return true;
}

function appCssLoad($modname = '', $scriptname = 'main', $dir = '')
{
    global $cssLoaded;
    global $cssLoadedHasModScript;

    if (empty($scriptname)) {
        $scriptname = 'main';
    }

    if (!empty($cssLoaded["$modname.$scriptname"])) {
        return true;
    }

    if ($modname == 'kernel') {
        if ($scriptname == 'main' || $scriptname == 'bootstrap') {
            $cssLoaded["$modname.$scriptname"] = "/public/css/$scriptname.css";
        } else {
            if (empty($dir)) {
                $cssLoaded["$modname.$scriptname"] = "/public/css/$scriptname/$scriptname.css";
            } else {
                $cssLoaded["$modname.$dir.$scriptname"] = "/public/css/$dir/$scriptname.css";
            }
        }
    } elseif (empty($modname)) {
        global $mod_controller;
        $current_theme = $mod_controller->getThemeName();
        $cssLoaded["theme.$current_theme.$scriptname"] = "/themes/$current_theme/css/$scriptname.css";
    } else {
        $cssLoadedHasModScript = 1;
        $cssLoaded["$modname.$scriptname"] = "/modules/$modname/css/$scriptname.css";
    }

    return true;
}


function appLessLoad($modname = '', $scriptname = 'main', $dir = '')
{
    global $lessLoaded;
    global $lessLoadedHasModScript;

    if (empty($scriptname)) {
        $scriptname = 'main';
    }

    if (!empty($lessLoaded["$modname.$scriptname"])) {
        return true;
    }

    if ($modname == 'kernel') {
        if ($scriptname == 'main' || $scriptname == 'bootstrap') {
            $lessLoaded["$modname.$scriptname"] = "/public/less/$scriptname.less";
        } else {
            if (empty($dir)) {
                $lessLoaded["$modname.$scriptname"] = "/public/less/$scriptname/$scriptname.less";
            } else {
                $lessLoaded["$modname.$dir.$scriptname"] = "/public/less/$dir/$scriptname.less";
            }
        }
    } elseif (empty($modname)) {
        global $mod_controller;
        $current_theme = $mod_controller->getThemeName();
        $lessLoaded["theme.$current_theme.$scriptname"] = "/themes/$current_theme/less/$scriptname.less";
    } else {
        $lessLoadedHasModScript = 1;
        $lessLoaded["$modname.$scriptname"] = "/modules/$modname/less/$scriptname.less";
    }

    return true;
}

function appSassLoad($modname = '', $scriptname = 'main', $dir = '')
{
    global $sassLoaded;
    global $sassLoadedHasModScript;

    if (empty($scriptname)) {
        $scriptname = 'main';
    }

    if (!empty($sassLoaded["$modname.$scriptname"])) {
        return true;
    }

    if ($modname == 'kernel') {
        if ($scriptname == 'main' || $scriptname == 'bootstrap') {
            $sassLoaded["$modname.$scriptname"] = "/public/sass/$scriptname.scss";
        } else {
            if (empty($dir)) {
                $sassLoaded["$modname.$scriptname"] = "/public/sass/$scriptname/$scriptname.scss";
            } else {
                $sassLoaded["$modname.$dir.$scriptname"] = "/public/sass/$dir/$scriptname.scss";
            }
        }
    } elseif (empty($modname)) {
        global $mod_controller;
        $current_theme = $mod_controller->getThemeName();
        $sassLoaded["theme.$current_theme.$scriptname"] = "/themes/$current_theme/sass/$scriptname.scss";
    } else {
        $sassLoadedHasModScript = 1;
        $sassLoaded["$modname.$scriptname"] = "/modules/$modname/sass/$scriptname.scss";
    }

    return true;
}


function appCanEdit($object)
{
    $session_info = UserSession::getInstance();
    appDebugExit($session_info->userId());
}


/*************************  ????????? ****************************\
 * /**
 * @desc ?????????? ??? ????????????? ??????????? ??????
 * @return null
 * @param sender string
 * @param excType integer
 * @param message string
 * @param vars array
 */
function appException($sender, $excType = BAD_PARAM, $message = '', $vars = null)
{
    global $module;
    global $type;
    global $func;
    global $HTTP_SERVER_VARS;
    $uri = $HTTP_SERVER_VARS['REQUEST_URI'];
    $referer = $HTTP_SERVER_VARS['HTTP_REFERER'];

    echo "Caught exception : $message <br>";
    echo "Exception type : $excType<br>";
    echo "Sender : $sender<br><br>";
    echo "Module : $module<br>";
    echo "Module type: $type<br>";
    echo "Funk : $func<br>";

    echo "URI : $uri<br>";
    echo "REFERER : $referer<br>";

    //????? ? ??????
    $vars['module'] = $module;
    $vars['type'] = $type;
    $vars['func'] = $func;

    exit;
}

;


/************************** ?????  *******************************/
//??????? ??? ????? ? ?????????? ? ??????????? ?? ????? ??????

function appBlockShowAll(&$myTpl, &$object)
{
    $db = DBConnector::getInstance();
    $ses_info = UserSession::getInstance();
    $db->query("SELECT * FROM blocks WHERE block_active = '1' ORDER BY block_position, block_weight");
    $db_block_list = $db->fetchArray();
//  echo '????????? ????????:<br><pre>';
//  print_r($object);
//  echo '</pre>';
//  exit;

    $result_blocks = [];
    $result_blocks['left'] = [];
    $result_blocks['right'] = [];
    $result_blocks['top'] = [];
    $result_blocks['bottom'] = [];
    $result_blocks['center'] = [];

    foreach ($db_block_list as $item) {
        //???????? ???????? ?? ???? ???? ??????? ???????
        $pattern = '/' . $item['block_pattern'] . '/iU';
        if (!preg_match($pattern, $object)) {
            continue;
        }

        //? ?????????? ? ????? ????????? - module_object
        $item['module_object'] = $object;

        //???????? ??? ????? ? ?????? ?????????
        $block_content = appBlockRun($item);

        //? ??????????? ?? ?????????
        switch ($item['block_position']) {
            case 'l'://????? ?????
                array_push($result_blocks['left'], $block_content);
                break;
            case 'r':
                array_push($result_blocks['right'], $block_content);
                break;
            case 't':
                array_push($result_blocks['top'], $block_content);
                break;
            case 'b':
                array_push($result_blocks['bottom'], $block_content);
                break;
            case 'c':
                array_push($result_blocks['center'], $block_content);
                break;
        }
    }

    //???????? ? ??????
    $myTpl->assign('blocks', $result_blocks);

    return true;
}

function appBlockRun($block)
{
    $result = [];
    //????????? ???? ?????, ???? ?? ????, ???? ??? ?????? ??????
    $fname = "blocks/$block[block_name]/block.php";
    if (file_exists($fname)) {
        include_once($fname);
    } else {
        $result['block_displayname'] = '???? ?? ??????';
        $result['block_content'] = '???? ?? ??????';

        return $result;
    }
    //???? ??????? ??????????? ??????????? ?????? ?????
    $blockfunc = $block[block_name] . "_display";

    if (function_exists($blockfunc)) {
        $result = $blockfunc($block);
        if (!empty ($result['block_content'])) {
            $result['id'] = $blockinfo['id'];
            $result = array_merge($block, $result);
        }

        return $result;
    } else {
        $result['block_displayname'] = '???? ?? ??????';
        $result['block_content'] = '???? ?? ??????';

        return $result;
    }

}

/************************* ???? **********************************/
function appWeightMax($table, $where = '')
{
    $db = DBConnector::getInstance();
    $db->query("SELECT MAX(weight) as max FROM $table $where");
    $result = $db->fetchArray();
    $maxweight = $result[0]['max'];

    return $maxweight;
}

function appWeightUp($table, $weight, $where = '')
{

    if ($weight == 1) {
        return true;
    }

    $where = str_replace('WHERE', '', $where);
    if ($where != '') {
        $where = " AND $where";
    };

    $db = DBConnector::getInstance();
    $next_weight = $weight--;
    $db->query("SELECT * FROM $table WHERE weight IN ('$weight', '$next_weight') $where ORDER BY weight LIMIT 2");
    $dbresult = $db->fetchArray();

    //????????????
    $dbresult[0][weight]++;
    $dbresult[1][weight]--;

    foreach ($dbresult as $newresult) {
        $db->query("UPDATE $table SET weight = '$newresult[weight]' WHERE id = '$newresult[id]'");
    }

    return true;
}

function appWeightDown($table, $weight, $where = '')
{
    $MaxWeight = appWeightMax($table);
    if ($weight == $MaxWeight) {
        return true;
    }

    $where = str_replace('WHERE', '', $where);

    if ($where != '') {
        $where = " AND $where";
    };

    $db = DBConnector::getInstance();
    $next_weight = $weight++;
    $db->query("SELECT * FROM $table WHERE weight IN ('$weight', '$next_weight') $where ORDER BY weight LIMIT 2");
    $dbresult = $db->fetchArray();

    //????????????
    $dbresult[0][weight]++;
    $dbresult[1][weight]--;

    foreach ($dbresult as $newresult) {
        $db->query("UPDATE $table SET weight = '$newresult[weight]' WHERE id = '$newresult[id]'");
    }

    return true;
}

function appWeightDelete($table, $weight, $where = '')
{
    $where = str_replace('WHERE', '', $where);

    if ($where != '') {
        $where = " AND $where";
    };

    $db = DBConnector::getInstance();
    $db->query("UPDATE $table SET weight = weight-1 WHERE weight >'$weight' $where");

    return true;
}

//////////////////////////////////////////////////////////////////////////////
/////////  CACHE VARS                                               //////////
//////////////////////////////////////////////////////////////////////////////

/**
 * @desc Кеширует переменную
 * @return bool
 * @param component string Модуль к которому относится переменная
 * @param cacheKey string Ключь
 * @param value misc Значение
 */
function appVarSetCached($component, $cacheKey, $value = null, $ttl = null)
{
    //Empty приводим к false
    if (!isset ($value)) {
        $value = false;
    }

    //Удлиняем $cacheKey
    $cacheKey = $component . '_' . $cacheKey;

    //Складываем ключь в память
    \App::$config[$cacheKey] = $value;

    //В зависимости от типа сохраняем кеш в внешнее хранилище
    if (\App::$config['Var.caching'] == 'disk') {
        $cacheKey_crc = (string)abs(crc32($cacheKey));
        $dir_way = './cache/vars/' . $component . '/' . $cacheKey_crc[0] . '/' . $cacheKey_crc[1] . '/';
        if (!file_exists($dir_way)) {
            mkdir($dir_way, \App::$config['default.dir.perms'], true);
        }

        return (file_put_contents($dir_way . $cacheKey, serialize($value), LOCK_EX));
    } elseif (\App::$config['Var.caching'] == 'xcache') {
        if (!$ttl) {
            $ttl = \App::$config['Var.cache_lifetime'];
        }

        return (xcache_set('appVar_' . $cacheKey, $value, $ttl));
    } elseif (\App::$config['Var.caching'] == 'eaccelerator') {
        if (!$ttl) {
            $ttl = \App::$config['Var.cache_lifetime'];
        }

        return (eaccelerator_put('appVar_' . $cacheKey, $value, $ttl));
    } elseif (\App::$config['Var.caching'] == 'apc') {
        if (!$ttl) {
            $ttl = \App::$config['Var.cache_lifetime'];
        }

        return (apc_store('appVar_' . $cacheKey, $value, $ttl));
    }

    return true;
}

/**
 * @desc Извликает переменную из кеша
 * @return misc Значение переменной
 * @param component string Модуль к которому относится переменная
 * @param cacheKey string Ключь
 */
function appVarGetCached($component, $cacheKey)
{
    //Удлиняем $cacheKey
    $cacheKey = $component . '_' . $cacheKey;

    //Если есть ключь в памяти - возвращаем из памяти
    if (isset(\App::$config[$cacheKey])) {
        return \App::$config['appVar_cache'][$cacheKey];
    }

    //В зависимости от типа загружаем кеш из внешнего хранилища
    if (\App::$config['Var.caching'] == 'disk') {
        $cacheKey_crc = (string)abs(crc32($cacheKey));
        $file_way = './cache/vars/' . $component . '/' . $cacheKey_crc[0] . '/' . $cacheKey_crc[1] . '/' . $cacheKey;
        if (file_exists($file_way)) {
            \App::$config['appVar_cache'][$cacheKey] = unserialize(file_get_contents($file_way));
        } else {
            return;
        }
    } elseif (\App::$config['Var.caching'] == 'xcache') {
        \App::$config['appVar_cache'][$cacheKey] = xcache_get('appVar_' . $cacheKey);
    } elseif (\App::$config['appConfig']['Var.caching'] == 'eaccelerator') {
        \App::$config['appVar_cache'][$cacheKey] = eaccelerator_get('appVar_' . $cacheKey);
    } elseif (\App::$config['Var.caching'] == 'apc') {
        $apc_value = apc_fetch('appVar_' . $cacheKey, $success);
        if ($success) {
            \App::$config['appVar_cache'][$cacheKey] = $apc_value;
        }
    }

    if (isset(\App::$config['appVar_cache'][$cacheKey])) {
        return \App::$config['appVar_cache'][$cacheKey];
    } else {
        return;
    }
}

/**
 * @desc Проверяет наличие переменной в кеше
 * @return bool
 * @param component string Модуль к которому относится переменная
 * @param cacheKey string Ключь
 */
function appVarIsCached($component, $cacheKey)
{
    $cache_content = appVarGetCached($component, $cacheKey);
    if (isset($cache_content)) {
        return true;
    }

    return false;
}

/**
 * @desc Удаляет переменную из кеша
 * @return bool
 * @param component string Модуль к которому относится переменная
 * @param cacheKey string Ключь
 */
function appVarDelCached($component, $cacheKey)
{
    if (!appVarIsCached($component, $cacheKey)) {
        return true;
    }

    //Удлиняем $cacheKey
    $cacheKey = $component . '_' . $cacheKey;

    unset(\App::$config['appVar_cache'][$cacheKey]);
    //В зависимости от типа уничтожаем информацию в кеше
    if (\App::$config['Var.caching'] == 'disk') {
        $cacheKey_crc = (string)abs(crc32($cacheKey));
        $file_way = './cache/vars/' . $component . '/' . $cacheKey_crc[0] . '/' . $cacheKey_crc[1] . '/' . $cacheKey;
        @unlink($file_way);
    } elseif (\App::$config['Var.caching'] == 'xcache') {
        xcache_unset('appVar_' . $cacheKey);
    } elseif (\App::$config['Var.caching'] == 'eaccelerator') {
        eaccelerator_rm('appVar_' . $cacheKey);
    } elseif (\App::$config['Var.caching'] == 'apc') {
        apc_delete('appVar_' . $cacheKey);
    }

    return true;
}

function appVarsDelCached($component)
{
    //В зависимости от типа уничтожаем информацию в кеше
    if (\App::$config['Var.caching'] == 'disk') {
        $file_way = './cache/vars/' . $component;
        @unlink($file_way);
    } elseif (\App::$config['Var.caching'] == 'xcache') {
        //xcache_unset('appVar_' . $cacheKey);
    } elseif (\App::$config['Var.caching'] == 'eaccelerator') {
        //eaccelerator_rm('appVar_' . $cacheKey);
    } elseif (\App::$config['Var.caching'] == 'apc') {
        //apc_delete('appVar_' . $cacheKey);
    }

    return true;
}

//////////////////////////////////////////////////////////////////////////////
///////////////////////  FILE SYSTEM /////////////////////////////////////////


function appFolderSize($dir)
{
    $count_size = 0;
    $count = 0;
    $dir_array = scandir($dir);
    foreach ($dir_array as $key => $filename) {
        if ($filename != ".." && $filename != ".") {
            if (is_dir($dir . "/" . $filename)) {
                $new_foldersize = appFolderSize($dir . "/" . $filename);
                $count_size = $count_size + $new_foldersize;
            } else {
                if (is_file($dir . "/" . $filename)) {
                    $count_size = $count_size + filesize($dir . "/" . $filename);
                    $count++;
                }
            }
        }
    }

    return $count_size;
}

/**
 * Удаление директории вместе с ее содержимым
 * @param string $src Путь к директории
 * @param boolean $src Путь к директории
 * @return boolean $parretnRemove Флаг удаление родительской категории, тоесть если false удалиться только содержимое
 */
function appDirDelete($src, $parretnRemove = false)
{
    if (is_file($src)) {
        return @unlink($src);
    } elseif (is_dir($src)) {
        $scan = glob(rtrim($src, '/') . '/*');
        foreach ($scan as $index => $path) {
            appDirDelete($path, true);
        }
        if ($parretnRemove) {
            return @rmdir($src);
        }

        return true;
    }
}

/**
 * Удаление всех файлов в директории
 * @param string $src Путь к директории
 * @return boolean
 */
function appFileDirDelete($src)
{
    $files = glob($src); // get all file names
    foreach ($files as $file) { // iterate files
        if (is_file($file)) {
            unlink($file); // delete file
        }
    }

    return true;
}


function appTreeBuild(&$inArray, $start)
{
    $result = [];
    $child_menu_list = [];
    foreach ($inArray as $key => $menu) {
        $child_menu_list[$menu['id']] = $menu;
    }

    appCreateTree($child_menu_list, $start, 0, -1, $result);

    return $result;
    //exit;
}

function appCreateTree($array, $curParent, $currLevel = 0, $prevLevel = -1, &$result)
{
    foreach ($array as $categoryId => $category) {
        if ($curParent == $category['menu_parent_id']) {
            $category['level'] = $currLevel;
            $result[$categoryId] = $category;
            if ($currLevel > $prevLevel) {
                $prevLevel = $currLevel;
            }

            $currLevel++;

            appCreateTree($array, $categoryId, $currLevel, $prevLevel, $result);

            $currLevel--;
        }

    }

}

function appCreateTreeHTML($array, $curParent, $currLevel = 0, $prevLevel = -1)
{
    foreach ($array as $categoryId => $category) {
        if ($curParent == $category['parent_id']) {
            if ($category['parent_id'] == 0) {
                $class = "dropdown";
            } else {
                $class = "sub_menu";
            }

            if ($currLevel > $prevLevel) {
                echo " <ul class='$class'> ";
            }

            if ($currLevel == $prevLevel) {
                echo " </li> ";
            }

            echo '<li id="' . $categoryId . '" >&lt;a href="' . $category['url'] . '"&gt;' . $category['title'] . '&lt;/a&gt;';

            if ($currLevel > $prevLevel) {
                $prevLevel = $currLevel;
            }

            $currLevel++;

            appCreateTree($array, $categoryId, $currLevel, $prevLevel);

            $currLevel--;
        }

    }
    if ($currLevel == $prevLevel) {
        echo " </li> </ul> ";
    }
}


////////////////////////////////////////////////////////////////////////////////
///////////////////////////// MAIL /////////////////////////////////////////////
function appSendMail($to = 'stelss1986@gmail.com', $subject = 'System Message', $body = 'Hello')
{
    $phpmailer = new PHPMailer();

    $phpmailer->ClearAllRecipients();
    $phpmailer->ClearAttachments();

    // Set the from name and email
    $phpmailer->From = 'admin.site.com';
    $phpmailer->FromName = 'Callisto';

    // Set destination address
    if (isset($to)) {
        $phpmailer->AddAddress($to, $to_name);
    }

    // set bccs if exists
    if ($bcc && is_array($bcc)) {
        foreach ($bcc as $address) {
            $phpmailer->AddBCC($address);
        }
    }

    $phpmailer->Subject = $subject;

    if (!$html) {
        $phpmailer->CharSet = 'utf-8';
        $phpmailer->IsHTML(false);
        if ($param && array_key_exists('altbody', $param)) {
            $phpmailer->AltBody = $param['altbody'];
        }

        $trans_tbl = get_html_translation_table(HTML_ENTITIES);
        $trans_tbl[chr(146)] = '&rsquo;';
        foreach ($trans_tbl as $k => $v) {
            $ttr[$v] = utf8_encode($k);
        }
        $source = strtr($body, $ttr);
        $body = strip_tags($source);
    } else {
        $phpmailer->IsHTML(true);
    }

    $phpmailer->Body = $body;

    if ($files && is_array($files)) {
        foreach ($files as $file) {
            if (isset($file['path'])) {
                $phpmailer->AddAttachment($file['path'], $file['name']);
            }
        }
    }

    // use php's mail
    $phpmailer->IsMail();
    $return = $phpmailer->Send();

    return $return;
}


if (!function_exists('mime_content_type')) {

    function mime_content_type($filename)
    {

        $mime_types = [

            'txt' => 'text/plain',
            'htm' => 'text/html',
            'html' => 'text/html',
            'php' => 'text/html',
            'css' => 'text/css',
            'js' => 'application/javascript',
            'json' => 'application/json',
            'xml' => 'application/xml',
            'swf' => 'application/x-shockwave-flash',
            'flv' => 'video/x-flv',

            // images
            'png' => 'image/png',
            'jpe' => 'image/jpeg',
            'jpeg' => 'image/jpeg',
            'jpg' => 'image/jpeg',
            'gif' => 'image/gif',
            'bmp' => 'image/bmp',
            'ico' => 'image/vnd.microsoft.icon',
            'tiff' => 'image/tiff',
            'tif' => 'image/tiff',
            'svg' => 'image/svg+xml',
            'svgz' => 'image/svg+xml',

            // archives
            'zip' => 'application/zip',
            'rar' => 'application/x-rar-compressed',
            'exe' => 'application/x-msdownload',
            'msi' => 'application/x-msdownload',
            'cab' => 'application/vnd.ms-cab-compressed',

            // audio/video
            'mp3' => 'audio/mpeg',
            'qt' => 'video/quicktime',
            'mov' => 'video/quicktime',

            // adobe
            'pdf' => 'application/pdf',
            'psd' => 'image/vnd.adobe.photoshop',
            'ai' => 'application/postscript',
            'eps' => 'application/postscript',
            'ps' => 'application/postscript',

            // ms office
            'doc' => 'application/msword',
            'rtf' => 'application/rtf',
            'xls' => 'application/vnd.ms-excel',
            'ppt' => 'application/vnd.ms-powerpoint',

            // open office
            'odt' => 'application/vnd.oasis.opendocument.text',
            'ods' => 'application/vnd.oasis.opendocument.spreadsheet',
        ];

        $ext = strtolower(array_pop(explode('.', $filename)));
        if (array_key_exists($ext, $mime_types)) {
            return $mime_types[$ext];
        } elseif (function_exists('finfo_open')) {
            $finfo = finfo_open(FILEINFO_MIME);
            $mimetype = finfo_file($finfo, $filename);
            finfo_close($finfo);

            return $mimetype;
        } else {
            return 'application/octet-stream';
        }
    }
}

function appRoundSize($size)
{
    $i = 0;
    $iec = ["B", "Kb", "Mb", "Gb", "Tb"];
    while (($size / 1024) > 1) {
        $size = $size / 1024;
        $i++;
    }

    return (round($size, 1) . " " . $iec[$i]);
}


function appGetServerLoad()
{
    $load = 0;
    if (stristr(PHP_OS, 'win')) {
        ob_start();
        passthru('typeperf -sc 1 "\processor(_total)\% processor time"', $status);
        $content = ob_get_contents();
        ob_end_clean();
        if ($status === 0) {
            if (preg_match("/\,\"([0-9]+\.[0-9]+)\"/", $content, $sys_load)) {
                $load = $sys_load[0];
            }
        }
    } else {
        $sys_load = sys_getloadavg();
        $load = $sys_load[0];
    }

    return (int)$load;
}

function appRobotList()
{
    return [
        'Google' => 'Google',
        'msnbot' => 'MSN',
        'Rambler' => 'Rambler',
        'Yahoo' => 'Yahoo',
        'AbachoBOT' => 'AbachoBOT',
        'accoona' => 'Accoona',
        'AcoiRobot' => 'AcoiRobot',
        'ASPSeek' => 'ASPSeek',
        'CrocCrawler' => 'CrocCrawler',
        'Dumbot' => 'Dumbot',
        'FAST-WebCrawler' => 'FAST-WebCrawler',
        'GeonaBot' => 'GeonaBot',
        'Gigabot' => 'Gigabot',
        'Lycos' => 'Lycos spider',
        'MSRBOT' => 'MSRBOT',
        'Scooter' => 'Altavista robot',
        'AltaVista' => 'Altavista robot',
        'IDBot' => 'ID-Search Bot',
        'eStyle' => 'eStyle Bot',
        'Scrubby' => 'Scrubby robot',
    ];
}

function appUserIsRobot()
{
    $crawlers = appRobotList();

    foreach ($crawlers as $key => $value) {
        if (stristr($_SERVER['HTTP_USER_AGENT'], $key)) {
            return ($value);
        }
    }

    return false;
}
