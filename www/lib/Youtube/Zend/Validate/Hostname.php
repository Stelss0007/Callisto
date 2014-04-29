<?php

/**

 * Zend Framework

 *

 * LICENSE

 *

 * This source file is subject to the new BSD license that is bundled

 * with this package in the file LICENSE.txt.

 * It is also available through the world-wide-web at this URL:

 * http://framework.zend.com/license/new-bsd

 * If you did not receive a copy of the license and are unable to

 * obtain it through the world-wide-web, please send an email

 * to license@zend.com so we can send you a copy immediately.

 *

 * @category   Zend

 * @package    Zend_Validate

 * @copyright  Copyright (c) 2005-2010 Zend Technologies USA Inc. (http://www.zend.com)

 * @license    http://framework.zend.com/license/new-bsd     New BSD License

 * @version    $Id: Hostname.php 21063 2010-02-15 23:00:17Z thomas $

 */



/**

 * @see Zend_Validate_Abstract

 */

require_once 'Zend/Validate/Abstract.php';



/**

 * @see Zend_Validate_Ip

 */

require_once 'Zend/Validate/Ip.php';



/**

 * Please note there are two standalone test scripts for testing IDN characters due to problems

 * with file encoding.

 *

 * The first is tests/Zend/Validate/HostnameTestStandalone.php which is designed to be run on

 * the command line.

 *

 * The second is tests/Zend/Validate/HostnameTestForm.php which is designed to be run via HTML

 * to allow users to test entering UTF-8 characters in a form.

 *

 * @category   Zend

 * @package    Zend_Validate

 * @copyright  Copyright (c) 2005-2010 Zend Technologies USA Inc. (http://www.zend.com)

 * @license    http://framework.zend.com/license/new-bsd     New BSD License

 */

class Zend_Validate_Hostname extends Zend_Validate_Abstract

{

    const INVALID                 = 'hostnameInvalid';

    const IP_ADDRESS_NOT_ALLOWED  = 'hostnameIpAddressNotAllowed';

    const UNKNOWN_TLD             = 'hostnameUnknownTld';

    const INVALID_DASH            = 'hostnameDashCharacter';

    const INVALID_HOSTNAME_SCHEMA = 'hostnameInvalidHostnameSchema';

    const UNDECIPHERABLE_TLD      = 'hostnameUndecipherableTld';

    const INVALID_HOSTNAME        = 'hostnameInvalidHostname';

    const INVALID_LOCAL_NAME      = 'hostnameInvalidLocalName';

    const LOCAL_NAME_NOT_ALLOWED  = 'hostnameLocalNameNotAllowed';

    const CANNOT_DECODE_PUNYCODE  = 'hostnameCannotDecodePunycode';



    /**

     * @var array

     */

    protected $_messageTemplates = array(

        self::INVALID                 => "Invalid type given, value should be a string",

        self::IP_ADDRESS_NOT_ALLOWED  => "'%value%' appears to be an IP address, but IP addresses are not allowed",

        self::UNKNOWN_TLD             => "'%value%' appears to be a DNS hostname but cannot match TLD against known list",

        self::INVALID_DASH            => "'%value%' appears to be a DNS hostname but contains a dash in an invalid position",

        self::INVALID_HOSTNAME_SCHEMA => "'%value%' appears to be a DNS hostname but cannot match against hostname schema for TLD '%tld%'",

        self::UNDECIPHERABLE_TLD      => "'%value%' appears to be a DNS hostname but cannot extract TLD part",

        self::INVALID_HOSTNAME        => "'%value%' does not match the expected structure for a DNS hostname",

        self::INVALID_LOCAL_NAME      => "'%value%' does not appear to be a valid local network name",

        self::LOCAL_NAME_NOT_ALLOWED  => "'%value%' appears to be a local network name but local network names are not allowed",

        self::CANNOT_DECODE_PUNYCODE  => "'%value%' appears to be a DNS hostname but the given punycode notation cannot be decoded",

    );



    /**

     * @var array

     */

    protected $_messageVariables = array(

        'tld' => '_tld'

    );



    /**

     * Allows Internet domain names (e.g., example.com)

     */

    const ALLOW_DNS   = 1;



    /**

     * Allows IP addresses

     */

    const ALLOW_IP    = 2;



    /**

     * Allows local network names (e.g., localhost, www.localdomain)

     */

    const ALLOW_LOCAL = 4;



    /**

     * Allows all types of hostnames

     */

    const ALLOW_ALL   = 7;



    /**

     * Array of valid top-level-domains

     *

     * @see ftp://data.iana.org/TLD/tlds-alpha-by-domain.txt  List of all TLDs by domain

     * @see http://www.iana.org/domains/root/db/ Official list of supported TLDs

     * @var array

     */

