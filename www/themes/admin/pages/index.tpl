<!DOCTYPE html>
<html>
<head>
	<!--
		Charisma v1.0.0

		Copyright 2012 Muhammad Usman
		Licensed under the Apache License v2.0
		http://www.apache.org/licenses/LICENSE-2.0

		http://usman.it
		http://twitter.com/halalit_usman
	-->
	{*<meta charset="utf-8">*}
	<meta charset="windows-1251">
	<title>Administration</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="description" content="Charisma, a fully featured, responsive, HTML5, Bootstrap admin template.">
	<meta name="author" content="Muhammad Usman">

	<!-- The styles -->
	<link href="/themes/admin/css/main.css" rel="stylesheet">

	<link href="/themes/admin/css/charisma-app.css" rel="stylesheet">
	<link href="/themes/admin/css/jquery-ui-1.8.21.custom.css" rel="stylesheet">
	<link href='/themes/admin/css/fullcalendar.css' rel='stylesheet'>
	<link href='/themes/admin/css/fullcalendar.print.css' rel='stylesheet'  media='print'>
	<link href='/themes/admin/css/chosen.css' rel='stylesheet'>
	<link href='/themes/admin/css/uniform.default.css' rel='stylesheet'>
	<link href='/themes/admin/css/colorbox.css' rel='stylesheet'>
	<link href='/themes/admin/css/jquery.cleditor.css' rel='stylesheet'>
	<link href='/themes/admin/css/jquery.noty.css' rel='stylesheet'>
	<link href='/themes/admin/css/noty_theme_default.css' rel='stylesheet'>
	<link href='/themes/admin/css/elfinder.min.css' rel='stylesheet'>
	<link href='/themes/admin/css/elfinder.theme.css' rel='stylesheet'>
	<link href='/themes/admin/css/jquery.iphone.toggle.css' rel='stylesheet'>
	{*<link href='/themes/admin/css/opa-icons.css' rel='stylesheet'>*}
	<link href='/themes/admin/css/uploadify.css' rel='stylesheet'>

	<!-- The HTML5 shim, for IE6-8 support of HTML5 elements -->
	<!--[if lt IE 9]>
	  <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->

	<!-- The fav icon -->
	<link rel="shortcut icon" href="img/favicon.ico">
		
</head>

