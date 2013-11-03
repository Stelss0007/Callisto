<?php
/*
 * Smarty plugin
 * $name
 * $text
 * $width, $height
 * http://www.sceditor.com/
 */
function smarty_function_bbeditor($params, &$smarty)
  {
  extract ($params);

  static $bbeditor_num = 0;
  $bbeditor_num++;
  
  if (empty ($name)) $name='bbcode_field_'.$bbeditor_num;
  if (empty ($id)) $id='bbcode_field_'.$bbeditor_num;
  if (empty ($class)) $class='bbcode_class';
  if (empty ($width)) $width=600;
  if (empty ($height)) $height=25;
  if (empty ($toolbar)) $toolbar = 'bold,italic,underline,strike,subscript,superscript|font,size,color,removeformat|code,quote|image,email,link,unlink|emoticon,date,time';
   
  appJsLoad('kernel', 'jsBBCode');
  appCssLoad('kernel', 'default','jsBBCode');
  
  echo "<textarea id='$id' name='$name' class='$class' style='height:{$height}px;width:{$width}px;'>" . htmlspecialchars($text, ENT_QUOTES) . "</textarea>";
  echo "<script>
        $(function() {
          $('#$id').sceditor({
              plugins: 'bbcode',
              toolbar: '$toolbar',
              locale: 'ru',
              style: '/public/css/jsBBCode/default.css'
              });
            });
        </script>";
  }

?>