    protected $_validTlds = array(

        'ac', 'ad', 'ae', 'aero', 'af', 'ag', 'ai', 'al', 'am', 'an', 'ao', 'aq', 'ar', 'arpa',

        'as', 'asia', 'at', 'au', 'aw', 'ax', 'az', 'ba', 'bb', 'bd', 'be', 'bf', 'bg', 'bh', 'bi',

        'biz', 'bj', 'bm', 'bn', 'bo', 'br', 'bs', 'bt', 'bv', 'bw', 'by', 'bz', 'ca', 'cat', 'cc',

        'cd', 'cf', 'cg', 'ch', 'ci', 'ck', 'cl', 'cm', 'cn', 'co', 'com', 'coop', 'cr', 'cu',

        'cv', 'cx', 'cy', 'cz', 'de', 'dj', 'dk', 'dm', 'do', 'dz', 'ec', 'edu', 'ee', 'eg', 'er',

        'es', 'et', 'eu', 'fi', 'fj', 'fk', 'fm', 'fo', 'fr', 'ga', 'gb', 'gd', 'ge', 'gf', 'gg',

        'gh', 'gi', 'gl', 'gm', 'gn', 'gov', 'gp', 'gq', 'gr', 'gs', 'gt', 'gu', 'gw', 'gy', 'hk',

        'hm', 'hn', 'hr', 'ht', 'hu', 'id', 'ie', 'il', 'im', 'in', 'info', 'int', 'io', 'iq',

        'ir', 'is', 'it', 'je', 'jm', 'jo', 'jobs', 'jp', 'ke', 'kg', 'kh', 'ki', 'km', 'kn', 'kp',

        'kr', 'kw', 'ky', 'kz', 'la', 'lb', 'lc', 'li', 'lk', 'lr', 'ls', 'lt', 'lu', 'lv', 'ly',

        'ma', 'mc', 'md', 'me', 'mg', 'mh', 'mil', 'mk', 'ml', 'mm', 'mn', 'mo', 'mobi', 'mp',

        'mq', 'mr', 'ms', 'mt', 'mu', 'museum', 'mv', 'mw', 'mx', 'my', 'mz', 'na', 'name', 'nc',

        'ne', 'net', 'nf', 'ng', 'ni', 'nl', 'no', 'np', 'nr', 'nu', 'nz', 'om', 'org', 'pa', 'pe',

        'pf', 'pg', 'ph', 'pk', 'pl', 'pm', 'pn', 'pr', 'pro', 'ps', 'pt', 'pw', 'py', 'qa', 're',

        'ro', 'rs', 'ru', 'rw', 'sa', 'sb', 'sc', 'sd', 'se', 'sg', 'sh', 'si', 'sj', 'sk', 'sl',

        'sm', 'sn', 'so', 'sr', 'st', 'su', 'sv', 'sy', 'sz', 'tc', 'td', 'tel', 'tf', 'tg', 'th',

        'tj', 'tk', 'tl', 'tm', 'tn', 'to', 'tp', 'tr', 'travel', 'tt', 'tv', 'tw', 'tz', 'ua',

        'ug', 'uk', 'um', 'us', 'uy', 'uz', 'va', 'vc', 've', 'vg', 'vi', 'vn', 'vu', 'wf', 'ws',

        'ye', 'yt', 'yu', 'za', 'zm', 'zw'

    );



    /**

     * @var string

     */

    protected $_tld;



    /**

     * Array for valid Idns

     * @see http://www.iana.org/domains/idn-tables/ Official list of supported IDN Chars

     * (.AC) Ascension Island http://www.nic.ac/pdf/AC-IDN-Policy.pdf

     * (.AR) Argentinia http://www.nic.ar/faqidn.html

     * (.AS) American Samoa http://www.nic.as/idn/chars.cfm

     * (.AT) Austria http://www.nic.at/en/service/technical_information/idn/charset_converter/

     * (.BIZ) International http://www.iana.org/domains/idn-tables/

     * (.BR) Brazil http://registro.br/faq/faq6.html

     * (.BV) Bouvett Island http://www.norid.no/domeneregistrering/idn/idn_nyetegn.en.html

     * (.CAT) Catalan http://www.iana.org/domains/idn-tables/tables/cat_ca_1.0.html

     * (.CH) Switzerland https://nic.switch.ch/reg/ocView.action?res=EF6GW2JBPVTG67DLNIQXU234MN6SC33JNQQGI7L6#anhang1

     * (.CL) Chile http://www.iana.org/domains/idn-tables/tables/cl_latn_1.0.html

     * (.COM) International http://www.verisign.com/information-services/naming-services/internationalized-domain-names/index.html

     * (.DE) Germany http://www.denic.de/en/domains/idns/liste.html

     * (.DK) Danmark http://www.dk-hostmaster.dk/index.php?id=151

     * (.ES) Spain https://www.nic.es/media/2008-05/1210147705287.pdf

     * (.FI) Finland http://www.ficora.fi/en/index/palvelut/fiverkkotunnukset/aakkostenkaytto.html

     * (.GR) Greece https://grweb.ics.forth.gr/CharacterTable1_en.jsp

     * (.HU) Hungary http://www.domain.hu/domain/English/szabalyzat/szabalyzat.html

     * (.INFO) International http://www.nic.info/info/idn

     * (.IO) British Indian Ocean Territory http://www.nic.io/IO-IDN-Policy.pdf

     * (.IR) Iran http://www.nic.ir/Allowable_Characters_dot-iran

     * (.IS) Iceland http://www.isnic.is/domain/rules.php

     * (.KR) Korea http://www.iana.org/domains/idn-tables/tables/kr_ko-kr_1.0.html

     * (.LI) Liechtenstein https://nic.switch.ch/reg/ocView.action?res=EF6GW2JBPVTG67DLNIQXU234MN6SC33JNQQGI7L6#anhang1

     * (.LT) Lithuania http://www.domreg.lt/static/doc/public/idn_symbols-en.pdf

     * (.MD) Moldova http://www.register.md/

     * (.MUSEUM) International http://www.iana.org/domains/idn-tables/tables/museum_latn_1.0.html

     * (.NET) International http://www.verisign.com/information-services/naming-services/internationalized-domain-names/index.html

     * (.NO) Norway http://www.norid.no/domeneregistrering/idn/idn_nyetegn.en.html

     * (.NU) Niue http://www.worldnames.net/

     * (.ORG) International http://www.pir.org/index.php?db=content/FAQs&tbl=FAQs_Registrant&id=2

     * (.PE) Peru https://www.nic.pe/nuevas_politicas_faq_2.php

     * (.PL) Poland http://www.dns.pl/IDN/allowed_character_sets.pdf

     * (.PR) Puerto Rico http://www.nic.pr/idn_rules.asp

     * (.PT) Portugal https://online.dns.pt/dns_2008/do?com=DS;8216320233;111;+PAGE(4000058)+K-CAT-CODIGO(C.125)+RCNT(100);

     * (.RU) Russia http://www.iana.org/domains/idn-tables/tables/ru_ru-ru_1.0.html

     * (.SA) Saudi Arabia http://www.iana.org/domains/idn-tables/tables/sa_ar_1.0.html

     * (.SE) Sweden http://www.iis.se/english/IDN_campaignsite.shtml?lang=en

     * (.SH) Saint Helena http://www.nic.sh/SH-IDN-Policy.pdf

     * (.SJ) Svalbard and Jan Mayen http://www.norid.no/domeneregistrering/idn/idn_nyetegn.en.html

     * (.TH) Thailand http://www.iana.org/domains/idn-tables/tables/th_th-th_1.0.html

     * (.TM) Turkmenistan http://www.nic.tm/TM-IDN-Policy.pdf

     * (.TR) Turkey https://www.nic.tr/index.php

     * (.VE) Venice http://www.iana.org/domains/idn-tables/tables/ve_es_1.0.html

     * (.VN) Vietnam http://www.vnnic.vn/english/5-6-300-2-2-04-20071115.htm#1.%20Introduction

     *

     * @var array

     */

