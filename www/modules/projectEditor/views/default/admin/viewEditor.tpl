<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<title>PHP File Tree Demo</title>
		<meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
		
    
    <meta charset="utf-8"/>

    <link rel=stylesheet href="/modules/projectEditor/js/lib/codemirror.css">
    <link rel=stylesheet href="/modules/projectEditor/js/theme/monokai.css">
    <link rel=stylesheet href="/modules/projectEditor/js/doc/docs.css">
    <link rel=stylesheet href="/modules/projectEditor/js/addon/dialog/dialog.css">
    <link rel=stylesheet href="/modules/projectEditor/js/addon/hint/show-hint.css">
      
    <script src="/modules/projectEditor/js/base64.js"></script>
    <script src="/modules/projectEditor/js/lib/codemirror.js"></script>
    <script src="/modules/projectEditor/js/mode/clike/clike.js"></script>
    <script src="/modules/projectEditor/js/mode/xml/xml.js"></script>
    <script src="/modules/projectEditor/js/mode/php/php.js"></script>
    <script src="/modules/projectEditor/js/mode/javascript/javascript.js"></script>
    <script src="/modules/projectEditor/js/mode/css/css.js"></script>
    <script src="/modules/projectEditor/js/mode/htmlmixed/htmlmixed.js"></script>
    <script src="/modules/projectEditor/js/mode/smarty/smarty.js"></script>
    <script src="/modules/projectEditor/js/mode/smartymixed/smartymixed.js"></script>
    <script src="/modules/projectEditor/js/mode/sql/sql.js"></script>
    
    <script src="/modules/projectEditor/js/addon/edit/matchbrackets.js"></script>
    <script src="/modules/projectEditor/js/keymap/sublime.js"></script>
    
    {*HINTS autocomplate*}
    <script src="/modules/projectEditor/js/addon/hint/show-hint.js"></script>
    <script src="/modules/projectEditor/js/addon/hint/javascript-hint.js"></script>
    <script src="/modules/projectEditor/js/addon/hint/css-hint.js"></script>
    <script src="/modules/projectEditor/js/addon/hint/html-hint.js"></script>
    <script src="/modules/projectEditor/js/addon/hint/simple-hint.js"></script>
    <script src="/modules/projectEditor/js/addon/hint/sql-hint.js"></script>
    
    
    {*ADDONs*}
    <script src="/modules/projectEditor/js/addon/edit/closebrackets.js"></script>
    <script src="/modules/projectEditor/js/addon/edit/closetag.js"></script>
    <script src="/modules/projectEditor/js/addon/fold/xml-fold.js"></script>
    <script src="/modules/projectEditor/js/addon/edit/matchtags.js"></script>
    
    <script src="/modules/projectEditor/js/addon/dialog/dialog.js"></script>
    <script src="/modules/projectEditor/js/addon/search/searchcursor.js"></script>
    <script src="/modules/projectEditor/js/addon/search/search.js"></script>

