<?php

use app\modules\permissions\models\Permissions;
use app\db\ActiveRecord\Model;

abstract class Controller extends AppObject
{
    /**
     * @var int
     */
    private $startDebugTime;

    /**
     * @var string
     */
    public $defaultAction = '';

    /**
     * @var
     */
    protected $registry;

    /**
     * @var ViewTpl
     */
    protected $smarty;

    /**
     * @var string
     */
    protected $moduleDir;

    /**
     * @var string
     */
    public $rootDir;

    /**
     * @var string
     */
    public $currentTheme;

    /**
     * @var array
     */
    protected $vars = [];

    /**
     * @var string
     */
    protected $objectName;

    /**
     * @var string
     */
    public $type;

    /**
     * @var string
     */
    protected $action;

    /**
     * @var array
     */
    public $inputVars = [];

    /**
     * @var array
     */
    protected $inputVarsClear = [];

    /**
     * @var string
     */
    private $lang;

    /**
     * @var string
     */
    private $langDefault = 'rus';

    /**
     * @var string
     */
    public $controllerName = 'IndexController';

    /**
     * @var int
     */
    public $permissionLavel = 0;

    /**
     * @var
     */
    public $URL;

    /**
     * @var
     */
    public $prevURL;

    /**
     * @var string
     */
    public $referer;

    /**
     * @var string
     */
    protected $lib;

    /**
     * @var string
     */
    protected $page = 'index';

    /**
     * @var array
     */
    protected $block;

    /**
     * @var array
     */
    protected $tpls = [];

    /**
     * @var array
     */
    public $inputFiles;

    /**
     * @var array
     */
    public $inputImages;

    /**
     * @var array
     */
    public $imageSize;

    /**
     * @param $mod
     */
    public function __construct($mod)
    {
        $this->block = [
            'top' => [],
            'left' => [],
            'center' => [],
            'right' => [],
            'bottom' => [],
        ];

        $this->imageSize = [
            ['width' => '640', 'height' => '480'],
            ['width' => '320', 'height' => '150'],
            ['width' => '100', 'height' => '100'],
        ];

        date_default_timezone_set('Europe/Moscow');
        $currentTime = microtime();
        $currentTime = explode(' ', $currentTime);
        $this->startDebugTime = $currentTime[1] + $currentTime[0];

        if (\App::$config['gzip']) {
            ob_start();
            ob_implicit_flush(0);
        }

        //Init Errors
        $this->errors =& ErrorHandler::getInstance();
        $this->rootDir = APP_DIRECTORY . '/';

        define('LIB_DIR', APP_DIRECTORY . '/lib/');
        appUsesLib('DBConnector');
        appUsesLib('UserSession');

        define('KERNEL_DIR', APP_DIRECTORY . '/kernel/');
        require(KERNEL_DIR . 'Block.php');
        require(KERNEL_DIR . 'View.php');

        $this->type = 'user';

        $this->modname = $mod;

        $this->moduleDir = 'modules/' . $this->modname . '/';

        require(KERNEL_DIR . 'Debuger.php');
        if ($this->type !== 'api' && \App::$config['debug.enabled'] && !appIsAjax()) {
            $debugger = &Debuger::getInstance();
            $debugger->startRenderPage();
        }

        //Session init
        $this->sessinInit();
        $this->smarty = new ViewTpl();
        $this->setTheme();

        //SetUp language
        $this->setLang(\App::$config['lang']);
        $this->loadLang();
        $this->loadModuleLang($this->modname);
        $this->setModConfig();
        $this->setTplUserInfo();
        $this->setConfig();
        $this->inputVars = $_REQUEST;
        $this->referer = (isset($_SERVER['HTTP_REFERER'])) ? $_SERVER['HTTP_REFERER'] : '/';

        unset (
            $this->inputVars['module'],
            $this->inputVars['action'],
            $this->inputVars['type'],
            $this->inputVars['PHPSESSID']
        );

        $this->getCurrentURL();
        $this->displayMessage();
    }

    /**
     *
     */
    public function __destruct()
    {
        if ( $this->type !== 'api' && \App::$config['debug.enabled'] && !appIsAjax()) {
            $currentTime = microtime();
            $currentTime = explode(' ', $currentTime);
            $endDebugTime = $currentTime[1] + $currentTime[0];

            $debug_time = $endDebugTime - $this->startDebugTime;

            $debugger = Debuger::getInstance();
            $debugger->endRenderPage();

            $mysqlQueries = [];
            $mysqlQueryCount = 0;
            $mysqlQueryTime = 0;
            foreach ($debugger->mysql as $key => $value) {
                $keySuffix = $key + 1;
                $mysqlQueries['query_' . $keySuffix] = $value;
                $mysqlQueryCount++;
                $mysqlQueryTime += $value['exec_time'];
            }

            $debugger->debugAdd('PHP Execute Time (' . $debug_time . ' sec)', '');
            $debugger->debugAddCreateGroup('Callisto Debug Detail');
            $debugger->debugAdd('Controller: ' . $this->modname, null, INFO);
            $debugger->debugAdd('Action: ' . $this->action, null, INFO);
            $debugger->debugAdd('Object Name: ' . $this->objectName, null, INFO);
            $debugger->debugAdd('Theme: ' . $this->currentTheme, null, INFO);

            $debugger->debugAddCreateGroup('Uses Tpls (' . count($this->tpls) . ')');
            if ($this->tpls) {
                foreach ($this->tpls as $value) {
                    $debugger->debugAdd($value, null, INFO);
                }
            }
            
            $debugger->debugAddEndGroup();

            $debugger->debugAddCreateGroup('Uses Models (' . count(AppObject::$models) . ')');
            if (AppObject::$models) {
                foreach (AppObject::$models as $value) {
                    $debugger->debugAdd($value, null, INFO);
                }
            }
            
            $debugger->debugAddEndGroup();

            $debugger->debugAddCreateGroup('Uses Libs (' . count($this->libs) . ')');
            if ($this->libs) {
                foreach ($this->libs as $value) {
                    $debugger->debugAdd($value, null, WARN);
                }
            } else {
                $debugger->debugAdd('Libraries Are Not Used', null, INFO);
            }
            
            $debugger->debugAddEndGroup();

            
            $debugger->debugAddEndGroup();

            $debugger->debugAddCreateGroup("MySQL ($mysqlQueryCount) $mysqlQueryTime sec");
            $debugger->debugAddDir($mysqlQueries);
            $debugger->debugAddEndGroup();

            $debugger->debugAddCreateGroup('Input Vars (' . count($this->inputVars) . ')');
            $debugger->debugAddDir($this->inputVars);
            $debugger->debugAddEndGroup();

            $debugger->debugAddCreateGroup('Template Vars (' . count($this->vars) . ')');
            $debugger->debugAddDir($this->vars);
            $debugger->debugAddEndGroup();

            $debugger->debugAddCreateGroup('Session (' . count($_SESSION) . ')');
            $debugger->debugAddDir($_SESSION);
            $debugger->debugAddEndGroup();

            //
            $debugger->debugAddCreateGroup('PHP WARNINGS (' . count($debugger->warnings) . ')');
            foreach ($debugger->warnings as $key => $value) {
                $debugger->debugAdd($value, null, WARN);;
            }
            $debugger->debugAddEndGroup();

            $debugger->debugAddCreateGroup('PHP NOTICES (' . count($debugger->notices) . ')');
            foreach ($debugger->notices as $key => $value) {
                $debugger->debugAdd($value, null, INFO);
            }
            $debugger->debugAddEndGroup();

            $debugger->render();
        }

        if (\App::$config['gzip']) {
            appGzippedOutput();
        }
        exit;
    }