    protected $_validIdns = array(

        'AC'  => array(1 => '/^[\x{002d}0-9a-zГ -Г¶Гё-ГїДЃДѓД…Д‡Д‰Д‹ДЌДЏД‘Д“Д—Д™Д›ДќДЎДЈДҐД§Д«ДЇДµД·ДєДјДѕЕЂЕ‚Е„Е†Е€Е‹Е‘Е“Е•Е—Е™Е›ЕќЕџЕЎЕЈЕҐЕ§Е«Е­ЕЇЕ±ЕіЕµЕ·ЕєЕјЕѕ]{1,63}$/iu'),

        'AR'  => array(1 => '/^[\x{002d}0-9a-zГ -ГЈГ§-ГЄГ¬Г­Г±-ГµГј]{1,63}$/iu'),

        'AS'  => array(1 => '/^[\x{002d}0-9a-zГ -Г¶Гё-ГїДЃДѓД…Д‡Д‰Д‹ДЌДЏД‘Д“Д•Д—Д™Д›ДќДџДЎДЈДҐД§Д©Д«Д­ДЇД±ДµД·ДёДєДјДѕЕ‚Е„Е†Е€Е‹ЕЌЕЏЕ‘Е“Е•Е—Е™Е›ЕќЕџЕЎЕЈЕҐЕ§Е©Е«Е­ЕЇЕ±ЕіЕµЕ·ЕєЕј]{1,63}$/iu'),

        'AT'  => array(1 => '/^[\x{002d}0-9a-zГ -Г¶Гё-ГїЕ“ЕЎЕѕ]{1,63}$/iu'),

        'BIZ' => 'Hostname/Biz.php',

        'BR'  => array(1 => '/^[\x{002d}0-9a-zГ -ГЈГ§Г©Г­Гі-ГµГєГј]{1,63}$/iu'),

        'BV'  => array(1 => '/^[\x{002d}0-9a-zГ ГЎГ¤-Г©ГЄГ±-ГґГ¶ГёГјДЌД‘Е„Е‹ЕЎЕ§Еѕ]{1,63}$/iu'),

        'CAT' => array(1 => '/^[\x{002d}0-9a-zВ·Г Г§-Г©Г­ГЇГІГіГєГј]{1,63}$/iu'),

        'CH'  => array(1 => '/^[\x{002d}0-9a-zГ -Г¶Гё-ГїЕ“]{1,63}$/iu'),

        'CL'  => array(1 => '/^[\x{002d}0-9a-zГЎГ©Г­Г±ГіГєГј]{1,63}$/iu'),

        'CN'  => 'Hostname/Cn.php',

        'COM' => 'Zend/Validate/Hostname/Com.php',

        'DE'  => array(1 => '/^[\x{002d}0-9a-zГ -Г¶Гё-ГїДѓД…ДЃД‡Д‰ДЌД‹ДЏД‘Д•Д›Д—Д™Д“ДџДќДЎДЈДҐД§Д­Д©ДЇД«Д±ДµД·ДєДѕДјЕ‚Е„Е€Е†Е‹ЕЏЕ‘ЕЌЕ“ДёЕ•Е™Е—Е›ЕќЕЎЕџЕҐЕЈЕ§Е­ЕЇЕ±Е©ЕіЕ«ЕµЕ·ЕєЕѕЕј]{1,63}$/iu'),

        'DK'  => array(1 => '/^[\x{002d}0-9a-zГ¤Г©Г¶Гј]{1,63}$/iu'),

        'ES'  => array(1 => '/^[\x{002d}0-9a-zГ ГЎГ§ГЁГ©Г­ГЇГ±ГІГіГєГјВ·]{1,63}$/iu'),

        'EU'  => array(1 => '/^[\x{002d}0-9a-zГ -Г¶Гё-Гї]{1,63}$/iu',

            2 => '/^[\x{002d}0-9a-zДЃДѓД…Д‡Д‰Д‹ДЌДЏД‘Д“Д•Д—Д™Д›ДќДџДЎДЈДҐД§Д©Д«Д­ДЇД±ДµД·ДєДјДѕЕЂЕ‚Е„Е†Е€Е‰Е‹ЕЌЕЏЕ‘Е“Е•Е—Е™Е›ЕќЕЎЕҐЕ§Е©Е«Е­ЕЇЕ±ЕіЕµЕ·ЕєЕјЕѕ]{1,63}$/iu',

            3 => '/^[\x{002d}0-9a-zИ™И›]{1,63}$/iu',

            4 => '/^[\x{002d}0-9a-zОђО¬О­О®ОЇО°О±ОІОіОґОµО¶О·ОёО№ОєО»ОјОЅОѕОїПЂПЃП‚ПѓП„П…П†П‡П€П‰ПЉП‹ПЊПЌПЋ]{1,63}$/iu',

            5 => '/^[\x{002d}0-9a-zР°Р±РІРіРґРµР¶Р·РёР№РєР»РјРЅРѕРїСЂСЃС‚СѓС„С…С†С‡С€С‰СЉС‹СЊСЌСЋСЏ]{1,63}$/iu',

            6 => '/^[\x{002d}0-9a-zбјЂ-бј‡бјђ-бј•бј -бј§бј°-бј·бЅЂ-бЅ…бЅђ-бЅ—бЅ -бЅ§бЅ°-ПЋбѕЂ-бѕ‡бѕђ-бѕ—бѕ -бѕ§бѕ°-бѕґбѕ¶бѕ·бї‚бїѓбї„бї†бї‡бїђ-Ођбї–бї—бї -бї§бїІбїібїґбї¶бї·]{1,63}$/iu'),

        'FI'  => array(1 => '/^[\x{002d}0-9a-zГ¤ГҐГ¶]{1,63}$/iu'),

        'GR'  => array(1 => '/^[\x{002d}0-9a-zО†О€О‰ОЉОЊОЋ-ОЎОЈ-ПЋбјЂ-бј•бј-бјќбј -бЅ…бЅ€-бЅЌбЅђ-бЅ—бЅ™бЅ›бЅќбЅџ-бЅЅбѕЂ-бѕґбѕ¶-бѕјбї‚бїѓбї„бї†-бїЊбїђ-бї“бї–-бї›бї -бї¬бїІбїібїґбї¶-бїј]{1,63}$/iu'),

        'HK'  => 'Zend/Validate/Hostname/Cn.php',

        'HU'  => array(1 => '/^[\x{002d}0-9a-zГЎГ©Г­ГіГ¶ГєГјЕ‘Е±]{1,63}$/iu'),

        'INFO'=> array(1 => '/^[\x{002d}0-9a-zГ¤ГҐГ¦Г©Г¶ГёГј]{1,63}$/iu',

            2 => '/^[\x{002d}0-9a-zГЎГ©Г­ГіГ¶ГєГјЕ‘Е±]{1,63}$/iu',

            3 => '/^[\x{002d}0-9a-zГЎГ¦Г©Г­Г°ГіГ¶ГєГЅГѕ]{1,63}$/iu',

            4 => '/^[\x{AC00}-\x{D7A3}]{1,17}$/iu',

            5 => '/^[\x{002d}0-9a-zДЃДЌД“ДЈД«Д·ДјЕ†ЕЌЕ—ЕЎЕ«Еѕ]{1,63}$/iu',

            6 => '/^[\x{002d}0-9a-zД…ДЌД—Д™ДЇЕЎЕ«ЕіЕѕ]{1,63}$/iu',

            7 => '/^[\x{002d}0-9a-zГіД…Д‡Д™Е‚Е„Е›ЕєЕј]{1,63}$/iu',

            8 => '/^[\x{002d}0-9a-zГЎГ©Г­Г±ГіГєГј]{1,63}$/iu'),

        'IO'  => array(1 => '/^[\x{002d}0-9a-zГ -Г¶Гё-ГїДѓД…ДЃД‡Д‰ДЌД‹ДЏД‘Д•Д›Д—Д™Д“ДџДќДЎДЈДҐД§Д­Д©ДЇД«Д±ДµД·ДєДѕДјЕ‚Е„Е€Е†Е‹ЕЏЕ‘ЕЌЕ“ДёЕ•Е™Е—Е›ЕќЕЎЕџЕҐЕЈЕ§Е­ЕЇЕ±Е©ЕіЕ«ЕµЕ·ЕєЕѕЕј]{1,63}$/iu'),

        'IS'  => array(1 => '/^[\x{002d}0-9a-zГЎГ©ГЅГєГ­ГіГѕГ¦Г¶Г°]{1,63}$/iu'),

        'JP'  => 'Zend/Validate/Hostname/Jp.php',

        'KR'  => array(1 => '/^[\x{AC00}-\x{D7A3}]{1,17}$/iu'),

        'LI'  => array(1 => '/^[\x{002d}0-9a-zГ -Г¶Гё-ГїЕ“]{1,63}$/iu'),

        'LT'  => array(1 => '/^[\x{002d}0-9Д…ДЌД™Д—ДЇЕЎЕіЕ«Еѕ]{1,63}$/iu'),

        'MD'  => array(1 => '/^[\x{002d}0-9ДѓГўГ®ЕџЕЈ]{1,63}$/iu'),

        'MUSEUM' => array(1 => '/^[\x{002d}0-9a-zГ -Г¶Гё-ГїДЃДѓД…Д‡Д‹ДЌДЏД‘Д“Д—Д™Д›ДџДЎДЈД§Д«ДЇД±Д·ДєДјДѕЕ‚Е„Е†Е€Е‹ЕЌЕ‘Е“Е•Е—Е™Е›ЕџЕЎЕЈЕҐЕ§Е«ЕЇЕ±ЕіЕµЕ·ЕєЕјЕѕЗЋЗђЗ’З”\x{01E5}\x{01E7}\x{01E9}\x{01EF}Й™\x{0292}бєЃбєѓбє…б»і]{1,63}$/iu'),

        'NET' => 'Zend/Validate/Hostname/Com.php',

        'NO'  => array(1 => '/^[\x{002d}0-9a-zГ ГЎГ¤-Г©ГЄГ±-ГґГ¶ГёГјДЌД‘Е„Е‹ЕЎЕ§Еѕ]{1,63}$/iu'),

        'NU'  => 'Zend/Validate/Hostname/Com.php',

        'ORG' => array(1 => '/^[\x{002d}0-9a-zГЎГ©Г­Г±ГіГєГј]{1,63}$/iu',

            2 => '/^[\x{002d}0-9a-zГіД…Д‡Д™Е‚Е„Е›ЕєЕј]{1,63}$/iu',

            3 => '/^[\x{002d}0-9a-zГЎГ¤ГҐГ¦Г©Г«Г­Г°ГіГ¶ГёГєГјГЅГѕ]{1,63}$/iu',

            4 => '/^[\x{002d}0-9a-zГЎГ©Г­ГіГ¶ГєГјЕ‘Е±]{1,63}$/iu',

            5 => '/^[\x{002d}0-9a-zД…ДЌД—Д™ДЇЕЎЕ«ЕіЕѕ]{1,63}$/iu',

            6 => '/^[\x{AC00}-\x{D7A3}]{1,17}$/iu',

            7 => '/^[\x{002d}0-9a-zДЃДЌД“ДЈД«Д·ДјЕ†ЕЌЕ—ЕЎЕ«Еѕ]{1,63}$/iu'),

        'PE'  => array(1 => '/^[\x{002d}0-9a-zГ±ГЎГ©Г­ГіГєГј]{1,63}$/iu'),

        'PL'  => array(1 => '/^[\x{002d}0-9a-zДЃДЌД“ДЈД«Д·ДјЕ†ЕЌЕ—ЕЎЕ«Еѕ]{1,63}$/iu',

            2 => '/^[\x{002d}Р°-РёРє-С€\x{0450}С“С•СС™СљСњСџ]{1,63}$/iu',

            3 => '/^[\x{002d}0-9a-zГўГ®ДѓЕџЕЈ]{1,63}$/iu',

            4 => '/^[\x{002d}0-9Р°-СЏС‘\x{04C2}]{1,63}$/iu',

            5 => '/^[\x{002d}0-9a-zГ ГЎГўГЁГ©ГЄГ¬Г­Г®ГІГіГґГ№ГєГ»Д‹ДЎД§Еј]{1,63}$/iu',

            6 => '/^[\x{002d}0-9a-zГ Г¤ГҐГ¦Г©ГЄГІГіГґГ¶ГёГј]{1,63}$/iu',

            7 => '/^[\x{002d}0-9a-zГіД…Д‡Д™Е‚Е„Е›ЕєЕј]{1,63}$/iu',

            8 => '/^[\x{002d}0-9a-zГ ГЎГўГЈГ§Г©ГЄГ­ГІГіГґГµГєГј]{1,63}$/iu',

            9 => '/^[\x{002d}0-9a-zГўГ®ДѓЕџЕЈ]{1,63}$/iu',

            10=> '/^[\x{002d}0-9a-zГЎГ¤Г©Г­ГіГґГєГЅДЌДЏДєДѕЕ€Е•ЕЎЕҐЕѕ]{1,63}$/iu',

            11=> '/^[\x{002d}0-9a-zГ§Г«]{1,63}$/iu',

            12=> '/^[\x{002d}0-9Р°-РёРє-С€С’СС™СљС›Сџ]{1,63}$/iu',

            13=> '/^[\x{002d}0-9a-zД‡ДЌД‘ЕЎЕѕ]{1,63}$/iu',

            14=> '/^[\x{002d}0-9a-zГўГ§Г¶Г»ГјДџД±Еџ]{1,63}$/iu',

            15=> '/^[\x{002d}0-9a-zГЎГ©Г­Г±ГіГєГј]{1,63}$/iu',

            16=> '/^[\x{002d}0-9a-zГ¤ГµГ¶ГјЕЎЕѕ]{1,63}$/iu',

            17=> '/^[\x{002d}0-9a-zД‰ДќДҐДµЕќЕ­]{1,63}$/iu',

            18=> '/^[\x{002d}0-9a-zГўГ¤Г©Г«Г®Гґ]{1,63}$/iu',

            19=> '/^[\x{002d}0-9a-zГ ГЎГўГ¤ГҐГ¦Г§ГЁГ©ГЄГ«Г¬Г­Г®ГЇГ°Г±ГІГґГ¶ГёГ№ГєГ»ГјГЅД‡ДЌЕ‚Е„Е™Е›ЕЎ]{1,63}$/iu',

            20=> '/^[\x{002d}0-9a-zГ¤ГҐГ¦ГµГ¶ГёГјЕЎЕѕ]{1,63}$/iu',

            21=> '/^[\x{002d}0-9a-zГ ГЎГ§ГЁГ©Г¬Г­ГІГіГ№Гє]{1,63}$/iu',

            22=> '/^[\x{002d}0-9a-zГ ГЎГ©Г­ГіГ¶ГєГјЕ‘Е±]{1,63}$/iu',

            23=> '/^[\x{002d}0-9ОђО¬-ПЋ]{1,63}$/iu',

            24=> '/^[\x{002d}0-9a-zГ ГЎГўГҐГ¦Г§ГЁГ©ГЄГ«Г°ГіГґГ¶ГёГјГѕЕ“]{1,63}$/iu',

            25=> '/^[\x{002d}0-9a-zГЎГ¤Г©Г­ГіГ¶ГєГјГЅДЌДЏД›Е€Е™ЕЎЕҐЕЇЕѕ]{1,63}$/iu',

            26=> '/^[\x{002d}0-9a-zВ·Г Г§ГЁГ©Г­ГЇГІГіГєГј]{1,63}$/iu',

            27=> '/^[\x{002d}0-9Р°-СЉСЊСЋСЏ\x{0450}\x{045D}]{1,63}$/iu',

            28=> '/^[\x{002d}0-9Р°-СЏС‘С–Сћ]{1,63}$/iu',

            29=> '/^[\x{002d}0-9a-zД…ДЌД—Д™ДЇЕЎЕ«ЕіЕѕ]{1,63}$/iu',

            30=> '/^[\x{002d}0-9a-zГЎГ¤ГҐГ¦Г©Г«Г­Г°ГіГ¶ГёГєГјГЅГѕ]{1,63}$/iu',

            31=> '/^[\x{002d}0-9a-zГ ГўГ¦Г§ГЁГ©ГЄГ«Г®ГЇГ±ГґГ№Г»ГјГїЕ“]{1,63}$/iu',

            32=> '/^[\x{002d}0-9Р°-С‰СЉС‹СЊСЌСЋСЏС‘С”С–С—Т‘]{1,63}$/iu',

            33=> '/^[\x{002d}0-9Чђ-ЧЄ]{1,63}$/iu'),

        'PR'  => array(1 => '/^[\x{002d}0-9a-zГЎГ©Г­ГіГєГ±Г¤Г«ГЇГјГ¶ГўГЄГ®ГґГ»Г ГЁГ№Г¦Г§Е“ГЈГµ]{1,63}$/iu'),

        'PT'  => array(1 => '/^[\x{002d}0-9a-zГЎГ ГўГЈГ§Г©ГЄГ­ГіГґГµГє]{1,63}$/iu'),

        'RU'  => array(1 => '/^[\x{002d}0-9Р°-СЏС‘]{1,63}$/iu'),

        'SA'  => array(1 => '/^[\x{002d}.0-9\x{0621}-\x{063A}\x{0641}-\x{064A}\x{0660}-\x{0669}]{1,63}$/iu'),

        'SE'  => array(1 => '/^[\x{002d}0-9a-zГ¤ГҐГ©Г¶Гј]{1,63}$/iu'),

        'SH'  => array(1 => '/^[\x{002d}0-9a-zГ -Г¶Гё-ГїДѓД…ДЃД‡Д‰ДЌД‹ДЏД‘Д•Д›Д—Д™Д“ДџДќДЎДЈДҐД§Д­Д©ДЇД«Д±ДµД·ДєДѕДјЕ‚Е„Е€Е†Е‹ЕЏЕ‘ЕЌЕ“ДёЕ•Е™Е—Е›ЕќЕЎЕџЕҐЕЈЕ§Е­ЕЇЕ±Е©ЕіЕ«ЕµЕ·ЕєЕѕЕј]{1,63}$/iu'),

        'SJ'  => array(1 => '/^[\x{002d}0-9a-zГ ГЎГ¤-Г©ГЄГ±-ГґГ¶ГёГјДЌД‘Е„Е‹ЕЎЕ§Еѕ]{1,63}$/iu'),

        'TH'  => array(1 => '/^[\x{002d}0-9a-z\x{0E01}-\x{0E3A}\x{0E40}-\x{0E4D}\x{0E50}-\x{0E59}]{1,63}$/iu'),

        'TM'  => array(1 => '/^[\x{002d}0-9a-zГ -Г¶Гё-ГїДЃДѓД…Д‡Д‰Д‹ДЌДЏД‘Д“Д—Д™Д›ДќДЎДЈДҐД§Д«ДЇДµД·ДєДјДѕЕЂЕ‚Е„Е†Е€Е‹Е‘Е“Е•Е—Е™Е›ЕќЕџЕЎЕЈЕҐЕ§Е«Е­ЕЇЕ±ЕіЕµЕ·ЕєЕјЕѕ]{1,63}$/iu'),

        'TW'  => 'Zend/Validate/Hostname/Cn.php',

        'TR'  => array(1 => '/^[\x{002d}0-9a-zДџД±ГјЕџГ¶Г§]{1,63}$/iu'),

        'VE'  => array(1 => '/^[\x{002d}0-9a-zГЎГ©Г­ГіГєГјГ±]{1,63}$/iu'),

        'VN'  => array(1 => '/^[ГЂГЃГ‚ГѓГ€Г‰ГЉГЊГЌГ’Г“Г”Г•Г™ГљГќГ ГЎГўГЈГЁГ©ГЄГ¬Г­ГІГіГґГµГ№ГєГЅД‚ДѓДђД‘ДЁД©ЕЁЕ©Ж ЖЎЖЇЖ°\x{1EA0}-\x{1EF9}]{1,63}$/iu'),

        'Ш§ЫЊШ±Ш§Щ†' => array(1 => '/^[\x{0621}-\x{0624}\x{0626}-\x{063A}\x{0641}\x{0642}\x{0644}-\x{0648}\x{067E}\x{0686}\x{0698}\x{06A9}\x{06AF}\x{06CC}\x{06F0}-\x{06F9}]{1,30}$/iu'),

        'дё­е›Ѕ' => 'Zend/Validate/Hostname/Cn.php',

        'е…¬еЏё' => 'Zend/Validate/Hostname/Cn.php',

        'зЅ‘з»њ' => 'Zend/Validate/Hostname/Cn.php'

    );



