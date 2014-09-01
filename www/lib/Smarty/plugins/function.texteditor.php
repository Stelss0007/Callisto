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
  if (empty ($width)) $width = '100%';
  if (empty ($height)) $height=425;
  
  appJsLoad('kernel', 'tinymce');
//  appCssLoad('kernel', 'default','jsBBCode');
  
  echo "<textarea id='$id' name='$name' class='$class' style='height:{$height}px;width:{$width};'>" . htmlspecialchars($text, ENT_QUOTES) . "</textarea>";
  echo '<script>
      if(typeof tinyMCE == "undefined") 
        {
//        $.getScript("/public/js/tinymce/tinymce.js", function() {
//        
//        });
        
        $.ajax({
            async: false,
            url: "/public/js/tinymce/tinymce.js",
            dataType: "script"
        });
        }
        

        
    $(document).ready(function(){
            var tinyMCEPreInit = {
            suffix: "",
            base: "/public/js/tinymce/",
            query: ""
        };
        tinyMCE.baseURL="/public/js/tinymce/";
        
        tinyMCE.init({
            relative_urls : true,
            relative_urls : "/public/js/tinymce/",
            remove_script_host : false,
            convert_urls : true,
        // General options
        mode : "exact",
        
        force_br_newlines : false,
        convert_newlines_to_brs : true,
        remove_linebreaks : false,    
        
        elements : "'.$id.'",
        theme : "advanced",
        //resize: false,
        autoresize_min_height: 400,
        autoresize_max_height: 400,
        
        plugins : "autolink,lists,spellchecker,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template",

        // Theme options
        theme_advanced_buttons1 : "save,newdocument,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,|,styleselect,formatselect,fontselect,fontsizeselect",
        theme_advanced_buttons2 : "cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,help,code,|,insertdate,inserttime,preview,|,forecolor,backcolor",
        theme_advanced_buttons3 : "tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,emotions,iespell,media,advhr,|,print,|,ltr,rtl,|,fullscreen",
        theme_advanced_buttons4 : "insertlayer,moveforward,movebackward,absolute,|,styleprops,spellchecker,|,cite,abbr,acronym,del,ins,attribs,|,visualchars,nonbreaking,template,blockquote,pagebreak,|,insertfile,insertimage",
        theme_advanced_toolbar_location : "top",
        theme_advanced_toolbar_align : "left",
        theme_advanced_statusbar_location : "bottom",
        theme_advanced_resizing : false,

        // Drop lists for link/image/media/template dialogs
        template_external_list_url : "/js/template_list.js",
        external_link_list_url : "/js/link_list.js",
        external_image_list_url : "/js/image_list.js",
        media_external_list_url : "/js/media_list.js",
        
        file_browser_callback : "elFinderBrowser" 

});

});

if(typeof (window.elFinderBrowser) != "function") {
  function elFinderBrowser (field_name, url, type, win) {
    var elfinder_url = "/admin/files/jsplugin";    // use an absolute path!
    tinyMCE.activeEditor.windowManager.open({
      file: elfinder_url,
      title: "elFinder 2.0",
      width: 900,  
      height: 450,
      resizable: "yes",
      inline: "yes",    // This parameter only has an effect if you use the inlinepopups plugin!
      popup_css: false, // Disable TinyMCE default popup CSS
      close_previous: "no"
    }, {
      window: win,
      input: field_name
    });
    return false;
  }
}
</script>';
	}

?>