    /**
     * @param $name
     * @param $value
     * @return bool
     */
    public function __set($name, $value)
    {
        if (property_exists($this, $name)) {
            $this->$name = $value;

            return true;
        }
        $this->assign($name, $value);

        return true;
    }

    /**
     * @param $name
     */
    public function __isset($name)
    {

    }

    /**
     * @param $name
     */
    public function __get($name)
    {

    }

    /**
     * @param null|array|Object $varName
     * @param string $varValue
     */
    final public function assign($varName = null, $varValue = '')
    {
        if (empty($varName)) {
            return;
        }
        if (is_array($varName)) {
            $this->vars = array_merge($this->vars, $varName);
        } elseif (is_object($varName)) {
            $this->vars[get_class($varName)] = $varName;
        } else {
            $this->vars[$varName] = $varValue;
        }
    }

    /**
     * @param $actionName
     * @return mixed
     */
    final public function action($actionName)
    {
        if (empty($actionName) || $actionName === 'index') {
            if (empty($this->defaultAction)) {
                $actionName = 'index';
            } else {
                $actionName = $this->defaultAction;
            }
        }

        //Заменим - и _ на Большие буквы, тоесть приобразуем урл в Камелкейсподобный вид
        $actionName = $this->urlToCamelCase($actionName);

        if (!method_exists($this, 'action' . $actionName)) {
            $this->errors->setError(
                'Action "' . $actionName . '" is not exist in this module "' . $this->modname . '", conroller "' . $this->controllerName . '"'
            );
        }

        $this->action = $actionName;
        $this->objectName = $this->getObjectName();
        $this->permissionLavel = $GLOBALS['permissionLavel'] = $this->getPermissionLavel($this->objectName);

        if ($this->type === 'admin') {
            $this->smarty->force_compile = true;
        }

        $this->objectName = $this->objectName . '::permission::' . appGetAccessName($this->permissionLavel);

        //Подключим джаваскрипты
        appJsLoad('kernel', 'jQuery');
        appJsLoad('kernel', 'main');

        if ($this->isAdmin()) {
            appJsLoad('kernel', 'jQueryUI');
            appCssLoad('kernel', 'bootstrap');
            appJsLoad('kernel', 'bootstrap');
            appJsLoad('kernel', 'admin');
        } else {
            if (\App::$config['bootstrap.enabled']) {
                appCssLoad('kernel', 'bootstrap');
                appJsLoad('kernel', 'bootstrap');
            }

        }

        //Подключим стили
        appCssLoad('kernel');
        appCssLoad('kernel', 'jQueryUI');

        if ($this->getViewType() !== 'admin') {
            //Без аргументов подключится стиль текущей темы
            appCssLoad();
        }
        $reflectionMethod = new \ReflectionMethod(get_class($this), 'action' . $actionName);
        $reflectionMethodParamethers = $reflectionMethod->getParameters();

        $actionParams = [];
        $this->inputVars;
        foreach ($reflectionMethodParamethers as $key => $param) {
            $name = $param->getName();
            $class = $param->getClass();

            if (!$class) {
                continue;
            }

            if ($class->isSubclassOf(Model::class)) {
                $this->inputVars[$key] = call_user_func([$class->getName(), 'find'], $this->inputVars[$key]);
            }

        }
        $this->inputVars;
        return call_user_func_array([$this, 'action' . $actionName], $this->inputVars);
    }

    /**
     * @param string $type
     */
    final public function setViewType($type = 'user')
    {
        $this->type = $type;
    }

    /**
     * @return string
     */
    final public function getViewType()
    {
        return $this->type;
    }

    /**
     * @param $string
     * @return string
     */
    final private function urlToCamelCase($string)
    {
        return lcfirst(str_replace(' ', '', ucwords(str_replace(['_', '-'], ' ', $string))));
    }

    /**
     * @param null|string $theme
     */
    final public function setTheme($theme = null)
    {
        if ($theme) {
            $this->currentTheme = $theme;
        } else {
            $this->currentTheme = \app\modules\theme\models\Theme::getActiveName();
        }
    }

    /**
     * @return string
     */
    final public function getThemeName()
    {
        return $this->currentTheme;
    }

    /**
     * @return string
     */
    final public function getModName()
    {
        return $this->modname;
    }

    /**
     * @return string
     */
    final public function getActionName()
    {
        return $this->action;
    }

    /**
     *
     */
    final private function setConfig()
    {
        $this->assign('appConfig', \App::$config);
    }

    /**
     * @param $var
     * @return bool
     */
    final public function getConfig($var)
    {
        return isset(\App::$config[$var]) ? \App::$config[$var] : false;
    }