    protected $_idnLength = array(

        'BIZ' => array(5 => 17, 11 => 15, 12 => 20),

        'CN'  => array(1 => 20),

        'COM' => array(3 => 17, 5 => 20),

        'HK'  => array(1 => 15),

        'INFO'=> array(4 => 17),

        'KR'  => array(1 => 17),

        'NET' => array(3 => 17, 5 => 20),

        'ORG' => array(6 => 17),

        'TW'  => array(1 => 20),

        'Ш§ЫЊШ±Ш§Щ†' => array(1 => 30),

        'дё­е›Ѕ' => array(1 => 20),

        'е…¬еЏё' => array(1 => 20),

        'зЅ‘з»њ' => array(1 => 20),

    );



    protected $_options = array(

        'allow' => self::ALLOW_DNS,

        'idn'   => true,

        'tld'   => true,

        'ip'    => null

    );



    /**

     * Sets validator options

     *

     * @param integer          $allow       OPTIONAL Set what types of hostname to allow (default ALLOW_DNS)

     * @param boolean          $validateIdn OPTIONAL Set whether IDN domains are validated (default true)

     * @param boolean          $validateTld OPTIONAL Set whether the TLD element of a hostname is validated (default true)

     * @param Zend_Validate_Ip $ipValidator OPTIONAL

     * @return void

     * @see http://www.iana.org/cctld/specifications-policies-cctlds-01apr02.htm  Technical Specifications for ccTLDs

     */

