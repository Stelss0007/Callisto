var editor =null;
var delay;
var tabCounter = 2, tabs, IDEtheme, dialog;
var mime = [];
var openTabs = [];

mime['ext-php'] = "application/x-httpd-php";
mime['ext-css'] = "text/css";
mime['ext-js']  = "text/javascript";
//mime['ext-tpl'] = "text/x-smarty";
mime['ext-tpl'] = "application/x-httpd-php";
mime['ext-html'] = "text/html";


var movies = [
                { Name: "The Red Violin", ReleaseYear: "1998" },
                { Name: "Eyes Wide Shut", ReleaseYear: "1999" },
                { Name: "The Inheritance", ReleaseYear: "1976" }
              ];



Array.prototype.remove = function(v) { this.splice(this.indexOf(v) == -1 ? this.length : this.indexOf(v), 1); }

function progresStart()
  {
  $('#ide-overlay').show();
  }
function progresEnd()
  {
  $('#ide-overlay').hide();
  }
function saveProject()
  {
  $.post('/projectEditor/saveProject', {openTabs: openTabs}, function(data) {
    //console.log('ok');
    });
  }

function getFileTree()
  {
  $.post('/projectEditor/get_file_tree', {}, function(data) {
      $('#fileTree').html(data);
      fileTreeinit();
      });
  }

function doCMDRequest(cmd, dataCMD, ui)
  {
  $.post('/projectEditor/' + cmd, dataCMD, function(data) {
      dialog.dialog( "close" );
      if(data == 'OK')
        {
        getFileTree();
        }
      else 
        {
        alert(data);
        }

      });
  }
function doCMD(ui)
  {
  var dataCMD={};
  var cmd = ui.cmd;
  if(ui.target.attr('data-src'))
    {
    src = ui.target.attr('data-src');
    }
  else 
    {
    src = ui.target.parent().attr('data-src');
    }
  
  switch (cmd)
    {
      case 'create_folder':
        dialog.dialog("option", "title", "New Folder");
        dialog.dialog(
            'option',
            'buttons', {
                "Create": function () {doCMDRequest(cmd, {currentFolder: $('#currentFolder').val(), newFolder: $('#newFolder').val()}, ui)},
                "Cancel": function () { dialog.dialog( "close" ); }
            }
          );
        var params = [{'curentFolder' : src }];
        $("#dialog-content").html($("#addFolderDialog").tmpl(params));
        $('#newFolder').focus()
                       .mouseup(function(){$(this).select();})
                       .select()
                       .keyup(function () {
                            var impt = $(this).val();
                            $("#pathSrc").html(impt);
                        });
        ;
        
        dialog.dialog( "open" );
        break;
        
      case 'create_file':
        dialog.dialog("option", "title", "New File");
        dialog.dialog(
            'option',
            'buttons', {
                "Create": function () {alert('ok')},
                "Cancel": function () { dialog.dialog( "close" ); }
            }
          );
        dialog.dialog( "open" );
        break;
        
      case 'rename':
        dialog.dialog("option", "title", "Rename");
        dialog.dialog(
            'option',
            'buttons', {
                "Rename": function () {alert('ok')},
                "Cancel": function () { dialog.dialog( "close" ); }
            }
          );
        dialog.dialog( "open" );
        break;
        
      default:
        cmd = false;
        break;
    }

  }

function openProject()
  {
  var openDir = [];
  $.post('/projectEditor/openProject', {openTabs: openTabs}, function(data) {
    
    $.each(data, function( index, path ) {
      var pathArr = path.replace('.', '_').split('/'); 
        var currentPath = '.php-file-tree > ';
      
      $.each(pathArr, function(index, value) { 
        if(index == 0)
         return;
       
        currentPath += ' .file-tree-' + value;
        
        if(jQuery.inArray(currentPath, openDir) > -1)
          return;
        
        openDir.push(currentPath);
        //alert(currentPath+' a');
        $(currentPath).children('a').click();
      });
     
     });
    }, "json");
  }

function selectTheme() 
  {
  var input = document.getElementById("selectTheme");
  IDEtheme = input.options[input.selectedIndex].innerHTML;
  
  if(editor != null)
    editor.setOption("theme", IDEtheme);
  }

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
        autoCloseTags: true,
        matchTags: {bothTags: true},
        theme: IDEtheme,
        extraKeys: {
          "Ctrl-Space": "autocomplete", 
          "Ctrl-J": "toMatchingTag",
          "Ctrl-S": function(instance) { 
            saveFile(instance.getValue()); 
            return false;
            }
          },