    /**
     * @param string $modName
     * @param string $var
     * @return array|bool
     */
    final public function getModConfig($modName = 'main', $var = '')
    {
        if (empty($var)) {
            return isset(\App::$config[$modName]) ? \App::$config[$modName] : [];
        }

        return isset(\App::$config[$modName][$var]) ? \App::$config[$modName][$var] : false;
    }

    /**
     *
     */
    final private function setModConfig()
    {
        $dbConf = \app\modules\configuration\models\Configuration::getModConfiguration('main');
        if (!empty($dbConf)) {
            \App::$config = array_merge(\App::$config, $dbConf);
            $this->assign($dbConf);

            //Set defaults for module info
            $this->assign('module_meta_description', $dbConf['site_seo_description']);
            $this->assign('module_meta_keywords', $dbConf['site_seo_keywords']);
            $this->assign('module_meta_robots', $dbConf['site_seo_robots']);
            $this->assign('module_page_title', '');
        }
        unset($dbConf);
    }

    /**
     * Проверка пренадлежности пользователя к групе "Администраторы"
     * @return boolean
     */
    final public function isAdmin()
    {
        return $this->session->userGid() === 1;
    }

    /**
     * Определение информации о пользователе
     * @return \Controller
     */
    final private function setTplUserInfo()
    {
        $currentUserInfo['currentUserInfo']['id'] = $this->session->userId();
        $currentUserInfo['currentUserInfo']['name'] = $this->session->userName();
        $currentUserInfo['currentUserInfo']['gid'] = $this->session->userGid();
        $currentUserInfo['currentUserInfo']['isAdmin'] = $this->isAdmin();

        $this->assign($currentUserInfo);

        return $this;
    }

    /**
     * Получение входящих параметров ($_REQUEST)
     * @param array|string $var
     * @param mixed $default
     * @return mixed
     */
    final public function getInput($var, $default = null)
    {
        if (is_array($var)) {
            $array_result = [];
            foreach ($var as $key => $valueKey) {
                if (is_array($valueKey)) {
                    $array_result[$key] = $valueKey;
                    continue;
                }

                if (!is_int($key)) {
                    if (isset($this->inputVars[$key])) {
                        $array_result[$key] = $this->inputVars[$key];
                    } else {
                        $array_result[$key] = $valueKey;
                    }
                } elseif (isset($this->inputVars[$valueKey])) {
                    $array_result[$valueKey] = $this->inputVars[$valueKey];
                } elseif (is_array($default) && isset($default[$valueKey])) {
                    $array_result[$valueKey] = $default[$valueKey];
                } else {
                    $array_result[$valueKey] = null;
                }
            }

            return $array_result;
        }

        if (empty($var)) {
            return $this->inputVars;
        }

        return isset($this->inputVars[$var]) ? $this->inputVars[$var] : $default;
    }

    //////////////////////////////////////////////////////////////////////////////
    ////////////////////////////   TEMPLATES  ////////////////////////////////////
    //////////////////////////////////////////////////////////////////////////////

    /**
     * @param Object|null $pagination
     */
    final public function paginate($pagination = null)
    {
        if (empty($pagination)) {
            return;
        }

        $this->assign('pagination', $pagination);
    }

    /**
     * @return bool
     */
    final public function isCached()
    {
        $tplDir = $this->tplFileName();
        $objectName = $this->getTplObjectName();

        return $this->smarty->isCached($tplDir, $objectName);
    }

    /**
     * @param string|null $objectName
     * @return bool|int
     */
    final public function deleteCache($objectName = null)
    {
        if (!$objectName) {
            $objectName = $this->modname . '|' . $this->type;
        }

//        if (!$objectName) {
//            return false;
//        }

        return $this->smarty->clearCache(null, $objectName);
    }

    /**
     * @return bool
     */
    final public function viewCached()
    {
        $tplDir = $this->tplFileName();
        $objectName = $this->getTplObjectName();

        if (!$this->smarty->isCached($tplDir, $objectName)) {
            return false;
        }

        echo $this->smarty->fetch($tplDir, $objectName);
        exit;
    }

    /**
     * @return bool
     */
    final public function viewCachedPage()
    {
        $tplDir = $this->tplFileName();
        $objectName = $this->getTplObjectName();

        if (!$this->smarty->isCached($tplDir, $objectName)) {
            return false;
        }

        $this->viewPage();

        return true;
    }

    /**
     *
     */
    final public function view()
    {
        $tplDir = $this->tplFileName();
        $this->allVarToTpl();
        $objectName = $this->getTplObjectName();
        echo $this->smarty->fetch($tplDir, $objectName);

        if (!\App::$config['debug.enabled']) {
            $this->__destruct();
        }
    }

    /**
     * Получить значение  из словаря в Smarty (lang.conf)
     * @param string $const Ключ словаря
     * @return string Результат, предложение в текущей локали
     */
    final public function t($const)
    {
        $result = $this->smarty->getConfigVars($const);
        if ($result) {
            return '' . $result;
        }

        return '';
    }

    /**
     *
     */
    final public function viewJSON()
    {
        $obj = $this->vars;
        appCp1251Utf8($obj);
        echo json_encode($obj);
    }

    /**
     * @param null $page_template
     */
    final public function viewPage($page_template = null)
    {
        if ($page_template) {
            $this->page = $page_template;
        }
        $tplDir = $this->tplFileName();
        $this->allVarToTpl();
        $this->blockToTpl();
        $objectName = $this->getTplObjectName();

        //Прикрепим меседж в тело.
        $modContent = $this->message . $this->smarty->fetch($tplDir, $objectName);

        //Если это запрос через AJAX, то выводим только результат работы модуля
        if (appIsAjax()) {
            echo $modContent;
            exit;
        }

        if ($this->type === 'admin') {
            $pageTplFile = $this->rootDir . 'themes/admin/pages/' . $this->page . '.tpl';
            $this->tpls[] = '(Main Template)themes/admin/pages/' . $this->page . '.tpl';

            $this->loadThemeLang('admin');
        } else {
            $pageTplFile = $this->rootDir . 'themes/' . $this->currentTheme . '/pages/' . $this->page . '.tpl';
            $this->tpls[] = '(Main Template)' . 'themes/' . $this->currentTheme . '/pages/' . $this->page . '.tpl';

            $this->loadThemeLang($this->currentTheme);
        }

        $this->smarty->assign('module_content', $modContent);

        $this->smarty->caching = false;
        echo $this->smarty->fetch($pageTplFile);


        if (!\App::$config['debug.enabled']) {
            $this->__destruct();
        }

    }