    public function __construct($options = array())

    {

        if ($options instanceof Zend_Config) {

            $options = $options->toArray();

        } else if (!is_array($options)) {

            $options = func_get_args();

            $temp['allow'] = array_shift($options);

            if (!empty($options)) {

                $temp['idn'] = array_shift($options);

            }



            if (!empty($options)) {

                $temp['tld'] = array_shift($options);

            }



            if (!empty($options)) {

                $temp['ip'] = array_shift($options);

            }



            $options = $temp;

        }



        $options += $this->_options;

        $this->setOptions($options);

    }



    /**

     * Returns all set options

     *

     * @return array

     */

    public function getOptions()

    {

        return $this->_options;

    }



    /**

     * Sets the options for this validator

     *

     * @param array $options

     * @return Zend_Validate_Hostname

     */

    public function setOptions($options)

    {

        if (array_key_exists('allow', $options)) {

            $this->setAllow($options['allow']);

        }



        if (array_key_exists('idn', $options)) {

            $this->setValidateIdn($options['idn']);

        }



        if (array_key_exists('tld', $options)) {

            $this->setValidateTld($options['tld']);

        }



        if (array_key_exists('ip', $options)) {

            $this->setIpValidator($options['ip']);

        }



        return $this;

    }



    /**

     * Returns the set ip validator

     *

     * @return Zend_Validate_Ip

     */

