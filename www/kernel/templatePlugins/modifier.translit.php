<?php
/**
 * Smarty plugin
 * @package Smarty
 * @subpackage plugins
 */

function smarty_modifier_translit($text)
  {
  return appTranslit($text);
  }

/* vim: set expandtab: */

?>
