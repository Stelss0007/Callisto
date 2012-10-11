<?php

/*
 * Smarty plugin
 * $name
 * $text
 * $width, $height
 * $style
 */

function smarty_function_texteditor($params, &$smarty)
	{
	extract($params);
//	$editor = sysModGetVar('SYS_config', 'texteditor');
  $editor=1;
	if (empty($width))
		$width = "80%";
	if (empty($height))
		$height = 400;

  if (empty($name_element))
		$name_element = $name;

	//Не вставляем повторно базовый JS tiny mce
	static $tiny_mce_js_loaded = false;

	if ($editor == 1)
		{
		if (!$tiny_mce_js_loaded)
			{
			echo '<script type="text/javascript" src="/scripts/java_scripts/tiny_mce/tiny_mce.js"></script>';
			$tiny_mce_js_loaded = true;
			}

		//В зависимости от стиля формируем JS
		if ($style == 'simple')
			{
			echo '<script type="text/javascript">tinyMCE.init({language:"ru", mode:"exact", elements:"' . $name . '", theme:"simple"});</script>';
			}
		elseif($style == 'blog')
      {
      echo '<script type="text/javascript" >
      tinyMCE.init({
        language : "ru",
        mode:"exact",
        elements:"' . $name . '",
        theme : "advanced",
        plugins : "emotions,spellchecker,advhr,insertdatetime,preview,sys_image",

        // Theme options - button# indicated the row# only
        theme_advanced_buttons1 : "newdocument,|,bold,italic,underline,|,justifyleft,justifycenter,justifyright,fontselect,fontsizeselect",
        theme_advanced_buttons2 : "cut,copy,paste,|,bullist,numlist,|,outdent,indent,|,undo,redo,|,link,unlink,image,|,code,preview,|,forecolor,backcolor",
        theme_advanced_buttons3 : "insertdate,inserttime,|,spellchecker,advhr,,removeformat,|,sub,sup,|,charmap,emotions",
        theme_advanced_toolbar_location : "top",
        theme_advanced_toolbar_align : "left",
        theme_advanced_statusbar_location : "bottom",
        content_css : "/themes/'.'test'.'/style/style.css"
        });
      </script >';
/*      			echo '<script type="text/javascript">tinyMCE.init({language:"ru", mode:"exact", elements:"' . $name . '",	theme : "advanced",
				plugins : "pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,inlinepopups,autosave",

				// Theme options
				theme_advanced_buttons1 : "save,newdocument,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,|,styleselect,formatselect,fontselect,fontsizeselect",
				theme_advanced_buttons2 : "cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,help,code,|,insertdate,inserttime,preview,|,forecolor,backcolor",
				theme_advanced_buttons3 : "tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,emotions,iespell,media,advhr,|,print,|,ltr,rtl,|,fullscreen",
				theme_advanced_buttons4 : "insertlayer,moveforward,movebackward,absolute,|,styleprops,|,cite,abbr,acronym,del,ins,attribs,|,visualchars,nonbreaking,template,pagebreak,restoredraft",
				theme_advanced_toolbar_location : "top",
				theme_advanced_toolbar_align : "left",
				theme_advanced_statusbar_location : "bottom",
				theme_advanced_resizing : true,

				// Example word content CSS (should be your site CSS) this one removes paragraph margins
				content_css : "/themes/'.sysUserTheme().'/style/style.css"});</script>';*/
      }
		else //if ($style == 'word')
			{
			echo '<script type="text/javascript">tinyMCE.init({language:"ru", mode:"exact", elements:"' . $name . '",	theme : "advanced",
				plugins : "pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,inlinepopups,autosave",

				// Theme options
				theme_advanced_buttons1 : "save,newdocument,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,|,styleselect,formatselect,fontselect,fontsizeselect",
				theme_advanced_buttons2 : "cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,help,code,|,insertdate,inserttime,preview,|,forecolor,backcolor",
				theme_advanced_buttons3 : "tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,emotions,iespell,media,advhr,|,print,|,ltr,rtl,|,fullscreen",
				theme_advanced_buttons4 : "insertlayer,moveforward,movebackward,absolute,|,styleprops,|,cite,abbr,acronym,del,ins,attribs,|,visualchars,nonbreaking,template,pagebreak,restoredraft",
				theme_advanced_toolbar_location : "top",
				theme_advanced_toolbar_align : "left",
				theme_advanced_statusbar_location : "bottom",
				theme_advanced_resizing : true,

				// Example word content CSS (should be your site CSS) this one removes paragraph margins
				content_css : "/themes/'.'test'.'/style/style.css"});</script>';
			}
		echo "<textarea name=\"$name_element\" id=\"$name\" rows=\"22\" cols=\"78\" style=\"text-indent:0; width: $width; height: $height\">" . $text . "</textarea>";
		}
	else
		{
		echo "<textarea name=\"$name_element\" rows=\"22\" cols=\"78\" style=\"width: $width; height: $height\" wrap=\"virtual\">" . $text . "</textarea>";
		}

	return $result;
	}

?>