    public function getIpValidator()

    {

        return $this->_options['ip'];

    }



    /**

     * @param Zend_Validate_Ip $ipValidator OPTIONAL

     * @return void;

     */

    public function setIpValidator(Zend_Validate_Ip $ipValidator = null)

    {

        if ($ipValidator === null) {

            $ipValidator = new Zend_Validate_Ip();

        }



        $this->_options['ip'] = $ipValidator;

        return $this;

    }



    /**

     * Returns the allow option

     *

     * @return integer

     */

    public function getAllow()

    {

        return $this->_options['allow'];

    }



    /**

     * Sets the allow option

     *

     * @param  integer $allow

     * @return Zend_Validate_Hostname Provides a fluent interface

     */

    public function setAllow($allow)

    {

        $this->_options['allow'] = $allow;

        return $this;

    }



    /**

     * Returns the set idn option

     *

     * @return boolean

     */

    public function getValidateIdn()

    {

        return $this->_options['idn'];

    }



    /**

     * Set whether IDN domains are validated

     *

     * This only applies when DNS hostnames are validated

     *

     * @param boolean $allowed Set allowed to true to validate IDNs, and false to not validate them

     */

    public function setValidateIdn ($allowed)

    {

        $this->_options['idn'] = (bool) $allowed;

        return $this;

    }



