<!DOCTYPE html>
<html lang="en">
<head>
	<!--
		Charisma v1.0.0

		Copyright 2012 Muhammad Usman
		Licensed under the Apache License v2.0
		http://www.apache.org/licenses/LICENSE-2.0

		http://usman.it
		http://twitter.com/halalit_usman
	-->
	<meta charset="utf-8">
	<title>{$site_title}</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="description" content="{$site_metadescription}">
  {appCssOutput cache=0}
  {literal}
    <style type="text/css">
      body {
        background: #eee !important;	
      }

      .wrapper {	
        margin-top: 80px;
        margin-bottom: 80px;
      }

      .form-signin {
        max-width: 380px;
        padding: 15px 35px 45px;
        margin: 0 auto;
        background-color: #fff;
        border: 1px solid rgba(0,0,0,0.1);
        border-radius: 20px;
        box-shadow: 8px 8px 8px #DEDEDE;
        position: relative;
      }
      
      .form-signin .glyphicon-home {
        position: absolute;
        right: 20px;
        top: 15px;
      }
      .input-group {
        margin: 5px 0px;
      }
    </style>
  {/literal}
  
	<link href="/public/css/bootstrap.css" rel="stylesheet">

	<!-- The HTML5 shim, for IE6-8 support of HTML5 elements -->
	<!--[if lt IE 9]>
	  <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->

	<!-- The fav icon -->
	<link rel="shortcut icon" href="img/favicon.ico">
		
</head>

<body>
		{$module_content}
    {appJsOutput}
</body>
</html>