<body>
{*  <div class="alert alert-dismissable alert-warning">
    <button type="button" class="close" data-dismiss="alert">&times;</button>
    <p><strong>Hello</p>
  </div>
  *}
		<!-- topbar starts -->
	<div class="navbar">
		<div class="navbar-inner">
			<div class="container-fluid">
				<a class="btn btn-navbar" data-toggle="collapse" data-target=".top-nav.nav-collapse,.sidebar-nav.nav-collapse">
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</a>
				<a class="brand" href="index.html"> <span>Callisto</span></a>
			
				<!-- user dropdown starts -->
				<div class="btn-group pull-right" >
					<a class="btn dropdown-toggle" data-toggle="dropdown" href="#">
						<i class="icon-user"></i><span class="hidden-phone"> admin</span>
						<span class="caret"></span>
					</a>
					<ul class="dropdown-menu">
						<li><a href="#">Profile</a></li>
						<li class="divider"></li>
						<li><a href="login.html">Logout</a></li>
					</ul>
				</div>
				<!-- user dropdown ends -->
				
				<div class="top-nav nav-collapse">
					<ul class="nav">
						<li><a href="#">Visit Site</a></li>
						<li>
							<form class="navbar-search pull-left">
								<input placeholder="Search" class="search-query span2" name="query" type="text">
							</form>
						</li>
					</ul>
				</div><!--/.nav-collapse -->
			</div>
		</div>
	</div>
	<!-- topbar ends -->
		<div class="container-fluid">
		<div class="row-fluid">
				
			<!-- left menu starts -->
			<div class="span2 main-menu-span">
				<div class="well nav-collapse sidebar-nav">
					<ul class="nav nav-tabs nav-stacked main-menu">
						<li class="nav-header hidden-tablet">Main</li>
						<li><a class="ajax-link" href="/admin/main"><i class="icon-home"></i><span class="hidden-tablet"> Dashboard</span></a></li>
						<li><a class="ajax-link" href="/admin/groups"><i class="icon-user"></i><span class="hidden-tablet"> Groups</span></a></li>
						<li><a class="ajax-link" href="/admin/users/users_list"><i class="icon-user"></i><span class="hidden-tablet"> Users</span></a></li>
            <li><a class="ajax-link" href="/admin/permissions"><i class="icon-eye-open"></i><span class="hidden-tablet"> Permission</span></a></li>
            <li><a class="ajax-link" href="/admin/menu"><i class="icon-list"></i><span class="hidden-tablet"> Menu</span></a></li>
            <li><a class="ajax-link" href="/admin/modules"><i class="icon-list-alt"></i><span class="hidden-tablet"> Modules</span></a></li>
            <li><a class="ajax-link" href="/admin/blocks"><i class="icon-th"></i><span class="hidden-tablet"> Blocks</span></a></li>
            <li><a class="ajax-link" href="/admin/theme"><i class="icon-picture"></i><span class="hidden-tablet"> Themes</span></a></li>
            <li><a class="ajax-link" href="/admin/files"><i class="icon-file"></i><span class="hidden-tablet"> Files</span></a></li>
            
            <li class="nav-header hidden-tablet"></li>
            <li><a class="ajax-link" href="/admin/permissions"><i class="icon-off"></i><span class="hidden-tablet"> LogOut</span></a></li>
					</ul>
					<label id="for-is-ajax" class="hidden-tablet" for="is-ajax"><input id="is-ajax" type="checkbox"> Ajax on menu</label>
				</div><!--/.well -->
			</div><!--/span-->
			<!-- left menu ends -->
			
			<noscript>
				<div class="alert alert-block span10">
					<h4 class="alert-heading">Warning!</h4>
					<p>You need to have <a href="http://en.wikipedia.org/wiki/JavaScript" target="_blank">JavaScript</a> enabled to use this site.</p>
				</div>
			</noscript>
			
			<div id="content" class="span10">
        <!-- content starts -->
        <div>
          <div class="breadcrumb">
            <i class="icon-home"></i>
            {browsein date=$module_browsein|escape delimiter='<span class="divider">/</span>'}
          </div>
        </div>

        {$module_content}

        <!-- content ends -->
			</div><!--/#content.span10-->
    </div><!--/fluid-row-->
				
		<hr>

		<div class="modal hide fade" id="myModal">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">x</button>
				<h3>Settings</h3>
			</div>
			<div class="modal-body">
				<p>Here settings can be configured...</p>
			</div>
			<div class="modal-footer">
				<a href="#" class="btn" data-dismiss="modal">Close</a>
				<a href="#" class="btn btn-primary">Save changes</a>
			</div>
		</div>

		<footer>
			<p class="pull-left">&copy; <a href="http://usman.it" target="_blank">Muhammad Usman</a> 2012</p>
			<p class="pull-right">Powered by: <a href="http://usman.it/free-responsive-admin-template">Charisma</a></p>
		</footer>
		
	</div><!--/.fluid-container-->

	<!-- external javascript
	================================================== -->
	<!-- Placed at the end of the document so the pages load faster -->

  <script>
    var language = "{$lang}";
    var
      sys_confirm_group_delete = "{#sys_confirm_group_delete#}",
      sys_confirm_group_activate = "{#sys_confirm_group_activate#}",
      sys_confirm_group_deactivate = "{#sys_confirm_group_deactivate#}",
      sys_confirm_group_install = "{#sys_confirm_group_install#}",
      sys_confirm_group_not_selected = "{#sys_confirm_group_not_selected#}",
      sys_confirm_delete = "{#sys_confirm_delete#}"
    ;
  </script>
	<!-- jQuery -->
	<script src="/themes/admin/js/jquery-1.7.2.min.js"></script>
	<!-- jQuery UI -->
	<script src="/themes/admin/js/jquery-ui-1.8.21.custom.min.js"></script>
	<!-- transition / effect library -->
	
	<!-- alert enhancer library -->
	<script src="/themes/admin/js/bootstrap-alert.js"></script>
	<!-- modal / dialog library -->
	<script src="/themes/admin/js/bootstrap-modal.js"></script>
	<!-- custom dropdown library -->
	<script src="/themes/admin/js/bootstrap-dropdown.js"></script>
	<!-- scrolspy library -->
	<script src="/themes/admin/js/bootstrap-scrollspy.js"></script>
	<!-- library for creating tabs -->
	<script src="/themes/admin/js/bootstrap-tab.js"></script>
	<!-- library for advanced tooltip -->
	<script src="/themes/admin/js/bootstrap-tooltip.js"></script>
	<!-- popover effect library -->
	<script src="/themes/admin/js/bootstrap-popover.js"></script>
	<!-- button enhancer library -->
	<script src="/themes/admin/js/bootstrap-button.js"></script>
	<!-- accordion library (optional, not used in demo) -->
	<script src="/themes/admin/js/bootstrap-collapse.js"></script>
	<!-- carousel slideshow library (optional, not used in demo) -->
	<script src="/themes/admin/js/bootstrap-carousel.js"></script>
	<!-- autocomplete library -->
	<script src="/themes/admin/js/bootstrap-typeahead.js"></script>
	<!-- tour library -->
	<script src="/themes/admin/js/bootstrap-tour.js"></script>
	<!-- library for cookie management -->
	<script src="/themes/admin/js/jquery.cookie.js"></script>
	<!-- calander plugin -->
	<script src='/themes/admin/js/fullcalendar.min.js'></script>
	<!-- data table plugin -->
	<script src='/themes/admin/js/jquery.dataTables.min.js'></script>

	<!-- chart libraries start -->
	<script src="/themes/admin/js/excanvas.js"></script>
	<script src="/themes/admin/js/jquery.flot.min.js"></script>
	<script src="/themes/admin/js/jquery.flot.pie.min.js"></script>
	<script src="/themes/admin/js/jquery.flot.stack.js"></script>
	<script src="/themes/admin/js/jquery.flot.resize.min.js"></script>
	<!-- chart libraries end -->

	<!-- select or dropdown enhancer -->
	<script src="/themes/admin/js/jquery.chosen.min.js"></script>
	<!-- checkbox, radio, and file input styler -->
	<script src="/themes/admin/js/jquery.uniform.min.js"></script>
	<!-- plugin for gallery image view -->
	<script src="/themes/admin/js/jquery.colorbox.min.js"></script>
	<!-- rich text editor library -->
	<script src="/themes/admin/js/jquery.cleditor.min.js"></script>
	<!-- notification plugin -->
	<script src="/themes/admin/js/jquery.noty.js"></script>
	<!-- file manager library -->
	<script src="/themes/admin/js/jquery.elfinder.min.js"></script>
	<!-- star rating plugin -->
	<script src="/themes/admin/js/jquery.raty.min.js"></script>
	<!-- for iOS style toggle switch -->
	<script src="/themes/admin/js/jquery.iphone.toggle.js"></script>
	<!-- autogrowing textarea plugin -->
	<script src="/themes/admin/js/jquery.autogrow-textarea.js"></script>
	<!-- multiple file upload plugin -->
	<script src="/themes/admin/js/jquery.uploadify-3.1.min.js"></script>
	<!-- history.js for cross-browser state change on ajax -->
	<script src="/themes/admin/js/jquery.history.js"></script>
  <!-- bootbox (alert, prompt, confirm) -->
	<script src="/themes/admin/js/bootbox.min.js"></script>
	
  <script src="/public/js/main.js"></script>
  
	<!-- application script for Charisma demo -->
	<script src="/themes/admin/js/charisma.js"></script>
	
  
		
</body>
</html>
