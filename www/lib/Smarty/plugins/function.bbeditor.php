<?php
/*
 * Smarty plugin
 * $name
 * $text
 * $width, $height
 */
function smarty_function_bbeditor($params, &$smarty)
  {
  extract ($params);

  if (empty ($width)) $width=500;
  if (empty ($height)) $height=25;
  if (empty ($rows)) $rows=14;
  if (empty ($cols)) $cols=60;
  
  appJsLoad('kernel', 'jsBBEditor');
  echo "<textarea name=\"$name\" id=\"bbeditor\" rows=\"$rows\" cols=\"$cols\">" . htmlspecialchars($text, ENT_QUOTES) . "</textarea>";
//rus

  }

?>