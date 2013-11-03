<?php

/*
 * Smarty plugin
 * $name
 * $text
 * $width, $height
 * $style
 * http://www.tinymce.com/wiki.php/Installation
 */

function smarty_function_texteditor($params, &$smarty)
	{
	extract($params);
  
  static $bbeditor_num = 0;
  $bbeditor_num++;
  
  if (empty ($name)) $name='texteditor_'.$bbeditor_num;
  if (empty ($id)) $id='texteditor_'.$bbeditor_num;
  if (empty ($class)) $class='texteditor_class';
  if (empty ($width)) $width=600;
  if (empty ($height)) $height=25;
  
  appJsLoad('kernel', 'tinymce');
//  appCssLoad('kernel', 'default','jsBBCode');
  
  echo "<textarea id='$id' name='$name' class='$class' style='height:{$height}px;width:{$width}px;'>" . htmlspecialchars($text, ENT_QUOTES) . "</textarea>";
  echo '<script>
          tinyMCE.init({
        // General options
        mode : "textareas",
        theme : "modern",
        plugins : "autolink,lists,spellchecker,pagebreak,layer,table,save,hr,image,link,emoticons,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,template",

        // Theme options
        theme_advanced_buttons1 : "save,newdocument,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,|,styleselect,formatselect,fontselect,fontsizeselect",
        theme_advanced_buttons2 : "cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,help,code,|,insertdate,inserttime,preview,|,forecolor,backcolor",
        theme_advanced_buttons3 : "tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,emotions,iespell,media,advhr,|,print,|,ltr,rtl,|,fullscreen",
        theme_advanced_buttons4 : "insertlayer,moveforward,movebackward,absolute,|,styleprops,spellchecker,|,cite,abbr,acronym,del,ins,attribs,|,visualchars,nonbreaking,template,blockquote,pagebreak,|,insertfile,insertimage",
        theme_advanced_toolbar_location : "top",
        theme_advanced_toolbar_align : "left",
        theme_advanced_statusbar_location : "bottom",
        theme_advanced_resizing : true,

//        // Skin options
//        skin : "o2k7",
//        skin_variant : "silver",
//
//        // Example content CSS (should be your site CSS)
//        content_css : "css/example.css",
//
//        // Drop lists for link/image/media/template dialogs
//        template_external_list_url : "js/template_list.js",
//        external_link_list_url : "js/link_list.js",
//        external_image_list_url : "js/image_list.js",
//        media_external_list_url : "js/media_list.js",

        // Replace values for the template plugin
        template_replace_values : {
                username : "Some User",
                staffid : "991234"
        }
});
        </script>';
	}

?>