    /**

     * Returns the set tld option

     *

     * @return boolean

     */

    public function getValidateTld()

    {

        return $this->_options['tld'];

    }



    /**

     * Set whether the TLD element of a hostname is validated

     *

     * This only applies when DNS hostnames are validated

     *

     * @param boolean $allowed Set allowed to true to validate TLDs, and false to not validate them

     */

    public function setValidateTld ($allowed)

    {

        $this->_options['tld'] = (bool) $allowed;

        return $this;

    }



    /**

     * Defined by Zend_Validate_Interface

     *

     * Returns true if and only if the $value is a valid hostname with respect to the current allow option

     *

     * @param  string $value

     * @throws Zend_Validate_Exception if a fatal error occurs for validation process

     * @return boolean

     */

    public function isValid($value)

    {

        if (!is_string($value)) {

            $this->_error(self::INVALID);

            return false;

        }



        $this->_setValue($value);

        // Check input against IP address schema

        if (preg_match('/^[0-9.a-e:.]*$/i', $value) &&

            $this->_options['ip']->setTranslator($this->getTranslator())->isValid($value)) {

            if (!($this->_options['allow'] & self::ALLOW_IP)) {

                $this->_error(self::IP_ADDRESS_NOT_ALLOWED);

                return false;

            } else {

                return true;

            }

        }



        // Check input against DNS hostname schema

        $domainParts = explode('.', $value);

        if ((count($domainParts) > 1) && (strlen($value) >= 4) && (strlen($value) <= 254)) {

            $status = false;



            $origenc = iconv_get_encoding('internal_encoding');

            iconv_set_encoding('internal_encoding', 'UTF-8');

            do {

                // First check TLD

                $matches = array();

                if (preg_match('/([^.]{2,10})$/i', end($domainParts), $matches) ||

                    (end($domainParts) == 'Ш§ЫЊШ±Ш§Щ†') || (end($domainParts) == 'дё­е›Ѕ') ||

                    (end($domainParts) == 'е…¬еЏё') || (end($domainParts) == 'зЅ‘з»њ')) {



                    reset($domainParts);



                    // Hostname characters are: *(label dot)(label dot label); max 254 chars

                    // label: id-prefix [*ldh{61} id-prefix]; max 63 chars

                    // id-prefix: alpha / digit

                    // ldh: alpha / digit / dash



                    // Match TLD against known list

                    $this->_tld = strtolower($matches[1]);

                    if ($this->_options['tld']) {

                        if (!in_array($this->_tld, $this->_validTlds)) {

                            $this->_error(self::UNKNOWN_TLD);

                            $status = false;

                            break;

                        }

                    }



                    /**

                     * Match against IDN hostnames

                     * Note: Keep label regex short to avoid issues with long patterns when matching IDN hostnames

                     * @see Zend_Validate_Hostname_Interface

                     */

                    $regexChars = array(0 => '/^[a-z0-9\x2d]{1,63}$/i');

                    if ($this->_options['idn'] &&  isset($this->_validIdns[strtoupper($this->_tld)])) {

                        if (is_string($this->_validIdns[strtoupper($this->_tld)])) {

                            $regexChars += include($this->_validIdns[strtoupper($this->_tld)]);

                        } else {

                            $regexChars += $this->_validIdns[strtoupper($this->_tld)];

                        }

                    }



                    // Check each hostname part

                    $check = 0;

                    foreach ($domainParts as $domainPart) {

                        // Decode Punycode domainnames to IDN

                        if (strpos($domainPart, 'xn--') === 0) {

                            $domainPart = $this->decodePunycode(substr($domainPart, 4));

                            if ($domainPart === false) {

                                return false;

                            }

                        }



                        // Check dash (-) does not start, end or appear in 3rd and 4th positions

                        if ((strpos($domainPart, '-') === 0)

                            || ((strlen($domainPart) > 2) && (strpos($domainPart, '-', 2) == 2) && (strpos($domainPart, '-', 3) == 3))

                            || (strpos($domainPart, '-') === (strlen($domainPart) - 1))) {

                                $this->_error(self::INVALID_DASH);

                            $status = false;

                            break 2;

                        }



                        // Check each domain part

                        $checked = false;

                        foreach($regexChars as $regexKey => $regexChar) {

                            $status = @preg_match($regexChar, $domainPart);

                            if ($status > 0) {

                                $length = 63;

                                if (array_key_exists(strtoupper($this->_tld), $this->_idnLength)

                                    && (array_key_exists($regexKey, $this->_idnLength[strtoupper($this->_tld)]))) {

                                    $length = $this->_idnLength[strtoupper($this->_tld)];

                                }



                                if (iconv_strlen($domainPart, 'UTF-8') > $length) {

                                    $this->_error(self::INVALID_HOSTNAME);

                                } else {

                                    $checked = true;

                                    break;

                                }

                            }

                        }



                        if ($checked) {

                            ++$check;

                        }

                    }



                    // If one of the labels doesn't match, the hostname is invalid

                    if ($check !== count($domainParts)) {

                        $this->_error(self::INVALID_HOSTNAME_SCHEMA);

                        $status = false;

                    }

                } else {

                    // Hostname not long enough

                    $this->_error(self::UNDECIPHERABLE_TLD);

                    $status = false;

                }

            } while (false);



            iconv_set_encoding('internal_encoding', $origenc);

            // If the input passes as an Internet domain name, and domain names are allowed, then the hostname

            // passes validation

            if ($status && ($this->_options['allow'] & self::ALLOW_DNS)) {

                return true;

            }

        } else if ($this->_options['allow'] & self::ALLOW_DNS) {

            $this->_error(self::INVALID_HOSTNAME);

        }



        // Check input against local network name schema; last chance to pass validation

        $regexLocal = '/^(([a-zA-Z0-9\x2d]{1,63}\x2e)*[a-zA-Z0-9\x2d]{1,63}){1,254}$/';

        $status = @preg_match($regexLocal, $value);



        // If the input passes as a local network name, and local network names are allowed, then the

        // hostname passes validation

        $allowLocal = $this->_options['allow'] & self::ALLOW_LOCAL;

        if ($status && $allowLocal) {

            return true;

        }



        // If the input does not pass as a local network name, add a message

        if (!$status) {

            $this->_error(self::INVALID_LOCAL_NAME);

        }



        // If local network names are not allowed, add a message

        if ($status && !$allowLocal) {

            $this->_error(self::LOCAL_NAME_NOT_ALLOWED);

        }



        return false;

    }