{*    <script src="/modules/projectEditor/js/doc/activebookmark.js"></script>*}


    <link rel="stylesheet" href="/modules/projectEditor/css/jquery-ui.css">
      
    {*THEMES*}
    <link rel="stylesheet" href="/modules/projectEditor/js/theme/3024-day.css">
    <link rel="stylesheet" href="/modules/projectEditor/js/theme/3024-night.css">
    <link rel="stylesheet" href="/modules/projectEditor/js/theme/ambiance.css">
    <link rel="stylesheet" href="/modules/projectEditor/js/theme/base16-dark.css">
    <link rel="stylesheet" href="/modules/projectEditor/js/theme/base16-light.css">
    <link rel="stylesheet" href="/modules/projectEditor/js/theme/blackboard.css">
    <link rel="stylesheet" href="/modules/projectEditor/js/theme/cobalt.css">
    <link rel="stylesheet" href="/modules/projectEditor/js/theme/eclipse.css">
    <link rel="stylesheet" href="/modules/projectEditor/js/theme/elegant.css">
    <link rel="stylesheet" href="/modules/projectEditor/js/theme/erlang-dark.css">
    <link rel="stylesheet" href="/modules/projectEditor/js/theme/lesser-dark.css">
    <link rel="stylesheet" href="/modules/projectEditor/js/theme/mbo.css">
    <link rel="stylesheet" href="/modules/projectEditor/js/theme/mdn-like.css">
    <link rel="stylesheet" href="/modules/projectEditor/js/theme/midnight.css">
    <link rel="stylesheet" href="/modules/projectEditor/js/theme/monokai.css">
    <link rel="stylesheet" href="/modules/projectEditor/js/theme/neat.css">
    <link rel="stylesheet" href="/modules/projectEditor/js/theme/neo.css">
    <link rel="stylesheet" href="/modules/projectEditor/js/theme/night.css">
    <link rel="stylesheet" href="/modules/projectEditor/js/theme/paraiso-dark.css">
    <link rel="stylesheet" href="/modules/projectEditor/js/theme/paraiso-light.css">
    <link rel="stylesheet" href="/modules/projectEditor/js/theme/pastel-on-dark.css">
    <link rel="stylesheet" href="/modules/projectEditor/js/theme/rubyblue.css">
    <link rel="stylesheet" href="/modules/projectEditor/js/theme/solarized.css">
    <link rel="stylesheet" href="/modules/projectEditor/js/theme/the-matrix.css">
    <link rel="stylesheet" href="/modules/projectEditor/js/theme/tomorrow-night-eighties.css">
    <link rel="stylesheet" href="/modules/projectEditor/js/theme/twilight.css">
    <link rel="stylesheet" href="/modules/projectEditor/js/theme/vibrant-ink.css">
    <link rel="stylesheet" href="/modules/projectEditor/js/theme/xq-dark.css">
    <link rel="stylesheet" href="/modules/projectEditor/js/theme/xq-light.css">
      
    
    {literal}<style type="text/css">.CodeMirror {border-top: 1px solid black; border-bottom: 1px solid black; height: 100%}</style>{/literal}
