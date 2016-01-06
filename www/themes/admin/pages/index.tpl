<!DOCTYPE html>
{strip}
<html lang="en" style="min-height: 100%">
    <head>
        <link rel="shortcut icon" href="/public/favicon.png" type="image/png" />
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">

        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <meta name="description" content="Callisto Admin" />
        <meta name="author" content="" />

        <title>Callisto | Dashboard</title>
        {literal}
          <style>
            .pace {
                -webkit-pointer-events: none;
                pointer-events: none;

                -webkit-user-select: none;
                -moz-user-select: none;
                user-select: none;
              }

              .pace-inactive {
                display: none;
              }

              .pace .pace-progress {
                background: #29d;
                position: fixed;
                z-index: 2000;
                top: 0;
                right: 100%;
                width: 100%;
                height: 4px;
              }
          </style>
        {/literal}
        
        <script src="/themes/admin/js/pace.min.js"></script> 
        
        <link href="/themes/admin/css/jquery-ui-1.8.21.custom.css" rel="stylesheet">
        <link rel="stylesheet" href="/themes/admin/css/font-icons/entypo/css/entypo.css">
        <link rel="stylesheet" href="/themes/admin/css/bootstrap.css">
        <link rel="stylesheet" href="/themes/admin/css/neon-core.css">
        <link href='/themes/admin/css/elfinder.min.css' rel='stylesheet'>
        <link href='/themes/admin/css/elfinder.theme.css' rel='stylesheet'>
        <link rel="stylesheet" href="/themes/admin/js/bootstrap-select/css/bootstrap-select.min.css">
        <link rel="stylesheet" href="/themes/admin/js/bootstrap-switch/css/bootstrap-switch.min.css">
        <link rel="stylesheet" href="/themes/admin/css/custom.css">
        
        <script src="/themes/admin/js/jquery-1.11.0.min.js"></script>
        {appJsOutput}
        <!--[if lt IE 9]><script src="/themes/admin/js/ie8-responsive-file-warning.js"></script><![endif]-->

        <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!--[if lt IE 9]>
                <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
                <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->
        {appJsOutput}
    </head>
    
    <body class="page-body" style="min-height: 100%">
        <div class="page-container body-hide_ {if $smarty.cookies['sidebar-collapsed'] eq 1}sidebar-collapsed{/if}" style="min-height: 100%;"><!-- add class "sidebar-collapsed" to close sidebar by default, "chat-visible" to make chat appear always -->	
            <div class="sidebar-menu" style="min-height: 100%;">
                <header class="logo-env">
                    <!-- logo -->
                    <div class="logo">
                        <a href="/admin/" style="font-size: 29px; text-shadow: 0px 0px 3px #ccc; font-family: cursive;">
                           Callisto
                        </a>
                    </div>
                    <!-- logo collapse icon -->
                    <div class="sidebar-collapse">
                        <a href="#" class="sidebar-collapse-icon "><!-- add class "with-animation" if you want sidebar to have animation during expanding/collapsing transition -->
                            <i class="icon-menu"></i>
                        </a>
                    </div>
                    <!-- open/close menu icon (do not remove if you want to enable menu on mobile devices) -->
                    <div class="sidebar-mobile-menu visible-xs">
                        <a href="#" class="with-animation"><!-- add class "with-animation" to support animation -->
                            <i class="icon-menu"></i>
                        </a>
                    </div>

                </header>

                <ul id="main-menu" class="">
                    <!-- add class "multiple-expanded" to allow multiple submenus to open -->
                    <!-- class "auto-inherit-active-class" will automatically add "active" class for parent elements who are marked already with class "active" -->
                    <!-- Search Bar -->
                    <li id="search">
                        <form method="get" action="">
                            <input type="text" name="q" class="search-input" placeholder="{#theme_menu_search_something#}"/>
                            <button type="submit">
                                <i class="icon-search"></i>
                            </button>
                        </form>
                    </li>
                    
                    <li><a class="ajax-link" href="/admin/main"><i class="icon-home"></i><span class="hidden-tablet"> {#theme_menu_dashboard#}</span></a></li>
                    <li><a class="ajax-link" href="/admin/configuration/main"><i class="icon-cog"></i><span class="hidden-tablet"> {#theme_menu_configuration#}</span></a></li>
                    <li><a class="ajax-link" href="/admin/groups"><i class="icon-users"></i><span class="hidden-tablet"> {#theme_menu_groups#}</span></a></li>
                    <li><a class="ajax-link" href="/admin/users/users_list"><i class="icon-user"></i><span class="hidden-tablet"> {#theme_menu_users#}</span></a></li>
                    <li><a class="ajax-link" href="/admin/permissions"><i class="icon-key"></i><span class="hidden-tablet"> {#theme_menu_permissions#}</span></a></li>
                    <li><a class="ajax-link" href="/admin/menu/menu_list/0"><i class="icon-list"></i><span class="hidden-tablet"> {#theme_menu_menu#}</span></a></li>
                    <li><a class="ajax-link" href="/admin/modules"><i class="icon-database"></i><span class="hidden-tablet"> {#theme_menu_modules#}</span></a></li>
                    <li><a class="ajax-link" href="/admin/blocks"><i class="icon-layout"></i><span class="hidden-tablet"> {#theme_menu_blocks#}</span></a></li>
                    <li><a class="ajax-link" href="/admin/theme"><i class="icon-brush"></i><span class="hidden-tablet"> {#theme_menu_themes#}</span></a></li>
                    <li><a class="ajax-link" href="/admin/files"><i class="icon-folder"></i><span class="hidden-tablet"> {#theme_menu_files#}</span></a></li>
                    <li><a class="ajax-link" href="/admin/articles"><i class="icon-doc-text"></i><span class="hidden-tablet"> {#theme_menu_articles#}</span></a></li>
                    <li><a class="ajax-link" href="/admin/help/icons"><i class="icon-info"></i><span class="hidden-tablet"> {#theme_menu_icons#}</span></a></li>


                    <li><a class="ajax-link" href="/admin/users/login"><i class="icon-logout"></i><span class="hidden-tablet"> {#theme_menu_logout#}</span></a></li>
                </ul>

            </div>	
            <div class="main-content" style="min-height: 100%;">
                {if $blocks.top}
                    {foreach item=block from=$blocks.top}
                      <div>
                          {$block.content}
                      </div>
                    {/foreach}
                {/if}
                <div>
                    <div class="breadcrumb">
                        <i class="icon-home"></i>
                        {browsein data=$module_browsein delimiter='<span class="divider">/</span>'}
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-sm-12">
                        {$module_content}
                    </div>
                </div>
                
                <!-- Footer -->
                <footer class="main">
                    &copy; {$smarty.now|date_format:"%Y"} <strong>Callisto CMS</strong> powered by <a href="http://stelssoft.com" target="_blank">StelsSoft</a>
                </footer>	

            </div>


 
        <script>
             var language = "{$lang}";
             var
                     sys_confirm_group_delete = "{#sys_confirm_group_delete#}",
                     sys_confirm_group_activate = "11{#sys_confirm_group_activate#}",
                     sys_confirm_group_deactivate = "111{#sys_confirm_group_deactivate#}",
                     sys_confirm_group_install = "{#sys_confirm_group_install#}",
                     sys_confirm_group_not_selected = "{#sys_confirm_group_not_selected#}",
                     sys_confirm_delete = "{#sys_confirm_delete#}",
                     sys_confirm_group_delete = "{#sys_confirm_group_delete#}"
                     ;
             var date_format = "{$config.date_format_js}",
                     time_format = "{$config.time_format_js}"
                     ;
         </script>
     {*     
        <link rel="stylesheet" href="/themes/admin/js/jvectormap/jquery-jvectormap-1.2.2.css">
        <link rel="stylesheet" href="/themes/admin/js/rickshaw/rickshaw.min.css">
      *}
        <!-- Bottom Scripts -->
    
    <script src="/themes/admin/js/gsap/main-gsap.js"></script>
    <script src="/themes/admin/js/joinable.js"></script>
    
{*
<script src="/themes/admin/js/jquery-ui/js/jquery-ui-1.10.3.minimal.min.js"></script>
*}
      <script src="/themes/admin/js/bootstrap.js"></script>
      <script src="/themes/admin/js/resizeable.js"></script>
{*      
<script src="/themes/admin/js/joinable.js"></script>
*}

        <script src="/themes/admin/js/neon-api.js"></script>
        <script src="/themes/admin/js/neon-custom.js"></script>

        <script src="/themes/admin/js/neon-demo.js"></script>
        
        <script src="/themes/admin/js/main.js"></script>
        <script src="/themes/admin/js/jquery.elfinder.min.js"></script>
        <script src="/themes/admin/js/bootbox.min.js"></script>
        <script src="/themes/admin/js/bootstrap-select/js/bootstrap-select.min.js"></script>
        <script src="/themes/admin/js/bootstrap-switch/js/bootstrap-switch.min.js"></script>
        
        <div class="clearfix clear"></div>
        <a href="#" class="scrollup"></a>
    </body>
</html>
{/strip}