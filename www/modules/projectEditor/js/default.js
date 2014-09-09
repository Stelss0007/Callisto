var editor =null;
var delay;
var tabCounter = 2, tabs;
var mime = [];
mime['ext-php'] = "application/x-httpd-php";
mime['ext-css'] = "text/css";
mime['ext-js']  = "text/javascript";
//mime['ext-tpl'] = "text/x-smarty";
mime['ext-tpl'] = "application/x-httpd-php";
mime['ext-html'] = "text/html";


function setCodeStyle(mime, element)
    {
    //$('.CodeMirror').remove();  
    
//    CodeMirror.commands.autocomplete = function(cm) {
//        CodeMirror.simpleHint(cm, CodeMirror.javascriptHint);
//      }
  
    editor = CodeMirror.fromTextArea(document.getElementById(element), {
        lineNumbers: true,
        matchBrackets: true,
        mode: {name: mime, globalVars: true},
        indentUnit: 4,
        indentWithTabs: true,
        enterMode: "keep",
        keyMap: "sublime",
        autoCloseBrackets: true,
        tabMode: "shift",
        //theme: "monokai",
        extraKeys: {"Ctrl-Space": "autocomplete"},
//        onChange: function() {
//          clearTimeout(delay);
//          delay = setTimeout(updatePreview, 300);
//        }
        });
    }
    
 function updatePreview() 
  {
  var previewFrame = document.getElementById('preview');
  var preview =  previewFrame.contentDocument ||  previewFrame.contentWindow.document;
  preview.open();
  preview.write(editor.getValue());
  preview.close();
  }
  
  
  
  function addTab(title, content, mime) 
    {
    tabCounter++;
    var 
      id = "tabs-" + tabCounter,
      li = "<li><a href='#"+id+"'>"+title+"</a> <span class='ui-icon ui-icon-close' role='presentation'>Remove Tab</span></li>",
      tabHeight = $('.editor-text').height() - 50;

    tabs.find( ".ui-tabs-nav" ).append( li );
    tabs.append( "<div id='" + id + "' style='height: "+tabHeight+"px; '><textarea id='codeEdit-"+tabCounter+"' name='codeEdit-"+tabCounter+"'></textarea></div>" );
    tabs.tabs( "refresh" );
    tabs.tabs('select', $(".ui-tabs-nav").children().size() - 1);
    
    $('#codeEdit-'+tabCounter).val(content);
    setCodeStyle(mime, 'codeEdit-'+tabCounter);
 
    }
      
$(document).ready(function(){
  
  $('.editor-text').height($(window).height() - $('.editor-menu').height() - 25);
  
  tabs = $( "#tabs" ).tabs();
  
  // close icon: removing the tab on click
  tabs.delegate( "span.ui-icon-close", "click", function() {
    var panelId = $( this ).closest( "li" ).remove().attr( "aria-controls" );
    $( "#" + panelId ).remove();
    tabs.tabs( "refresh" );
  });
  
  $('.pft-file a').click(function(){
    var parentClasses = $(this).parent().attr('class');
    var ext = parentClasses.replace("pft-file ","");
    var label = $(this).html();
    
//    $('#codeEdit').load($(this).attr('href'), function(){
//      setCodeStyle(mime[ext]);
//    });
    
    $.post($(this).attr('href'), function(data) {
      
      addTab(label, data, mime[ext]);
    });
    
    return false;
  });
  
  //setCodeStyle('html');
  //setTimeout(updatePreview, 300);
});

