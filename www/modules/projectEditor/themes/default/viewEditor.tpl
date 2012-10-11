<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<title>PHP File Tree Demo</title>
		<meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
		
    
    <link rel="stylesheet" href="/modules/projectEditor/css/codemirror.css">
    <link rel="stylesheet" href="/modules/projectEditor/css/simple-hint.css">
    <link rel="stylesheet" href="/modules/projectEditor/css/jquery-ui.css">
      
    <script src="/modules/projectEditor/js/codemirror.js"></script>
    <script src="/modules/projectEditor/js/mode/xml.js"></script>
    <script src="/modules/projectEditor/js/mode/javascript.js"></script>
    <script src="/modules/projectEditor/js/mode/css.js"></script>
    <script src="/modules/projectEditor/js/mode/clike.js"></script>
    <script src="/modules/projectEditor/js/mode/php.js"></script>
    
    <script src="/modules/projectEditor/js/mode/simple-hint.js"></script>
    <script src="/modules/projectEditor/js/mode/javascript-hint.js"></script>
    
    {literal}<style type="text/css">.CodeMirror {border-top: 1px solid black; border-bottom: 1px solid black; height: 100%}</style>{/literal}
<!--    <link rel="stylesheet" href="/modules/projectEditor/css/docs.css">-->
    
    <script src="/modules/projectEditor/js/jquery.js" type="text/javascript"></script>
    <script src="/modules/projectEditor/js/jquery-ui.js" type="text/javascript"></script>
		<script src="/modules/projectEditor/js/php_file_tree.js" type="text/javascript"></script>
    <script src="/modules/projectEditor/js/default.js" type="text/javascript"></script>
    
    <link href="/modules/projectEditor/css/default.css" rel="stylesheet" type="text/css" media="screen" />
	</head>

	<body>
	
    <table height="100%" width="100%" style="border: 1px solid #000; min-height: 100%">
      <tr>
        <td colspan="2" height="35">
          menu
        </td>
      </tr>
    
      <tr>
        <td height="500px" width="300" style="border: 1px solid #000;" valign="top">
          <div style="width: 300px; height: 500px; overflow: scroll;">
            {$phpTree}
          </div>
        </td>
        <td height="500px" width="*" style="border: 1px solid #000;" valign="top">
                    
           
                    <textarea id='codeEdit' name='codeEdit'>
                    </textarea>
               
        </td>

      </tr>
      <tr>
        <td colspan="2">
          <iframe id='preview' style="width: 99%; height: 290px;"></iframe>
        </td>
      </tr>
    </table>
		
	</body>
	
</html>