    /**
     * @param bool $debug
     * @return string
     */
    final public function tplFileName($debug = false)
    {
        $view_file_name = $this->action;
        if ($this->type === 'admin') {
            if (file_exists($this->rootDir . $this->moduleDir . 'views/default/admin/' . $view_file_name . '.tpl')) {
                $this->smarty->assign('viewDir', $this->rootDir . $this->moduleDir . 'views/default/admin/');
                $this->tpls[] = '(Original Module TPL) ' . $this->moduleDir . 'themes/default/admin/' . $view_file_name . '.tpl';

                return $this->rootDir . $this->moduleDir . 'views/default/admin/' . $view_file_name . '.tpl';
            }
            if (!empty($debug)) {
                $this->tpls[] = '(TPL file is not exist!) ' . $this->moduleDir . 'views/default/admin/' . $view_file_name . '.tpl';

                return 'TPL file is not exist! ' . $this->rootDir . $this->moduleDir . 'views/default/admin/' . $view_file_name . '.tpl <br> You most created tpl file <b>"' . $view_file_name . '.tpl"</b> for module <b>' . $this->modname . '</b><br>';
            }

            $this->tpls[] = '(TPL file is not exist!) ' . $this->moduleDir . 'views/default/admin/' . $view_file_name . '.tpl';
            echo 'TPL file is not exist! ' . $this->rootDir . $this->moduleDir . 'views/default/admin/' . $view_file_name . '.tpl <br> You most created tpl file <b>"' . $view_file_name . '.tpl"</b> for module <b>' . $this->modname . '</b><br>';
            echo 'Values for TPL:<br>';
            echo '<pre>';
            var_dump($this->vars);
            echo '</pre>';
            die();

        }

        if (file_exists(
            $this->rootDir . 'themes/' . $this->currentTheme . '/' . $this->moduleDir . $view_file_name . '.tpl'
        )) {
            $this->smarty->assign(
                'viewDir',
                $this->rootDir . 'themes/' . $this->currentTheme . '/' . $this->moduleDir
            );
            $this->tpls[] = '(Overridden by Theme) ' . 'themes/' . $this->currentTheme . '/' . $this->moduleDir . $view_file_name . '.tpl';

            return $this->rootDir . 'themes/' . $this->currentTheme . '/' . $this->moduleDir . $view_file_name . '.tpl';
        }

        if (file_exists($this->rootDir . $this->moduleDir . 'views/default/' . $view_file_name . '.tpl')) {
            $this->smarty->assign('viewDir', $this->rootDir . $this->moduleDir . 'views/default/');
            $this->tpls[] = '(Original Module TPL) ' . $this->moduleDir . 'themes/default/' . $view_file_name . '.tpl';

            return $this->rootDir . $this->moduleDir . 'views/default/' . $view_file_name . '.tpl';
        }

        if (!empty($debug)) {
            $this->tpls[] = '(TPL file is not exist!) ' . $this->moduleDir . 'views/default/' . $view_file_name . '.tpl';

            return 'TPL file is not exist! ' . $this->rootDir . $this->moduleDir . 'views/default/' . $view_file_name . '.tpl <br> You most created tpl file <b>"' . $view_file_name . '.tpl"</b> for module <b>' . $this->modname . '</b><br>';
        }

        $this->tpls[] = '(TPL file is not exist!) ' . $this->moduleDir . 'views/default/' . $view_file_name . '.tpl';
        echo 'TPL file is not exist! ' . $this->rootDir . $this->moduleDir . 'views/default/' . $view_file_name . '.tpl <br> You most created tpl file <b>"' . $view_file_name . '.tpl"</b> for module <b>' . $this->modname . '</b><br>';
        echo 'Values for TPL:<br>';
        echo '<pre>';
        var_dump($this->vars);
        echo '</pre>';
        die();
    }

    /**
     * @param bool $realObjectName
     * @return string
     */
    final public function getObjectName($realObjectName = false)
    {
        $action = $this->action;
        $args = '';
        foreach ($this->inputVars as $key => $value) {
            $args .= '::' . $key . ':' . $value;
        }
        //Only object name without permissions markers
        if ($realObjectName) {
            return $this->modname . '::' . $this->type . '::' . $action . $args;
        }

        return $this->modname . '::' . $this->type . '::' . $action . $args . '::ACCESS_LEVEL_' . $this->permissionLavel;
    }

    final public function getTplObjectName()
    {
        $action = $this->action;
        $args = '';
        if ($this->inputVars) {
            foreach ($this->inputVars as $key => $value) {
                $args .= '|' . $key . ':' . $value;
            }
        }

        return $this->modname . '|' . $this->type . '|' . $action . $args . '|ACCESS_LEVEL_' . $this->permissionLavel;
    }


    //////////////////////////////////////////////////////////////////////////////
    ///////////////////////////// Languages //////////////////////////////////////
    /**
     * @param string $lang
     */
    public function setLang($lang = 'rus')
    {
        $this->lang = $lang;
        $this->assign('lang', $lang);
    }

    /**
     * @return bool
     */
    private function loadLang()
    {
        if (file_exists("lang/$this->lang/lang.conf")) {
            $this->smarty->configLoad("lang/$this->lang/lang.conf");
        } elseif (($this->lang !== $this->langDefault) && file_exists("lang/$this->langDefault/lang.conf")) {
            $this->smarty->configLoad("lang/$this->langDefault/lang.conf");
        }

        return true;
    }

    /**
     * @param string $blockName
     * @return bool
     */
    public function loadBlockLang($blockName)
    {
        if (file_exists("blocks/$blockName/lang/$this->lang/lang.conf")) {
            $this->smarty->configLoad("blocks/$blockName/lang/$this->lang/lang.conf");
        } elseif (($this->lang !== $this->langDefault) && file_exists(
                "blocks/$blockName/lang/$this->langDefault/lang.conf"
            )
        ) {
            $this->smarty->configLoad("blocks/$blockName/lang/$this->langDefault/lang.conf");
        }

        return true;
    }

