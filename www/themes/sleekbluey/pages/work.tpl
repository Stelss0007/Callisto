<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
{strip}
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1251">
<meta http-equiv="Content-Language" content="ru">
<meta http-equiv="Content-Style-Type" content="text/css">
<meta name="robots" content="{mod_getvar modname='SYS_config' name='meta_robots'}">
<meta name="keywords" content="{mod_getvar|escape modname='SYS_config' name='meta_keywords'}">
<meta name="description" content="{mod_getvar|escape modname='SYS_config' name='meta_description'}">
<meta name="rating" content="{mod_getvar modname='SYS_config' name='meta_rating'}">
<meta name="author" content="{mod_getvar|escape modname='SYS_config' name='meta_author'}">
<meta name="copyright" content="{mod_getvar|escape modname='SYS_config' name='meta_copyright'}">
<meta name="generator" content="WebCore http://www.webcore.ru">

{if $module_browsein}
  <title>{mod_getvar|escape modname='SYS_config' name='site_name'}

  {foreach item=item from=$module_browsein}
  &nbsp;::&nbsp;{$item.displayname|escape}
  {/foreach}

  </title>

{else}
  <title>{mod_getvar|escape modname='SYS_config' name='site_name'}&nbsp;::&nbsp;{mod_getvar|escape modname='SYS_config' name='site_slogan'}</title>
{/if}

<link rel="StyleSheet" href="/themes/sleekbluey/style/style1.css" type="text/css">

</head>
<center>
<div id="page">

{* Header *}
<div id="header">
	<div id="header_top">
		<div id="header_title">
			{mod_getvar modname='SYS_config' name='site_name'} | <span>{mod_getvar|escape modname='SYS_config' name='site_slogan'}</span>
		</div>
	</div>

	<div id="header_end">
		<div id="menu">
			<div id="menu_pad">

				<div id="menu_items">
					&nbsp;&nbsp;<div><a href="/">Главная</a></div>&nbsp;&nbsp;<div><a href="/">Фильмы</a></div>&nbsp;&nbsp;<div><a href="/">Сериалы</a></div>&nbsp;&nbsp;<div><a href="/">Музыка</a></div>&nbsp;&nbsp;<div><a href="/">Игры</a></div>&nbsp;&nbsp;<div><a href="/">Поиск</a></div>&nbsp;&nbsp;<div><a href="/">О нас</a></div>&nbsp;&nbsp;
				</div>
				<div id="menu_search_box">
					<form method="get" id="searchform" style="display:inline;" action="http://www.skinpress.com/demo/">
					Искать:&nbsp;
					<input type="text" class="s" value="" name="s" id="s" />&nbsp;
					<input type="image" src="/themes/sleekbluey/images/go.gif" value="Submit" class="sub" align="top" />
					</form>
				</div>

			</div>
		</div>
	</div>

</div>
{* End header *}


{* Start body *}
<div id="blog">
<div id="blog_top">

  {* центральная часть*}
  <div id="blog_left">
    <div class="post" id="post-2">
      <div class="entry">
      {if $module_browsein}
        <h2 class="browsein">{browsein date=$module_browsein|escape}</h2>
      {/if}
        <!-- center blocks -->
          {foreach item=block from=$blocks.center}
                        <b>{$block.block_displayname|escape}</b><hr size="1">
                        {$block.block_content}<br>
          {/foreach}
        <!-- center blocks end -->

    {$module_content}

      <!-- bottom blocks -->
        {foreach item=block from=$blocks.bottom}
                <b>{$block.block_displayname|escape}</b><hr size="1">
                {$block.block_content}<br>
        {/foreach}
      <!-- bottom blocks end -->

      </div>
    </div>
  </div>
  {* End центральная часть *}

  {* Правая часть *}
<div id="blog_right">
  <div id="sidebar">

    {if $blocks.right}
    <ul>
    <!-- right blocks -->
      {foreach item=block from=$blocks.right}
      <li class="widget_categories">
        <h2>{$block.block_displayname|escape}</h2>
        <ul>
          <li>{$block.block_content}</li>
        </ul>
      </li>
      {/foreach}
    <!-- right blocks end -->
    </ul>
    {/if}

  </div>
</div>
  {* End правая часть*}




</div>
</div>
{* End body *}

{* Start footer *}
<div id="footer">
  {mod_getvar|escape modname='SYS_config' name='footer'}
</div>
{* End footer *}


</div>
</center>
</html>
{/strip}