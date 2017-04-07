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
  
  $config = & $smarty->getTemplateVars('config');
  
  $lang = substr(\App::$config['lang'], 0, 2);
  
  if (empty ($type)) $type='basic';
  if (empty ($name)) $name='texteditor_'.$bbeditor_num;
  if (empty ($id)) $id='texteditor_'.$bbeditor_num;
  if (empty ($class)) $class='texteditor_class';
  if (empty ($width)) $width = '100%';
  if (empty ($height)) $height=425;
  
  appJsLoad('kernel', 'tinymce');
//  appCssLoad('kernel', 'default','jsBBCode');
  
  echo "<textarea id='$id' name='$name' class='$class texteditor' style='height:{$height}px;width:{$width};'>" . htmlspecialchars($text, ENT_QUOTES) . "</textarea>";
  
  
  $tinyMCETypes['classic'] = '       
tinymce.init({
  selector: "textarea#'.$id.'",
  height: 500,
  plugins: [
    "advlist autolink autosave link image lists charmap print preview hr anchor pagebreak spellchecker imagetools",
    "searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking",
    "table contextmenu directionality emoticons template textcolor paste fullpage textcolor colorpicker textpattern"
  ],

  toolbar1: "newdocument fullpage | bold italic underline strikethrough | alignleft aligncenter alignright alignjustify | styleselect formatselect fontselect fontsizeselect",
  toolbar2: "cut copy paste | searchreplace | bullist numlist | outdent indent blockquote | undo redo | link unlink anchor image media code | insertdatetime preview | forecolor backcolor",
  toolbar3: "table | hr removeformat | subscript superscript | charmap emoticons | print fullscreen | ltr rtl | spellchecker | visualchars visualblocks nonbreaking template pagebreak restoredraft",

  menubar: false,
  toolbar_items_size: "small",

  style_formats: [{
    title: "Bold text",
    inline: "b"
  }, {
    title: "Red text",
    inline: "span",
    styles: {
      color: "#ff0000"
    }
  }, {
    title: "Red header",
    block: "h1",
    styles: {
      color: "#ff0000"
    }
  }, {
    title: "Example 1",
    inline: "span",
    classes: "example1"
  }, {
    title: "Example 2",
    inline: "span",
    classes: "example2"
  }, {
    title: "Table styles"
  }, {
    title: "Table row 1",
    selector: "tr",
    classes: "tablerow1"
  }],

  templates: [{
    title: "Test template 1",
    content: "Test 1"
  }, {
    title: "Test template 2",
    content: "Test 2"
  }],
  content_css: [
    "/public/js/tinymce/skins/lightgray/codepen.min.css"
  ]
});';
  
  
$tinyMCETypes['basic'] = '  
tinymce.init({
  selector: "textarea#'.$id.'",
  file_browser_callback: elFinderBrowser,
  height: 500,
  plugins: [
    "advlist autolink lists link image charmap print preview anchor imagetools",
    "searchreplace visualblocks code fullscreen",
    "insertdatetime media table contextmenu paste code"
  ],
  toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image",
  content_css: "//www.tinymce.com/css/codepen.min.css"
});

';

$tinyMCETypes['bbcode'] = '
tinymce.init({
  selector: "textarea#'.$id.'",  // change this value according to your HTML
  plugins: "bbcode"
});
';
  

$initScript = (isset($tinyMCETypes[$type])) ? $tinyMCETypes[$type] : $tinyMCETypes['basic'];

  echo '<script>
      if(typeof tinyMCE == "undefined") 
        {
        $.ajax({
            async: false,
            url: "//cdn.tinymce.com/4/tinymce.min.js",
            dataType: "script"
        });
        }
        

        
    $(document).ready(function(){
        if(typeof(tinymce) != "undefined") 
        {
            '.$initScript.'
        }
    });

if(typeof (window.elFinderBrowser) != "function") {
  function elFinderBrowser (field_name, url, type, win) {
    var elfinder_url = "/admin/files/jsplugin";    // use an absolute path!
    tinyMCE.activeEditor.windowManager.open({
      file: elfinder_url,
      title: "Select Image",
      width: 900,  
      height: 450,
      resizable: "yes",
      inline: "yes",    // This parameter only has an effect if you use the inlinepopups plugin!
      popup_css: false, // Disable TinyMCE default popup CSS
      close_previous: "no"
    }, 
    {
      setUrl: function (url) {
        win.document.getElementById(field_name).value = url;
      }
    });
    return false;
  }
}
</script>';
	}

?>