    /**
     * @param string $themeName
     * @return bool
     */
    private function loadThemeLang($themeName)
    {
        if (file_exists("themes/$themeName/lang/$this->lang/lang.conf")) {
            $this->smarty->configLoad("themes/$themeName/lang/$this->lang/lang.conf");
        } elseif (($this->lang !== $this->langDefault) && file_exists(
                "themes/$themeName/lang/$this->langDefault/lang.conf"
            )
        ) {
            $this->smarty->configLoad("themes/$themeName/lang/$this->langDefault/lang.conf");
        }

        return true;
    }

    /**
     * @param string $moduleName
     * @return bool
     */
    private function loadModuleLang($moduleName)
    {
        if (file_exists("modules/$moduleName/lang/$this->lang/lang.conf")) {
            $this->smarty->configLoad("modules/$moduleName/lang/$this->lang/lang.conf");
        } elseif (($this->lang !== $this->langDefault) && file_exists(
                "modules/$moduleName/lang/$this->langDefault/lang.conf"
            )
        ) {
            $this->smarty->configLoad("modules/$moduleName/lang/$this->langDefault/lang.conf");
        }

        return true;
    }

    //////////////////////////////////////////////////////////////////////////////
    ////////////////////////////   ACCESS     ////////////////////////////////////
    //////////////////////////////////////////////////////////////////////////////

    /**
     * @param string|null $object
     * @return int
     */
    final private function getPermissionLavel($object = null)
    {
        if (!$object) {
            $object = $this->getObjectName();
        }

        return $this->permissionLavel = Permissions::objectGetPermsLevel($object);
    }

    /**
     * @param int $access_type
     * @param bool $admin
     * @return bool
     */
    final public function getAccess($access_type = ACCESS_READ, $admin = true)
    {
        $object = $this->getObjectName();

        if (Permissions::getAccess($object, $access_type) === true) {
            return true;
        }

        $this->notAccess($access_type, $admin);

        return false;
    }

    /**
     * @param int $accessType
     * @param bool $admin
     */
    final public function notAccess($accessType = ACCESS_READ, $admin = false)
    {
        $loggedIn = $this->session->isLogin();
        if (empty($loggedIn)) {
            if ($admin) {
                $this->showMessage($this->t('page_not_access_most_login'), '/admin/users/login');
            } else {
                $this->showMessage($this->t('page_not_access_most_login'), '/users/login');
            }
        }

        $this->errors->setError($this->t('page_not_access'));
    }


    //////////////////////////////////////////////////////////////////////////////
    final public function print_vars()
    {
        echo 'Debuging:<br><pre>';
        print_r($this);
        echo '</pre>';
        exit;
    }

    //////////////////////////////////////////////////////////////////////////////
    ////////////////////////////   URLS       ////////////////////////////////////
    //////////////////////////////////////////////////////////////////////////////

    /**
     * @param string|null $url
     */
    public function setRefferer($url = null)
    {
        if (!$url) {
            $url = $_SERVER['HTTP_REFERER'];
        }

        $this->session->setVar('app_referer', $url);
    }

    /**
     * @param string $url
     * @return \app\lib\UserSession\type|string
     */
    public function getRefferer($url = '/')
    {
        $url_ = $this->session->getVar('app_referer');
        if (!empty($url_)) {
            $url = $url_;
        }

        return $url;
    }

    /**
     * @return string
     */
    public function getCurrentURL()
    {
        if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') {
            $proto = 'https://';
        } else {
            $proto = 'http://';
        }

