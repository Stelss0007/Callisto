<!DOCTYPE html>
<html lang="en" style="min-height: 100%">
    <head>
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
    
    <body class="page-body " style="min-height: 100%">
        <div class="page-container body-hide" style="min-height: 100%;"><!-- add class "sidebar-collapsed" to close sidebar by default, "chat-visible" to make chat appear always -->	
            <div class="sidebar-menu" style="min-height: 100%;">
                <header class="logo-env">
                    <!-- logo -->
                    <div class="logo">
                        <a href="/admin/">
                           Callisto
                        </a>
                    </div>
                    <!-- logo collapse icon -->
                    <div class="sidebar-collapse">
                        <a href="#" class="sidebar-collapse-icon with-animation"><!-- add class "with-animation" if you want sidebar to have animation during expanding/collapsing transition -->
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
                    <li><a class="ajax-link" href="/admin/configuration"><i class="icon-cog"></i><span class="hidden-tablet"> {#theme_menu_configuration#}</span></a></li>
                    <li><a class="ajax-link" href="/admin/groups"><i class="icon-users"></i><span class="hidden-tablet"> {#theme_menu_groups#}</span></a></li>
                    <li><a class="ajax-link" href="/admin/users/users_list"><i class="icon-user"></i><span class="hidden-tablet"> {#theme_menu_users#}</span></a></li>
                    <li><a class="ajax-link" href="/admin/permissions"><i class="icon-key"></i><span class="hidden-tablet"> {#theme_menu_permissions#}</span></a></li>
                    <li><a class="ajax-link" href="/admin/menu"><i class="icon-list"></i><span class="hidden-tablet"> {#theme_menu_menu#}</span></a></li>
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

                <div class="row">
                    <!-- Profile Info and Notifications -->
                    <div class="col-md-6 col-sm-8 clearfix">
                        <ul class="user-info pull-left pull-none-xsm">
                            <!-- Profile Info -->
                            <li class="profile-info dropdown"><!-- add class "pull-right" if you want to place this from right -->
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                    <img src="/themes/admin/images/thumb-1@2x.png" alt="" class="img-circle" width="44" />
                                    Ruslan Ruslan
                                </a>
                                <ul class="dropdown-menu">
                                    <!-- Reverse Caret -->
                                    <li class="caret"></li>
                                    <!-- Profile sub-links -->
                                    <li>
                                        <a href="extra-timeline.html">
                                            <i class="icon-user"></i>
                                            Edit Profile
                                        </a>
                                    </li>
                                    <li>
                                        <a href="mailbox.html">
                                            <i class="icon-mail"></i>
                                            Inbox
                                        </a>
                                    </li>
                                    <li>
                                        <a href="extra-calendar.html">
                                            <i class="icon-calendar"></i>
                                            Calendar
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#">
                                            <i class="icon-clipboard"></i>
                                            Tasks
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        </ul>

                        <ul class="user-info pull-left pull-right-xs pull-none-xsm">
                            <!-- Raw Notifications -->
                            <li class="notifications dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
                                    <i class="icon-attention"></i>
                                    <span class="badge badge-info">6</span>
                                </a>
                                <ul class="dropdown-menu">
                                    <li class="top">
                                        <p class="small">
                                            <a href="#" class="pull-right">Mark all Read</a>
                                            You have <strong>3</strong> new notifications.
                                        </p>
                                    </li>
                                    <li>
                                        <ul class="dropdown-menu-list scroller">
                                            <li class="unread notification-success">
                                                <a href="#">
                                                    <i class="icon-user-add pull-right"></i>

                                                    <span class="line">
                                                        <strong>New user registered</strong>
                                                    </span>

                                                    <span class="line small">
                                                        30 seconds ago
                                                    </span>
                                                </a>
                                            </li>
                                            <li class="unread notification-secondary">
                                                <a href="#">
                                                    <i class="icon-heart pull-right"></i>

                                                    <span class="line">
                                                        <strong>Someone special liked this</strong>
                                                    </span>

                                                    <span class="line small">
                                                        2 minutes ago
                                                    </span>
                                                </a>
                                            </li>
                                            <li class="notification-primary">
                                                <a href="#">
                                                    <i class="icon-user pull-right"></i>

                                                    <span class="line">
                                                        <strong>Privacy settings have been changed</strong>
                                                    </span>

                                                    <span class="line small">
                                                        3 hours ago
                                                    </span>
                                                </a>
                                            </li>
                                            <li class="notification-danger">
                                                <a href="#">
                                                    <i class="icon-cancel-circled pull-right"></i>

                                                    <span class="line">
                                                        John cancelled the event
                                                    </span>

                                                    <span class="line small">
                                                        9 hours ago
                                                    </span>
                                                </a>
                                            </li>
                                            <li class="notification-info">
                                                <a href="#">
                                                    <i class="icon-info pull-right"></i>

                                                    <span class="line">
                                                        The server is status is stable
                                                    </span>

                                                    <span class="line small">
                                                        yesterday at 10:30am
                                                    </span>
                                                </a>
                                            </li>
                                            <li class="notification-warning">
                                                <a href="#">
                                                    <i class="icon-rss pull-right"></i>

                                                    <span class="line">
                                                        New comments waiting approval
                                                    </span>

                                                    <span class="line small">
                                                        last week
                                                    </span>
                                                </a>
                                            </li>
                                        </ul>
                                    </li>
                                    <li class="external">
                                        <a href="#">View all notifications</a>
                                    </li>				</ul>
                            </li>

                            <!-- Message Notifications -->
                            <li class="notifications dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
                                    <i class="icon-mail"></i>
                                    <span class="badge badge-secondary">10</span>
                                </a>
                                <ul class="dropdown-menu">
                                    <li>
                                        <ul class="dropdown-menu-list scroller">
                                            <li class="active">
                                                <a href="#">
                                                    <span class="image pull-right">
                                                        <img src="/themes/admin/images/thumb-1.png" alt="" class="img-circle" />
                                                    </span>

                                                    <span class="line">
                                                        <strong>Luc Chartier</strong>
                                                        - yesterday
                                                    </span>

                                                    <span class="line desc small">
                                                        This ain’t our first item, it is the best of the rest.
                                                    </span>
                                                </a>
                                            </li>

                                            <li class="active">
                                                <a href="#">
                                                    <span class="image pull-right">
                                                        <img src="/themes/admin/images/thumb-2.png" alt="" class="img-circle" />
                                                    </span>

                                                    <span class="line">
                                                        <strong>Salma Nyberg</strong>
                                                        - 2 days ago
                                                    </span>

                                                    <span class="line desc small">
                                                        Oh he decisively impression attachment friendship so if everything. 
                                                    </span>
                                                </a>
                                            </li>

                                            <li>
                                                <a href="#">
                                                    <span class="image pull-right">
                                                        <img src="/themes/admin/images/thumb-3.png" alt="" class="img-circle" />
                                                    </span>

                                                    <span class="line">
                                                        Hayden Cartwright
                                                        - a week ago
                                                    </span>

                                                    <span class="line desc small">
                                                        Whose her enjoy chief new young. Felicity if ye required likewise so doubtful.
                                                    </span>
                                                </a>
                                            </li>

                                            <li>
                                                <a href="#">
                                                    <span class="image pull-right">
                                                        <img src="/themes/admin/images/thumb-4.png" alt="" class="img-circle" />
                                                    </span>

                                                    <span class="line">
                                                        Sandra Eberhardt
                                                        - 16 days ago
                                                    </span>

                                                    <span class="line desc small">
                                                        On so attention necessary at by provision otherwise existence direction.
                                                    </span>
                                                </a>
                                            </li>
                                        </ul>
                                    </li>

                                    <li class="external">
                                        <a href="mailbox.html">All Messages</a>
                                    </li>				</ul>

                            </li>

                            <!-- Task Notifications -->
                            <li class="notifications dropdown">

                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
                                    <i class="icon-list"></i>
                                    <span class="badge badge-warning">1</span>
                                </a>

                                <ul class="dropdown-menu">
                                    <li class="top">
                                        <p>You have 6 pending tasks</p>
                                    </li>

                                    <li>
                                        <ul class="dropdown-menu-list scroller">
                                            <li>
                                                <a href="#">
                                                    <span class="task">
                                                        <span class="desc">Procurement</span>
                                                        <span class="percent">27%</span>
                                                    </span>

                                                    <span class="progress">
                                                        <span style="width: 27%;" class="progress-bar progress-bar-success">
                                                            <span class="sr-only">27% Complete</span>
                                                        </span>
                                                    </span>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="#">
                                                    <span class="task">
                                                        <span class="desc">App Development</span>
                                                        <span class="percent">83%</span>
                                                    </span>

                                                    <span class="progress progress-striped">
                                                        <span style="width: 83%;" class="progress-bar progress-bar-danger">
                                                            <span class="sr-only">83% Complete</span>
                                                        </span>
                                                    </span>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="#">
                                                    <span class="task">
                                                        <span class="desc">HTML Slicing</span>
                                                        <span class="percent">91%</span>
                                                    </span>

                                                    <span class="progress">
                                                        <span style="width: 91%;" class="progress-bar progress-bar-success">
                                                            <span class="sr-only">91% Complete</span>
                                                        </span>
                                                    </span>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="#">
                                                    <span class="task">
                                                        <span class="desc">Database Repair</span>
                                                        <span class="percent">12%</span>
                                                    </span>

                                                    <span class="progress progress-striped">
                                                        <span style="width: 12%;" class="progress-bar progress-bar-warning">
                                                            <span class="sr-only">12% Complete</span>
                                                        </span>
                                                    </span>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="#">
                                                    <span class="task">
                                                        <span class="desc">Backup Create Progress</span>
                                                        <span class="percent">54%</span>
                                                    </span>

                                                    <span class="progress progress-striped">
                                                        <span style="width: 54%;" class="progress-bar progress-bar-info">
                                                            <span class="sr-only">54% Complete</span>
                                                        </span>
                                                    </span>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="#">
                                                    <span class="task">
                                                        <span class="desc">Upgrade Progress</span>
                                                        <span class="percent">17%</span>
                                                    </span>

                                                    <span class="progress progress-striped">
                                                        <span style="width: 17%;" class="progress-bar progress-bar-important">
                                                            <span class="sr-only">17% Complete</span>
                                                        </span>
                                                    </span>
                                                </a>
                                            </li>
                                        </ul>
                                    </li>

                                    <li class="external">
                                        <a href="#">See all tasks</a>
                                    </li>				</ul>
                            </li>

                        </ul>

                    </div>

                    <!-- Raw Links -->
                    <div class="col-md-6 col-sm-4 clearfix hidden-xs">
                        <ul class="list-inline links-list pull-right">
                            <!-- Language Selector -->			
                            <li class="dropdown language-selector">
                                {#theme_language_list#}: &nbsp;
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" data-close-others="true">
                                    <img src="/themes/admin/images/flag-uk.png" />
                                </a>
                                <ul class="dropdown-menu lang-menu pull-right">
                                    <li class="active">
                                        <a href="#">
                                            <img src="/themes/admin/images/flag-uk.png" />
                                            <span>English</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#">
                                            <img src="/themes/admin/images/flag-ru.png" />
                                            <span>Russian</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#">
                                            <img src="/themes/admin/images/flag-ua.png" />
                                            <span>Ukrainian</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#">
                                            <img src="/themes/admin/images/flag-de.png" />
                                            <span>Deutsch</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#">
                                            <img src="/themes/admin/images/flag-fr.png" />
                                            <span>François</span>
                                        </a>
                                    </li>
                                   
                                    <li>
                                        <a href="#">
                                            <img src="/themes/admin/images/flag-es.png" />
                                            <span>Español</span>
                                        </a>
                                    </li>
                                </ul>

                            </li>

                            <li class="sep"></li>
                            <li>
                                <a href="/admin/users/logout">
                                    Log Out <i class="icon-logout right"></i>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
                
                <hr />
                
                <div>
                    <div class="breadcrumb">
                        <i class="icon-home"></i>
                        {browsein date=$module_browsein|escape delimiter='<span class="divider">/</span>'}
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
                     sys_confirm_group_activate = "{#sys_confirm_group_activate#}",
                     sys_confirm_group_deactivate = "{#sys_confirm_group_deactivate#}",
                     sys_confirm_group_install = "{#sys_confirm_group_install#}",
                     sys_confirm_group_not_selected = "{#sys_confirm_group_not_selected#}",
                     sys_confirm_delete = "{#sys_confirm_delete#}"
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
        <div class="clearfix clear"></div>
        <a href="#" class="scrollup"></a>
    </body>
</html>