    /**

     * Decodes a punycode encoded string to it's original utf8 string

     * In case of a decoding failure the original string is returned

     *

     * @param  string $encoded Punycode encoded string to decode

     * @return string

     */

    protected function decodePunycode($encoded)

    {

        $found = preg_match('/([^a-z0-9\x2d]{1,10})$/i', $encoded);

        if (empty($encoded) || ($found > 0)) {

            // no punycode encoded string, return as is

            $this->_error(self::CANNOT_DECODE_PUNYCODE);

            return false;

        }



        $separator = strrpos($encoded, '-');

        if ($separator > 0) {

            for ($x = 0; $x < $separator; ++$x) {

                // prepare decoding matrix

                $decoded[] = ord($encoded[$x]);

            }

        } else {

            $this->_error(self::CANNOT_DECODE_PUNYCODE);

            return false;

        }



        $lengthd = count($decoded);

        $lengthe = strlen($encoded);



        // decoding

        $init  = true;

        $base  = 72;

        $index = 0;

        $char  = 0x80;



        for ($indexe = ($separator) ? ($separator + 1) : 0; $indexe < $lengthe; ++$lengthd) {

            for ($old_index = $index, $pos = 1, $key = 36; 1 ; $key += 36) {

                $hex   = ord($encoded[$indexe++]);

                $digit = ($hex - 48 < 10) ? $hex - 22

                       : (($hex - 65 < 26) ? $hex - 65

                       : (($hex - 97 < 26) ? $hex - 97

                       : 36));



                $index += $digit * $pos;

                $tag    = ($key <= $base) ? 1 : (($key >= $base + 26) ? 26 : ($key - $base));

                if ($digit < $tag) {

                    break;

                }



                $pos = (int) ($pos * (36 - $tag));

            }



            $delta   = intval($init ? (($index - $old_index) / 700) : (($index - $old_index) / 2));

            $delta  += intval($delta / ($lengthd + 1));

            for ($key = 0; $delta > 910 / 2; $key += 36) {

                $delta = intval($delta / 35);

            }



            $base   = intval($key + 36 * $delta / ($delta + 38));

            $init   = false;

            $char  += (int) ($index / ($lengthd + 1));

            $index %= ($lengthd + 1);

            if ($lengthd > 0) {

                for ($i = $lengthd; $i > $index; $i--) {

                    $decoded[$i] = $decoded[($i - 1)];

                }

            }



            $decoded[$index++] = $char;

        }



        // convert decoded ucs4 to utf8 string

        foreach ($decoded as $key => $value) {

            if ($value < 128) {

                $decoded[$key] = chr($value);

            } elseif ($value < (1 << 11)) {

                $decoded[$key]  = chr(192 + ($value >> 6));

                $decoded[$key] .= chr(128 + ($value & 63));

            } elseif ($value < (1 << 16)) {

                $decoded[$key]  = chr(224 + ($value >> 12));

                $decoded[$key] .= chr(128 + (($value >> 6) & 63));

                $decoded[$key] .= chr(128 + ($value & 63));

            } elseif ($value < (1 << 21)) {

                $decoded[$key]  = chr(240 + ($value >> 18));

                $decoded[$key] .= chr(128 + (($value >> 12) & 63));

                $decoded[$key] .= chr(128 + (($value >> 6) & 63));

                $decoded[$key] .= chr(128 + ($value & 63));

            } else {

                $this->_error(self::CANNOT_DECODE_PUNYCODE);

                return false;

            }

        }



        return implode($decoded);

    }

}