        $this->URL = $proto . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];

        $this->prevURL = $this->session->getVar('prevURL');
        $this->session->setVar('prevURL', $this->URL);

        return $proto . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
    }

    /**
     * @return array|false|mixed|string
     */
    public function getBaseURI()
    {
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

        return $path;
    }

    /**
     * @param bool $with_path
     * @return string
     */
    public function getBaseURL($with_path = true)
    {
        if (empty($_SERVER['HTTP_HOST'])) {
            $server = getenv('HTTP_HOST');
        } else {
            $server = $_SERVER['HTTP_HOST'];
        }
        if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') {
            $proto = 'https://';
        } else {
            $proto = 'http://';
        }

        if ($with_path) {
            $path = $this->getBaseURI();
        }


        return $proto . $server . $path;
    }


    final public function redirect($url = null, $code = 200)
    {
        static $http = [
            100 => "HTTP/1.1 100 Continue",
            101 => "HTTP/1.1 101 Switching Protocols",
            200 => "HTTP/1.1 200 OK",
            201 => "HTTP/1.1 201 Created",
            202 => "HTTP/1.1 202 Accepted",
            203 => "HTTP/1.1 203 Non-Authoritative Information",
            204 => "HTTP/1.1 204 No Content",
            205 => "HTTP/1.1 205 Reset Content",
            206 => "HTTP/1.1 206 Partial Content",
            300 => "HTTP/1.1 300 Multiple Choices",
            301 => "HTTP/1.1 301 Moved Permanently",
            302 => "HTTP/1.1 302 Found",
            303 => "HTTP/1.1 303 See Other",
            304 => "HTTP/1.1 304 Not Modified",
            305 => "HTTP/1.1 305 Use Proxy",
            307 => "HTTP/1.1 307 Temporary Redirect",
            400 => "HTTP/1.1 400 Bad Request",
            401 => "HTTP/1.1 401 Unauthorized",
            402 => "HTTP/1.1 402 Payment Required",
            403 => "HTTP/1.1 403 Forbidden",
            404 => "HTTP/1.1 404 Not Found",
            405 => "HTTP/1.1 405 Method Not Allowed",
            406 => "HTTP/1.1 406 Not Acceptable",
            407 => "HTTP/1.1 407 Proxy Authentication Required",
            408 => "HTTP/1.1 408 Request Time-out",
            409 => "HTTP/1.1 409 Conflict",
            410 => "HTTP/1.1 410 Gone",
            411 => "HTTP/1.1 411 Length Required",
            412 => "HTTP/1.1 412 Precondition Failed",
            413 => "HTTP/1.1 413 Request Entity Too Large",
            414 => "HTTP/1.1 414 Request-URI Too Large",
            415 => "HTTP/1.1 415 Unsupported Media Type",
            416 => "HTTP/1.1 416 Requested range not satisfiable",
            417 => "HTTP/1.1 417 Expectation Failed",
            500 => "HTTP/1.1 500 Internal Server Error",
            501 => "HTTP/1.1 501 Not Implemented",
            502 => "HTTP/1.1 502 Bad Gateway",
            503 => "HTTP/1.1 503 Service Unavailable",
            504 => "HTTP/1.1 504 Gateway Time-out",
        ];

        if (headers_sent()) {
            die('<script type="text/javascript">window.location=\'' . $url . '\';</script>');
        }

        if (empty($url)) {
            $url = $_SERVER['HTTP_REFERER'];
        }
        if (empty($url)) {
            $url = '/';
        }

        echo $url . ' ';
        $url = str_replace('&amp;', '&', $url);

        if (preg_match('!^http!', $url)) {
            Header($http[$code]);
            Header("Location: $url");
            die();
        } else {
            $with_path = true;
            if ($url[0] == '/') {
                $with_path = false;
            }

            // Removing leading slashes from redirect url
            $url = preg_replace('!^/*!', '', $url);
            // Get base URL
            $baseurl = $this->getBaseURL($with_path);

//      echo $baseurl/$url;
//      die();

            Header($http[$code]);
            Header("Location: $baseurl/$url");
            die();
        }
        exit;
    }

    //////////////////////////////////////////////////////////////////////////////
    //////////////////////   SYSTEM MESSAGES  ////////////////////////////////////
    //////////////////////////////////////////////////////////////////////////////
    final public function showMessage($message = '', $url = '', $data = '', $type = MESSAGE_INFO)
    {
        $this->session->setVar('appMessage', $message);
        $this->session->setVar('appMessageData', $data);
        $this->session->setVar('appRedirectUrl', $url);
        $this->session->setVar('appMessageType', $type);

        if ($url) {
            $this->redirect($url);
        }

        return true;
    }

    final private function displayMessage()
    {
        $message = $this->session->getVar('appMessage');
        $data = $this->session->getVar('appMessageData');
        $url = $this->session->getVar('appRedirectUrl');
        $type = $this->session->getVar('appMessageType');

        //Clean session vars
        $this->session->delVar('appMessage');
        $this->session->delVar('appMessageData');
        $this->session->delVar('appRedirectUrl');
        $this->session->delVar('appMessageType');

        if (!empty($data)) {
            foreach ($data as $key => $value) {
                $this->assign($key, $value);
            }
        }

        if (\App::$config['Message.type'] === 'js') {
            if ($message) {
                $this->message = "<div style='display:none;' id='appMessage_'>
                          <input type='hidden' id='appMessageType' value='$type'>
                          <input type='hidden' id='appMessageText' value='$message'>
                          </div>";

                $this->assign('appMessage', $message);
            }
        } else {
            /////////////////////////////////////////////////////
            /////// Для вывода сообщений в отдельном окне ///////
            if (empty($message)) {
                return;
            }
            if (empty($url)) {
                $url = $this->session->getVar('prevURL');
            }
            $time = 2;
            $this->smarty->caching = false;
            $this->smarty->assign('url', $url);
            $this->smarty->assign('message', $message);
            $this->smarty->assign('time', $time);
            //Смотрим че у нас в сесии (Какая тема)
            $this->smarty->display("themes/green/messages/normal.tpl");
            exit;
        }
    }


    //////////////////////////////////////////////////////////////////////////////
    ////////////////////////////   POST DATA  ////////////////////////////////////
    //////////////////////////////////////////////////////////////////////////////
    final public function getPostData()
    {
        appUsesLib('validateForm');

        $form = new validateForm($_POST);

        $resarray = [];
        $func_args = func_get_args();
        foreach ($func_args as $var) {
            if (is_array($var)) {
                foreach ($var as $key => $value) {
                    //Delete spaces
                    $value = trim($value);
                    //explode by space
                    $validators = explode(' ', $value);

                    foreach ($validators as $validator) {

                        $validator_clean = preg_replace("/[^a-z]/ui", "", $validator);

                        if (method_exists($form, $validator_clean)) {
                            if (preg_match("/min\((.*)\)/sim", $validator, $matches)) {
                                $form->min($matches[1], $key);
                            } elseif (preg_match("/max\((.*)\)/sim", $validator, $matches)) {
                                $form->max($matches[1], $key);
                            } else {
                                $form->$validator($key);
                            }
                        }
                    }

                    if (empty($_POST[$key])) {
                        continue;
                    }

                    $resarray["$key"] = $_POST[$key];
                }
            } else {
                if (empty($_POST[$var])) {
                    continue;
                }

                $resarray["$var"] = $_POST[$var];
            }

            if ($form->pass == true) {
                $ok = true;
            } else {
                $error_msg = $form->allErrors();
                $this->showMessage($error_msg, '', $form->input);
            }

        }

        // Return value or array
        if (func_num_args() == 1) {
            if (is_array($func_args[0]) && count($func_args[0]) == 1) {
                foreach ($resarray as $key => $value) {
                    return $value;
                }
            } else {
                return $resarray;
            }
        } else {
            return $resarray;
        }
    }

    function validate($validateData, $validateRules)
    {
        //Если нет правил для валидации знач возвращаем TRUE (Валидация прошла)
        if (empty($validateRules)) {
            return true;
        }

        appUsesLib('validateForm');

        $form = new validateForm($validateData);

        foreach ($validateRules as $validateField => $validateRule) {
            //Delete spaces
            $validateRule = trim($validateRule);
            //explode by space
            $validators = explode(' ', $validateRule);

            foreach ($validators as $validator) {
                $validator_clean = preg_replace("/[^a-z]/ui", "", $validator);

                if (method_exists($form, $validator_clean)) {
                    if (preg_match("/min\((.*)\)/sim", $validator, $matches)) {
                        $form->min($matches[1], $validateField);
                    } elseif (preg_match("/max\((.*)\)/sim", $validator, $matches)) {
                        $form->max($matches[1], $validateField);
                    } else {
                        $form->$validator($validateField);
                    }
                }
            }
        }

        if ($form->pass == true) {
            return true;
        } else {
            $errors = $form->errorList();

            $error_msg = '<ul>';
            foreach ($errors as $error) {
                $error_msg .= '<li>' . $error . '</li>';
            }
            $error_msg .= '</ul>';
            $this->showMessage($error_msg, '', $form->input);

            return false;
        }
    }


    //////////////////////////////////////////////////////////////////////////////
    ////////////////////////////   BLOCKS     ////////////////////////////////////
    //////////////////////////////////////////////////////////////////////////////

    //Create default block array
    final public function blockAdd($block = 'center', $blockContent)
    {
        array_push($this->block[$block], $blockContent);
    }

    //Add all blocks to tpl
    final public function blockToTpl()
    {
        Block::blockShowAll($this->smarty, $this->getObjectName(true), $this->currentTheme, $this->modname);
        //$this->smarty->assign('blocks', $this->block, false);
    }


    //////////////////////////////////////////////////////////////////////////////
    ////////////////////////////   FILES      ////////////////////////////////////
    //////////////////////////////////////////////////////////////////////////////
    final public function getFile($name = false, $type = false)
    {
        $result = $_FILES;

        if (!empty($type)) {
            $temp = [];
            foreach ($result as $value) {
                if ($value['type'] == $type) {
                    $temp[] = $value;
                }
            }
            $result = $temp;
        }

        if (!empty($name)) {
            $result = $_FILES[$name];
        }

        $this->inputFiles = $result;

        return $result;
    }

    final public function saveFile($id = null, $name = null)
    {
        if (empty($id)) {
            $this->errors->setError('OBJECT ID CAN NOT BE NULL!');
        }
        if (!is_numeric($id)) {
            $this->errors->setError('OBJECT ID CAN BE INTEGER!');
        }

        $type = $this->inputFiles['type'];

        $temp = explode('/', $type);
        $path_files_type = $temp[0] . 's';

        $id8 = sprintf('%08d', $id);

        $path = "files/$path_files_type/{$id8[7]}/{$id8[6]}/$id8/";

        if (!mkdir($path, 0777, true)) {
            $this->errors->setError('Failed to create folders...');
        }

        $ext = substr(strrchr($this->inputFiles['name'], '.'), 1);

        $name = (empty($name)) ? $id8 : $name;

        $dst = $path . $name . '.' . $ext;

        move_uploaded_file($this->inputFiles['tmp_name'], $dst);

        return $dst;
    }

    //////////////////////////////////////////////////////////////////////////////
    ////////////////////////////   IMAGES     ////////////////////////////////////
    //////////////////////////////////////////////////////////////////////////////
    /**
     * Функция получения изображения с формы
     * @param string $name Имя поля получаемого файла
     * @return boolean
     */
    final public function getImage($name = false)
    {
        if (empty($name)) {
            $this->errors->setError('FILE NAME CAN NOT BE NULL!');
        }

        $img_type = ["image/gif", "image/jpeg", "image/png", "image/pjpeg"];

        $result = $_FILES[$name];

        if (empty($result) || $result['error']) {
            return false;
        }

        if (!in_array($result['type'], $img_type)) {
            $this->errors->setError('FILE "' . $name . '" IS NOT EXIST!');
        }

        $this->inputImages = $result;

        return $result;
    }

    /**
     * Функция сохранения файла
     * @param string $poatFileName Имя поля получаемого файла
     * @param integer $id Ид обьекта к которому относится изображение
     * @param string $newName Новое имя сохраняемого файла файла
     * @return string|boolean
     */
    final public function saveImage($poatFileName, $id = null, $newName = null)
    {
        $this->getImage($poatFileName);

        if (empty($this->inputImages)) {
            return false;
        }

        if (empty($id)) {
            $this->errors->setError('OBJECT ID CAN NOT BE NULL!');
        }
        if (!is_numeric($id)) {
            $this->errors->setError('OBJECT ID CAN BE INTEGER!');
        }

        $type = $this->inputImages['type'];

        $temp = explode('/', $type);
        $path_files_type = $temp[0] . 's';

        $id8 = sprintf('%08d', $id);

        $path = "images/{$this->modname}/{$id8[7]}/{$id8[6]}/$id8/";

        if (!is_dir($path)) {
            if (!mkdir($path, 0777, true)) {
                $this->errors->setError('Failed to create folders...');
            }
        }

        $ext = substr(strrchr($this->inputImages['name'], '.'), 1);

        $newName = (empty($newName)) ? $id8 : $newName;

        $dst = $path . $newName . '.' . $ext;

        move_uploaded_file($this->inputImages['tmp_name'], $dst);

        //require LIB_DIR.'Image/Image.class.php';
        appUsesLib('Image');

        $img = new Image();

        $result_files = [];
        $result_files['original'] = $dst;

        foreach ($this->imageSize as $value) {
            $img->load($dst);
            //$img->resize($value['width'], $value['height']);
            $img->resizeToWidth($value['width']);
            $result_files[$value['width']] = $fname = $path . $newName . '_w' . $value['width'] . '.' . $ext;
            $img->save($fname);
        }

        return $result_files;
    }

    final public function getImageSrc($id = null, $w = null, $name = null)
    {
        $id8 = sprintf('%08d', $id);
        $path = "images/" . $this->modname . "/" . $id8[7] . "/" . $id8[6] . "/" . $id8 . "/";


    }

    ///////////////////////////// MOD VARS ///////////////////////////////////////
