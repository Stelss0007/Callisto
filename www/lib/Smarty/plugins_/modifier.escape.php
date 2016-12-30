<?php
/**
 * Smarty plugin
 * @package Smarty
 * @subpackage plugins
 */


/**
 * Smarty escape modifier plugin
 *
 * Type:     modifier<br>
 * Name:     escape<br>
 * Purpose:  Escape the string according to escapement type
 * @link http://smarty.php.net/manual/en/language.modifier.escape.php
 *          escape (Smarty online manual)
 * @param string
 * @param html|htmlall|url|quotes|hex|hexentity|javascript
 * @return string
 */
function smarty_modifier_escape($string, $esc_type = 'html')
  {
  if (is_array ($string))
    {
    foreach ($string as $key=>$value)
      {
      if ($key!='url') //Иначе &amp; в browsein работать не будет
        {
        $string[$key] = smarty_modifier_escape ($value, $esc_type);
        }
      }
    }
    else
      {
			//Пачь для любителей ворда типа Ракохамас
			$string = str_replace('&#8211;', '-', $string);
			$string = str_replace('&#8230;', '...', $string);
      $string = smarty_modifier_escape_string ($string, $esc_type);
      }
  return ($string);
  }
 
/*
 * Внутренняя функция эскеипинга строк
*/
function smarty_modifier_escape_string($string, $esc_type = 'html')
{
    switch ($esc_type) {
        case 'html':
            return htmlspecialchars($string, ENT_QUOTES);

        case 'htmlall':
            return htmlentities($string, ENT_QUOTES);

        case 'url':
            return urlencode($string);

        case 'quotes':
            // escape unescaped single quotes
            return preg_replace("%(?<!\\\\)'%", "\\'", $string);

        case 'hex':
            // escape every character into hex
            $return = '';
            for ($x=0; $x < strlen($string); $x++) {
                $return .= '%' . bin2hex($string[$x]);
            }
            return $return;
            
        case 'hexentity':
            $return = '';
            for ($x=0; $x < strlen($string); $x++) {
                $return .= '&#x' . bin2hex($string[$x]) . ';';
            }
            return $return;

        case 'javascript':
            // escape quotes and backslashes and newlines
            return strtr($string, array('\\'=>'\\\\',"'"=>"\\'",'"'=>'\\"',"\r"=>'\\r',"\n"=>'\\n'));

        default:
            return $string;
    }
}

/* vim: set expandtab: */

?>
