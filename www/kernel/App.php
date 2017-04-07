<?php

class App
{
    public static $config = [];

    public static $global = [];

    private static function initAutoloader()
    {
        spl_autoload_register(
            function ($class) {
                $namespace = $class;

                $class = explode('\\', $class);

                if (!isset($class[0]) || $class[0] != 'app') {
                    return false;
                }
                unset($class[0]);

                if ($class[1] === 'lib') {
                    $class = implode('/', $class);
                    $class .= '.class.php';
                    include_once $class;

                    return true;
                }

                $class = implode('/', $class);
                include_once $class . '.php';
                AppObject::addModelList($namespace, $class);
            }
        );
    }


    public static function init()
    {
        self::initAutoloader();
        self::$config = require APP_DIRECTORY . '/kernel/Config.php';

        if (self::$config['locale.lc_all']) {
            setlocale(LC_ALL, self::$config['locale.lc_all']);
        } else {
            setlocale(LC_ALL, 'ru_RU.CP1251');
        }

        ignore_user_abort(true);

        if (self::$config['debug.enabled']) {
            error_reporting(E_ALL ^ E_NOTICE);
        } else {
            error_reporting(E_ERROR);
        }

        return true;
    }

    /**
     * Возвращает спиисок языков в системе
     *
     * @return array
     */
    public static function getLangList()
    {
        $langList = [];
        //Доступные языки
        $handle = opendir('lang');
        while ($f = readdir($handle)) {
            if ($f !== '.' && $f !== '..' && $f !== 'CVS' && !ereg("[.]", $f)) {
                //$LangList[$f] = $alllang[$f];
                $langList[$f] = $f;
            }
        }
        closedir($handle);

        //sort($LangList);
        return ($langList);
    }

    /**
     * Возвращает спиисок временных зон
     *
     * @return array
     */
    public static function getTimeZoneList()
    {
        return [
            '0' => '(GMT -12:00 hours) Eniwetok, Kwajalein',
            '1' => '(GMT -11:00 hours) Midway Island, Samoa',
            '2' => '(GMT -10:00 hours) Hawaii',
            '3' => '(GMT -9:00 hours) Alaska',
            '4' => '(GMT -8:00 hours) Pacific Time (US & Canada)',
            '5' => '(GMT -7:00 hours) Mountain Time (US & Canada)',
            '6' => '(GMT -6:00 hours) Central Time (US & Canada), Mexico City',
            '7' => '(GMT -5:00 hours) Eastern Time (US & Canada), Bogota, Lima, Quito',
            '8' => '(GMT -4:00 hours) Atlantic Time (Canada), Caracas, La Paz',
            '8.5' => '(GMT -3:30 hours) Newfoundland',
            '9' => '(GMT -3:00 hours) Brazil, Buenos Aires, Georgetown',
            '10' => '(GMT -2:00 hours) Mid-Atlantic',
            '11' => '(GMT -1:00 hours) Azores, Cape Verde Islands',
            '12' => '(GMT) Western Europe Time, London, Lisbon, Casablanca, Monrovia',
            '13' => '(GMT +1:00 hours) CET(Central Europe Time), Brussels, Copenhagen',
            '14' => '(GMT +2:00 hours) EET(Eastern Europe Time), Kaliningrad, South Africa',
            '15' => '(GMT +3:00 hours) Baghdad, Kuwait, Riyadh, Moscow, St. Petersburg',
            '15.5' => '(GMT +3:30 hours) Tehran',
            '16' => '(GMT +4:00 hours) Abu Dhabi, Muscat, Baku, Tbilisi',
            '16.5' => '(GMT +4:30 hours) Kabul',
            '17' => '(GMT +5:00 hours) Ekaterinburg, Islamabad, Karachi, Tashkent',
            '17.5' => '(GMT +5:30 hours) Bombay, Calcutta, Madras, New Delhi',
            '18' => '(GMT +6:00 hours) Almaty, Dhaka, Colombo',
            '19' => '(GMT +7:00 hours) Bangkok, Hanoi, Jakarta',
            '20' => '(GMT +8:00 hours) Beijing, Perth, Singapore, Hong Kong, Chongqing',
            '21' => '(GMT +9:00 hours) Tokyo, Seoul, Osaka, Sapporo, Yakutsk',
            '21.5' => '(GMT +9:30 hours) Adelaide, Darwin',
            '22' => '(GMT +10:00 hours) EAST(East Australian Standard)',
            '23' => '(GMT +11:00 hours) Magadan, Solomon Islands, New Caledonia',
            '24' => '(GMT +12:00 hours) Auckland, Wellington, Fiji, Kamchatka',
        ];
    }
}

