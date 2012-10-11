<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1251">
<meta http-equiv="Content-Language" content="ru">
<meta http-equiv="Content-Style-Type" content="text/css">
<meta name="robots" content="{mod_getvar modname='SYS_config' name='meta_robots'}">
{if $module_meta_keywords}
<meta name="keywords" content="{$module_meta_keywords}">
{else}
<meta name="keywords" content="{mod_getvar|escape modname='SYS_config' name='meta_keywords'}">
{/if}
{if $module_meta_description}
<meta name="description" content="{$module_meta_description}">
{else}
<meta name="description" content="{mod_getvar|escape modname='SYS_config' name='meta_description'}">
{/if}
<meta name="rating" content="{mod_getvar modname='SYS_config' name='meta_rating'}">
<meta name="author" content="{mod_getvar|escape modname='SYS_config' name='meta_author'}">
<meta name="copyright" content="{mod_getvar|escape modname='SYS_config' name='meta_copyright'}">


{if $module_browsein}
  <title>{mod_getvar|escape modname='SYS_config' name='site_name'}

  {foreach item=item from=$module_browsein}
  &nbsp;::&nbsp;{$item.displayname|escape}
  {/foreach}

  </title>

{else}
  <title>{mod_getvar|escape modname='SYS_config' name='site_name'}&nbsp;::&nbsp;{mod_getvar|escape modname='SYS_config' name='site_slogan'}</title>
{/if}

<link rel="StyleSheet" href="/themes/primepress/style/style.css" type="text/css">

{sysCssList}
{sysJsList}

{literal}
<script type="text/javascript">  
$(function() {  
$('a[rel*=lightbox]').lightBox();  
$('a.lightbox').lightBox();  
 });  
</script>  
{/literal}

</head>
<body  class="custom">
<div id="page"  class="hfeed content-540px">

{* шапка *}
<div id="header">
<div id="branding">
<div class="homelink"><a href="/">{mod_getvar modname='SYS_config' name='site_name'}</a></div>
<p class="description">{mod_getvar|escape modname='SYS_config' name='site_slogan'}</p>
</div>

{foreach item=block from=$blocks.top}
{if $block.id==1}
{$block.block_content}
{/if}
{/foreach}

</div>
 {* end шапка *}


<div id="container">
<div id="rotating">
 {include file='themes/primepress/pages/header.tpl'}
</div>

<div id="primary" class="looped">

{if $module_browsein}
<h1 class="entry-title">{browsein date=$module_browsein|escape}</h1>
{/if}

{if $blocks.top}
{foreach item=block from=$blocks.top}
{if $block.id!=1}
<div class="entry-content">

{$block.block_content}
</div>
{/if}
{/foreach}
{/if}

{if $module_content}
{$module_content}
{/if}

{if $blocks.center}
{foreach item=block from=$blocks.center}
<div class="entry-content">
<h1 class="entry-title">{$block.block_displayname}</h2>
{$block.block_content}
</div>
{/foreach}
{/if}

</div>

<div id="secondary">
{if $blocks.right}


	<div id="sidebar-wide" class="sidebar">
	<ul class="xoxo sidebar-items">
	
	{foreach item=block from=$blocks.right name=rightblocks}
	{if $smarty.foreach.rightblocks.iteration==1}
	<div id="pp-sidebars" class="clearfix">
	{else}
	<div id="pp-sidebars-last" class="clearfix">
	{/if}
	<li id="pp-recent-posts" class="widget">	    
        <h2 class="widgettitle">{$block.block_displayname|escape}</h2>
        <div>{$block.block_content}</div>
	</div>
	{/foreach}
	</ul>
</div>
{/if}
</div>
        

<div class="clear"></div> 
{foreach item=block from=$blocks.bottom}
<div>   
        {$block.block_content}
</div>
{/foreach}

  

 
<div id="footer">
		<p class="left">&#169; 2010 <strong>{mod_getvar modname='SYS_config' name='site_name'}</strong></p>
		<p class="right">Создание сайта - <strong><a href="http://webcore.ru/" target="_blank">Webcore</a></strong></p>

	</div> 

</div>
<div class="clear"></div>	
</div><!--#page-->


</body>
</html>
