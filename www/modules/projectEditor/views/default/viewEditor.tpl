<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<title>PHP File Tree Demo</title>
		<meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
		
    
    <meta charset="utf-8"/>

    <link rel=stylesheet href="/modules/projectEditor/js/lib/codemirror.css">
    <link rel=stylesheet href="/modules/projectEditor/js/theme/monokai.css">
    <link rel=stylesheet href="/modules/projectEditor/js/doc/docs.css">
    <link rel=stylesheet href="/modules/projectEditor/js/addon/hint/show-hint.css">
      
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
    

{*    <script src="/modules/projectEditor/js/doc/activebookmark.js"></script>*}


    <link rel="stylesheet" href="/modules/projectEditor/css/jquery-ui.css">
      
    
    {literal}<style type="text/css">.CodeMirror {border-top: 1px solid black; border-bottom: 1px solid black; height: 100%}</style>{/literal}
<!--    <link rel="stylesheet" href="/modules/projectEditor/css/docs.css">-->
    
    <script src="/modules/projectEditor/js/jquery.js" type="text/javascript"></script>
    <script src="/modules/projectEditor/js/jquery-ui.js" type="text/javascript"></script>
		<script src="/modules/projectEditor/js/php_file_tree_jquery.js" type="text/javascript"></script>
    <script src="/modules/projectEditor/js/default.js" type="text/javascript"></script>
    
    <link href="/modules/projectEditor/css/default.css" rel="stylesheet" type="text/css" media="screen" />
	</head>

	<body>
	
    <table height="100%" width="100%"  style="border: 1px solid #000; max-height: 100%">
      <tr>
        <td colspan="2" height="35" class="editor-menu">
          menu
        </td>
      </tr>
    
      <tr>
        <td height="100%" width="300" style="border: 1px solid #000;" valign="top">
          <div style="width: 300px; height: 100%; overflow: scroll;">
            {$phpTree}
          </div>
        </td>
        <td height="100%" width="*" class="editor-text" style="border: 1px solid #000; max-height: 100%" valign="top">
         
          <div id="tabs">
            <ul>
            </ul>
          </div>
          
        </td>
      </tr>
      
    </table>
		
	</body>
	
</html>