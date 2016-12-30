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
    <link rel="shortcut icon" href="/public/favicon.png" type="image/png">
    <title>{$site_name}::{$module_page_title}</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="description" content="{if $module_meta_description}{$module_meta_description}{else}{$appConfig.site_seo_description}{/if}"/>
    <meta name="keywords" content="{if $module_meta_keywords}{$module_meta_keywords}{else}{$appConfig.site_seo_keywords}{/if}"/>
    <meta name="robots" content="{if $module_meta_robots}{$module_meta_robots}{else}{$appConfig.site_seo_robots}{/if}"/>
    
    {appJsLoad modname='kernel' scriptname='jQuery'}
    {appCssOutput cache=0}
    {appJsOutput}

    <link rel="shortcut icon" href="img/favicon.ico">
		
</head>

<body>
	<!-- Navigation -->
    <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
        <div class="container">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="#">CallistoCMS</a>
            </div>
            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav">
                    <li>
                        <a href="#">About</a>
                    </li>
                    <li>
                        <a href="#">Services</a>
                    </li>
                    <li>
                        <a href="#">Contact</a>
                    </li>
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container -->
    </nav>

    <!-- Page Content -->
    <div class="container">
        <div class="row">
            <!-- Blog Entries Column -->
            <div class="col-md-8">
                <div data-block-list-position="top">
                    <!-- Block Template --> 
                    <div class="app-block-template">
                        <div class="well">
                            <input type="hidden" class="app-block-name" value="{$block.displayname|escape}">  
                            <div class="app-block-content"></div>
                        </div>
                    </div>
                    <!-- Block Template End --> 
                    {if $blocks.top}
                        {foreach item=block from=$blocks.top}
                            {theme_block block=$block} 
                                <input type="hidden" class="app-block-name" value="{$block.displayname|escape}">  
                                <div class="app-block-content">
                                  {$block.content}
                                </div>
                            {/theme_block}
                        {/foreach}
                    {/if}
                </div>

            
                {if $module_browsein}
                    <div class="well">
                        <div class="browsein">
                          {browsein data=$module_browsein}
                        </div>
                    </div>
                {/if}
  
                {$module_content}
            
                <div data-block-list-position="bottom">
                    <!-- Block Template --> 
                    <div class="app-block-template">
                        <div class="well">
                            <h4 class="app-block-name"></h4>
                            <div class="app-block-content"></div>
                        </div>
                    </div>
                    <!-- Block Template End --> 
                    {if $blocks.bottom}
                        {foreach item=block from=$blocks.bottom}
                          {theme_block block=$block} 
                                <div class="well">
                                    <h4 class="app-block-name">{$block.displayname|escape}</h4>
                                    <div class="app-block-content">
                                        {$block.content}
                                    </div>
                                </div>
                          {/theme_block} 
                        {/foreach}
                    {/if}
                </div>
            </div>

            <!-- Blog Sidebar Widgets Column -->
            <div class="col-md-4">
                <div data-block-list-position="left">
                    <!-- Block Template --> 
                    <div class="app-block-template">
                        <div class="well">
                            <h4 class="app-block-name"></h4>
                            <div class="app-block-content"></div>
                        </div>
                    </div>
                    <!-- Block Template End -->  
                    {if $blocks.left}
                        {foreach item=block from=$blocks.left}
                          {theme_block block=$block} 
                                <div class="well">
                                    <h4 class="app-block-name">{$block.displayname|escape}</h4>
                                    <div class="app-block-content">
                                        {$block.content}
                                    </div>
                                </div>
                          {/theme_block} 
                        {/foreach}
                    {/if}
                </div>
                
                <div data-block-list-position="right">
                    <!-- Block Template --> 
                    <div class="app-block-template">
                        <div class="well">
                            <h4 class="app-block-name"></h4>
                            <div class="app-block-content"></div>
                        </div>
                    </div>
                    <!-- Block Template End --> 
                    {if $blocks.right}
                        {foreach item=block from=$blocks.right}
                          {theme_block block=$block} 
                                <div class="well">
                                    <h4 class="app-block-name">{$block.displayname|escape}</h4>
                                    <div class="app-block-content">
                                        {$block.content}
                                    </div>
                                </div>
                          {/theme_block} 
                        {/foreach}
                    {/if}
                </div>
            </div>
        </div>
        <!-- /.row -->
        <hr>
        <!-- Footer -->
        <footer>
            <div class="row">
                <div class="col-lg-12">
                    <p>Copyright &copy; CMS "Calisto" Beta v0.0.12</p>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
        </footer>
    </div>
    <!-- /.container -->
</body>
</html>