//        onChange: function() {
//          clearTimeout(delay);
//          delay = setTimeout(updatePreview, 300);
//        }
        });
    }

 function saveFile(text)
  {
  progresStart();
  var fileSrc   = $('#tabs .ui-tabs-active .ui-icon-close').attr('data-file-src');
  $.post('/projectEditor/saveFile', {fileSrc: fileSrc, fileSource: text}, function(data) {
    console.log('ok');
  });
  
  progresEnd()
  return false;
  }

 function updatePreview() 
  {
  var previewFrame = document.getElementById('preview');
  var preview =  previewFrame.contentDocument ||  previewFrame.contentWindow.document;
  preview.open();
  preview.write(editor.getValue());
  preview.close();
  }
  
  
   function addImageTab(title, content, mime, fileHref) 
    {
    tabCounter++;
    var 
      id = "tabs-" + tabCounter,
      li = "<li><a title='"+fileHref+"' href='#"+id+"'>"+title+"</a> <span class='ui-icon ui-icon-close' role='presentation' data-file-src='"+fileHref+"'>Remove Tab</span></li>",
      tabHeight = $('.editor-text').height() - 50;

    tabs.find( ".ui-tabs-nav" ).append( li );
    tabs.append( "<div id='" + id + "' style='height: "+tabHeight+"px; ' class='image-tab'><span class='helper'></span><img id='codeEdit-"+tabCounter+"' name='codeEdit-"+tabCounter+"' src=''></div>" );
    tabs.tabs( "refresh" );
    tabs.tabs('select', $(".ui-tabs-nav").children().size() - 1);

    $('#codeEdit-'+tabCounter).attr('src', content);
  
    }
  
  
  function addTab(title, content, mime, fileHref) 
    {
    tabCounter++;
    var 
      id = "tabs-" + tabCounter,
      li = "<li><a title='"+fileHref+"' href='#"+id+"'>"+title+"</a> <span class='ui-icon ui-icon-close' role='presentation' data-file-src='"+fileHref+"'>Remove Tab</span></li>",
      tabHeight = $('.editor-text').height() - 50;

    tabs.find( ".ui-tabs-nav" ).append( li );
    tabs.append( "<div id='" + id + "' style='height: "+tabHeight+"px; '><textarea id='codeEdit-"+tabCounter+"' name='codeEdit-"+tabCounter+"'></textarea></div>" );
    tabs.tabs( "refresh" );
    tabs.tabs('select', $(".ui-tabs-nav").children().size() - 1);
    
    $('#codeEdit-'+tabCounter).val(content);
    setCodeStyle(mime, 'codeEdit-'+tabCounter);
 
    }
      
$(document).ready(function(){
  selectTheme();
  
  $('.editor-text').height($(window).height() - $('.editor-menu').height() - $('#editor-tab-src').height() - 25 );
  $('.editor-text').width($(window).width() - 300);
  $('.editor-text').css('maxWidth', $(window).width() - 300);
  
  tabs = $( "#tabs" ).tabs({
                            activate: function (e, ui) {
                                        $('#editor-tab-src').html(ui.newTab.find('a').attr('title'));
                                      }
    });
  
  // close icon: removing the tab on click
  tabs.delegate("span.ui-icon-close", "click", function() {
    var $this = $(this);
    var fileHref = $this.attr('data-file-src');
    var panelId = $this.closest("li").remove().attr("aria-controls");
    $("#" + panelId).remove();
    openTabs.remove(fileHref);
    tabs.tabs("refresh");
    saveProject();
  });
  
  $('.pft-file a').click(function(){
    progresStart();
    
    //var parentClasses = $(this).parent().attr('class');
    var parentClasses = $(this).attr('class');
    var ext = parentClasses.replace("pft-file ","");
    var label = $(this).html();
    
//    $('#codeEdit').load($(this).attr('href'), function(){
//      setCodeStyle(mime[ext]);
//    });
    var fileHref  = $(this).attr('href'),
        tabNumber = jQuery.inArray(fileHref.substring(31), openTabs)
        ;
    
    if(tabNumber > -1)
      {
      tabs.tabs('select', tabNumber);
      progresEnd();
      return false;
      }
    
    $.post(fileHref, function(data) {
      fileHref = fileHref.substring(31);
      openTabs.push(fileHref);
      
      switch (ext) 
        {
        case 'ext-gif':
        case 'ext-png':
        case 'ext-jpg':
        case 'ext-jepg':
        case 'ext-ico':
          addImageTab(label, data, mime[ext], fileHref);
          break;
        default:
          addTab(label, data, mime[ext], fileHref);
        }
      progresEnd();
      saveProject();
    });
    
    return false;
  });
  
  
  
  $(".php-file-tree").contextmenu({
      delegate: ".hasmenu-dir, .hasmenu-file",
      menu: [
          {title: "Create", children: [
              {title: "Folder", cmd: "create_folder"},
              {title: "File", cmd: "create_file"}
              ]},
          {title: "Rename", cmd: "rename"},
          {title: "Copy", cmd: "copy"},
          {title: "Paste", cmd: "paste"}
          ],
      select: function(event, ui) {doCMD(ui);}
    });
    
  dialog = $( "#editor-dialog-form-wraper" ).dialog({
      autoOpen: false,
      height: 200,
      width: 550,
      modal: true,
      resizable: false,
      buttons: {
        "Create an account": function cmd(){alert('ok')},
        Cancel: function() {
          dialog.dialog( "close" );
        }
      },
      close: function() {
        //$("#editor-dialog-form-wraper form").reset();
        //allFields.removeClass( "ui-state-error" );
      }
    });
 
  
  openProject();
  progresEnd();
  //setCodeStyle('html');
  //setTimeout(updatePreview, 300);
});