<!--    <link rel="stylesheet" href="/modules/projectEditor/css/docs.css">-->
    
    <script src="/modules/projectEditor/js/jquery.js" type="text/javascript"></script>
    <script src="/modules/projectEditor/js/jquery-ui.js" type="text/javascript"></script>
    <script src="/public/js/jsTemplate/jsTemplate.js" type="text/javascript"></script>
		<script src="/modules/projectEditor/js/php_file_tree_jquery.js" type="text/javascript"></script>
    <script src="/modules/projectEditor/js/default.js" type="text/javascript"></script>
    <script src="/modules/projectEditor/js/context-menu/jquery.ui-contextmenu.min.js" type="text/javascript"></script>
    
    <link href="/modules/projectEditor/css/default.css" rel="stylesheet" type="text/css" media="screen" />
    
    
    {* JavaScript Templates *}
    {literal}
      <script id="addFolderDialog" type="text/x-jquery-tmpl">
        <div>
          <table width='100%'>
            <colgroup>
              <col width='120'>
              <col width='*'>
            </colgroup>
            
            <tr>
              <td>Folder Name:</td>
              <td>
                <input type='text' id='newFolder' name='newFolder' value='folder_name' placeholder='folder_name' width='100%' tabindex='1'>
              </td>
            </tr>
            <tr>
              <td>Parent Folder:</td>
              <td>
                <input type='text' id='currentFolder' name='currentFolder' disabled value='${curentFolder}' width='100%'>
              </td>
            </tr>
            <tr>
              <td>New Folder:</td>
              <td>
                ${curentFolder}/<span id='pathSrc'></span>
              </td>
            </tr>
          </table>
        </div>
      </script>
      
      <script id="addFileDialog" type="text/x-jquery-tmpl">
        <div>
          <table width='100%'>
            <colgroup>
              <col width='120'>
              <col width='*'>
            </colgroup>
            
            <tr>
              <td>File Name:</td>
              <td>
                <input type='text' id='newFile' name='newFile' value='file_name' placeholder='file_name' width='100%' tabindex='1'>
              </td>
            </tr>
            <tr>
              <td>Parent Folder:</td>
              <td>
                <input type='text' id='currentFolder' name='currentFolder' disabled value='${curentFolder}' width='100%'>
              </td>
            </tr>
            <tr>
              <td>New Folder:</td>
              <td>
                ${curentFolder}/<span id='pathSrc'></span>
              </td>
            </tr>
          </table>
        </div>
      </script>
      
      <script id="renameFileDialog" type="text/x-jquery-tmpl">
        <div>
          <table width='100%'>
            <colgroup>
              <col width='120'>
              <col width='*'>
            </colgroup>
            
            <tr>
              <td>Name:</td>
              <td>
                <input type='text' id='newObjectName' name='newObjectName' value='${realName}' placeholder='Enter Name' width='100%' tabindex='1'>
              </td>
            </tr>
            <tr style='display: none;'>
              <td>Parent Folder:</td>
              <td>
                <input type='text' id='currentObjectName' name='currentObjectName' disabled value='${currentObjectName}' width='100%'>
              </td>
            </tr>
            <tr>
              <td>Full SRC:</td>
              <td>
                ${currentObjectName}/<span id='pathSrc'></span>
              </td>
            </tr>
          </table>
        </div>
      </script>
      
    {/literal}

	</head>

	<body>
    <div id="ide-overlay">
      <span class="helper"></span>
      <img src="/public/images/system/preloader/preloader11.gif" width="300" height="20">
    </div>
    <table height="100%" width="100%"  style="border: 1px solid #000; max-height: 600px; height: 600px;">
      <tr>
        <td colspan="2" height="35" class="editor-menu">
          <table>
            <tr>
              <td>Menu</td>
              <td>
                Select a theme: 
                <select onchange="selectTheme()" id='selectTheme'>
                  <option selected>default</option>
                  <option>3024-day</option>
                  <option>3024-night</option>
                  <option>ambiance</option>
                  <option>base16-dark</option>
                  <option>base16-light</option>
                  <option>blackboard</option>
                  <option>cobalt</option>
                  <option>eclipse</option>
                  <option>elegant</option>
                  <option>erlang-dark</option>
                  <option>lesser-dark</option>
                  <option>mbo</option>
                  <option>mdn-like</option>
                  <option>midnight</option>
                  <option>monokai</option>
                  <option>neat</option>
                  <option>neo</option>
                  <option>night</option>
                  <option>paraiso-dark</option>
                  <option>paraiso-light</option>
                  <option>pastel-on-dark</option>
                  <option>rubyblue</option>
                  <option>solarized dark</option>
                  <option>solarized light</option>
                  <option>the-matrix</option>
                  <option>tomorrow-night-eighties</option>
                  <option>twilight</option>
                  <option>vibrant-ink</option>
                  <option>xq-dark</option>
                  <option>xq-light</option>
                </select>
              </td>
            </tr>
          </table>
        </td>
      </tr>
    
      <tr>
        <td height="600" width="300" style="border: 1px solid #000;" valign="top">
          <div style="width: 300px; height: 100%; overflow: scroll;" id='fileTree'>
            {$phpTree}
          </div>
        </td>
        <td height="100%" width="600" class="editor-text" style="border: 1px solid #000; max-height: 100%" valign="top">
         
          <div id="tabs">
            <ul>
            </ul>
          </div>
          
        </td>
      </tr>
      <tr>
        <td colspan="2" id="editor-tab-src">SRC</td>
      </tr>
      
    </table>
          
    <div id="editor-dialog-form-wraper" title="">
      <form id='editor-dialog-form'>
        <div id="dialog-content">
        </div>
      </form>
    </div>
		
	</body>
	
</html>