//  final public function loadModVars($mod='')
//    {
//    if(empty($mod))
//      {
//      return false;
//      }
//    $this->usesModel('modconfig');
//    
//    $vars = $this->modconfig->getVars($mod);
//    $this->mod_vars[$mod] = $vars[$mod];
//    }
//    
//  final public function getModVars($mod='')
//    {
//    if(empty($mod))
//      {
//      return false;
//      }
//    
//    if(empty($this->mod_vars[$mod])) 
//      {
//      $this->loadModVars($mod);
//      }
//    return isset($this->mod_vars[$mod]) ? $this->mod_vars[$mod] : [];
//    }
//    
//  final public function getModVar($mod='', $key='')
//    {
//    if(empty($key) && empty($mod))
//      {
//      return false;
//      }
//    if(empty($key))
//      {
//      $key = $mod;
//      $mod = false;
//      }
//    if(empty($mod))
//      {
//      $mod = $this->modname;
//      }
//    if(empty($this->mod_vars[$mod])) 
//      {
//      $this->loadModVars($mod);
//      }
//    return isset($this->mod_vars[$mod][$key]) ? $this->mod_vars[$mod][$key] : null;
//    }
//    
//  final public function setModVar($mod='', $key='', $var)
//    {
//    if(empty($key) && empty($mod))
//      {
//      return false;
//      }
//    if(func_num_args() == 2)
//      {
//      $mod = false;
//      $key = func_get_arg(0);
//      $var = func_get_arg(1);
//      }
//    if(empty($mod))
//      {
//      $mod = $this->modname;
//      }
//      
//    $this->usesModel('modconfig');
//    
//    $this->modconfig->setVar($mod, $key, $var);
//    $this->loadModVars($mod);
//    return true;
//    }


    //////////////////////////////////////////////////////////////////////////////
    ////////////////////////////   DEBUG      ////////////////////////////////////
    //////////////////////////////////////////////////////////////////////////////
    final public function debugGetModelVars(&$model = null)
    {
        if (empty($model)) {
            $mod = $this->modname;
            $model = &$this->$mod;
        }
        echo "<h2>ALL MODEL VARS (THIS VARIABLES VAS WRITE TO DB)</h2>";
        echo "<pre>";
        print_r($model->vars);
        echo "</pre>";
        die();
    }

    final public function debugGetViewVars()
    {
        echo "<h2>ALL VIEW VARS (THIS VARIABLES VAS RETURN TO TEMPLATE)</h2>";
        echo $this->tplFileName(true);
        echo "<pre>";
        print_r($this->vars);
        echo "</pre>";
        die();
    }


    /**
     * @param $moduleName
     * @return \app\db\ActiveRecord\Model
     */
    public function getDefaultModelForModule($moduleName)
    {
        /** @var \app\db\ActiveRecord\Model $class */
        $class = "\\app\\modules\\{$moduleName}\\models\\" . ucfirst($moduleName);

        return $class;
    }


    public function actionGroupOperation()
    {
        $data = $this->inputVars;

        $class = $this->getDefaultModelForModule($this->modname);

        switch ($data['action_name']) {
            case 'delete':
                $class::groupActionDelete($data['entities']);
                $this->showMessage($this->t('sys_elements_is_removed'));
                break;

            case 'activate':
                $class::groupActionActivate($data['entities']);
                $this->showMessage($this->t('sys_elements_is_actived'));
                break;

            case 'deactivate':
                $class::groupActionDeactivate($data['entities']);
                $this->showMessage($this->t('sys_elements_is_deactived'));
                break;

            case 'install':
                $class::groupActionInstall($data['entities']);
                $this->showMessage($this->t('sys_elements_is_installed'));
                break;

            default:
                break;
        }
    }

    public function actionDelete($id)
    {
        if (empty($id)) {
            $this->errors->setError("ID of object is missing!");
        }

        $class = $this->getDefaultModelForModule($this->modname);

        $object = $class::find($id);
        $object->delete($id);

        $this->showMessage($this->t('sys_element_is_removed'));
        $this->redirect();
    }

    public function actionActivation($id)
    {
        if (empty($id)) {
            $this->errors->setError("ID of user is missing!");
        }

        $class = $this->getDefaultModelForModule($this->modname);

        $object = $class::find($id);
        $object->activation($id);

        $this->redirect();
    }

    public function sendEmail($to, $subject = '', $body = '', $files = [])
    {
        $html = true;

        $phpmailer = new PHPMailer();

        $phpmailer->CharSet = 'utf-8';
        $phpmailer->SMTPAuth = true;
        $phpmailer->SMTPSecure = $this->getConfig('site_smtp_sec');
        $phpmailer->ClearAllRecipients();
        $phpmailer->ClearAttachments();
        // Set the from name and email
        $phpmailer->From = $this->getConfig('site_email_from');
        $phpmailer->FromName = $this->getConfig('site_email_sender');

        // Set destination address
        if (isset($to)) {
            if (is_array($to)) {
                foreach ($to as $value) {
                    $phpmailer->AddAddress($value);
                }
            } else {
                $phpmailer->AddAddress($to);
            }
        }

        // set bccs if exists
//    if($bcc && is_array($bcc))
//      {
//      foreach($bcc as $address)
//        $phpmailer->AddBCC($address);
//      }

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

        //$phpmailer->Body = $body;
        $phpmailer->msgHTML($body, dirname(dirname(__FILE__)));

        if ($files && is_array($files)) {
            foreach ($files as $file) {
                if (isset($file['path'])) {
                    $phpmailer->AddAttachment($file['path'], $file['name']);
                }
            }
        }

        // use php's mail
        switch ($this->getConfig('site_email_type')) {
            case 'phpmail':
                $phpmailer->IsMail();
                break;

            case 'sendmail':
                $phpmailer->isSendmail();
                break;

            case 'smtp':
                $phpmailer->isSMTP();
                $phpmailer->Host = $this->getConfig('site_email_smtp_server');
                //Set the SMTP port number - likely to be 25, 465 or 587
                $phpmailer->Port = $this->getConfig('site_email_smtp_port');
                //Whether to use SMTP authentication
                $phpmailer->SMTPAuth = true;
                //Username to use for SMTP authentication
                $phpmailer->Username = $this->getConfig('site_email_smtp_user');
                //Password to use for SMTP authentication
                $phpmailer->Password = $this->getConfig('site_email_smtp_password');
                break;

            default:
                $phpmailer->IsMail();
                break;
        }


        if (!$phpmailer->Send()) {
            $this->errors->setError("Mailer Error: " . $phpmailer->ErrorInfo);
        }
    }

    public function sendEmailTemplate($to, $subject = '', $template = 'main', $variables = [], $files = [])
    {
        $smartyTpl = new ViewTpl();
        $smartyTpl->assign($variables);
        rtrim($template, '.tpl');
        if (!file_exists($this->rootDir . '/mails/' . $template . '.tpl')) {
            $this->errors->setError("Mailer Error: '{$this->rootDir}/mails/{$template}.tpl' not exist!");
        }

        $this->sendEmail($to, $subject, $smartyTpl->fetch($this->rootDir . '/mails/' . $template . '.tpl'), $files);
    }
}

