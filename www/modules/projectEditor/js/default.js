var editor =null;
var delay;
var mime = [];
mime['ext-php'] = "application/x-httpd-php";
mime['ext-css'] = "text/css";
mime['ext-js']  = "text/javascript";
mime['ext-tpl'] = "application/x-httpd-php";
mime['ext-html'] = "text/html";


function setCodeStyle(mime)
    {
    $('.CodeMirror').remove();  
    
    CodeMirror.commands.autocomplete = function(cm) {
        CodeMirror.simpleHint(cm, CodeMirror.javascriptHint);
      }
      
    editor = CodeMirror.fromTextArea(document.getElementById("codeEdit"), {
        lineNumbers: true,
        matchBrackets: true,
        mode: mime,
        indentUnit: 4,
        indentWithTabs: true,
        enterMode: "keep",
        tabMode: "shift",
        extraKeys: {"Ctrl-Space": "autocomplete"},
        onChange: function() {
          clearTimeout(delay);
          delay = setTimeout(updatePreview, 300);
        }
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
      
$(document).ready(function(){
  
  $('.pft-file a').click(function(){
    var parentClasses = $(this).parent().attr('class');
    var ext = parentClasses.replace("pft-file ","");
    
//    $('#codeEdit').load($(this).attr('href'), function(){
//      setCodeStyle(mime[ext]);
//    });
    
    $.post($(this).attr('href'), function(data) {
      $('#codeEdit').val(data);
      setCodeStyle(mime[ext]);
    });
    
    return false;
  });
  
  setCodeStyle();
  setTimeout(updatePreview, 300);
});

