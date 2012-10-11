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

<script src='themes/sleekbluey/min-width.js' type='text/javascript'></script>
<script type="text/javascript" src="/scripts/uncompresed_js/ajax/ajax.js"></script>
<script type="text/javascript" src="/scripts/uncompresed_js/bbcode.js"></script>
<script type="text/javascript" src="/scripts/uncompresed_js/comment.js"></script>

{if $module_browsein}
  <title>{mod_getvar|escape modname='SYS_config' name='site_name'}

  {foreach item=item from=$module_browsein}
  &nbsp;::&nbsp;{$item.displayname|escape}
  {/foreach}

  </title>

{else}
  <title>{mod_getvar|escape modname='SYS_config' name='site_name'}&nbsp;::&nbsp;{mod_getvar|escape modname='SYS_config' name='site_slogan'}</title>
{/if}

<link rel="StyleSheet" href="/themes/sleekbluey/style/style.css" type="text/css">

{sysCssList}
{sysJsList}


</head>
<body>
<div id="page">

{* ����� *}
<table border="0" cellpadding="0" cellspacing="0" width="97%" align="center">
  <tr>
    <td width="551" height="147" background="/themes/sleekbluey/images/header_top_l.gif" nowrap>
      <div id="header_title">
  			{mod_getvar modname='SYS_config' name='site_name'} | <span>{mod_getvar|escape modname='SYS_config' name='site_slogan'}</span>
  		</div>
    </td>
    <td height="147" background="/themes/sleekbluey/images/header_top_c.gif" align="right">&nbsp;</td>
    <td width="253" height="147" background="/themes/sleekbluey/images/header_top_r.gif" nowrap>&nbsp;</td>
  </tr>
</table>

<table border="0" cellpadding="0" cellspacing="0" width="97%" align="center">
  <tr>
    <td height="40" background="/themes/sleekbluey/images/header_end_bg_a.gif">
      <div class="top_menu_items" align="center"><a href="/">�������</a></div>
      <div class="top_menu_items" align="center"><a href="/">������</a></div>
      <div class="top_menu_items" align="center"><a href="/">�������</a></div>
      <div class="top_menu_items" align="center"><a href="/">����</a></div>
      <div class="top_menu_items" align="center"><a href="/">������</a></div>
    </td>

    <td width="354" height="40" background="/themes/sleekbluey/images/header_end_bg_b.gif" nowrap>

    <div id="menu_search_box">
      <form method="get" id="searchform" style="display:inline;" action="index.php">
        <script type='text/javascript' src="/scripts/java_scripts/search.js"></script>{*RUS ��� ����� �������� ������ ���������?!*}
        <input type="hidden" name="module" value="search">
        <input type="hidden" name="func" value="view">

			  ������:&nbsp;
        <input value="" name="search_string" maxlength="100">
        &nbsp;
				<input type="image" src="/themes/sleekbluey/images/go.gif" value="Submit" align="top">&nbsp;
			</form>
	  </div>
    </td>
  </tr>
</table>
{* end ����� *}


<table border="0" cellpadding="0" cellspacing="0" width="97%" align="center" bgcolor="#E7EFF8">
  <tr>
    <td width="188" valign="top" background="/themes/sleekbluey/images/body_top_bg_a.gif">
      {* ����� ����� *}
      {if $blocks.left}
        <div class="block">
          <ul>
          {foreach item=block from=$blocks.left}
          <li class="widget_categories">
            <h2>{$block.block_displayname|escape}</h2>
            <ul>
              <li>{$block.block_content}</li>
            </ul>
          </li>
          {/foreach}
          </ul>
        </div>
      {/if}
    {* End ����� �����*}
    </td>


    <td valign="top" id="widget_center">
    {* ����������� �����*}
      {if $module_browsein}
        <h2 class="browsein">{browsein date=$module_browsein|escape}</h2>
      {/if}

      {if !$module_content}<br>{/if}

      {foreach item=block from=$blocks.center}
        <b>{$block.block_displayname|escape}</b><hr size="1">
        {$block.block_content}<br>
      {/foreach}

      {$module_content}


      {foreach item=block from=$blocks.bottom}
        <b>{$block.block_displayname|escape}</b><hr size="1">
        {$block.block_content}<br>
      {/foreach}

    {* End ����������� ����� *}
    </td>






    <td width="188" valign="top" background="/themes/sleekbluey/images/body_top_bg_a.gif">
      {* ������ ����� *}
      {if $blocks.right}
        <div class="block">
          <ul>
          {foreach item=block from=$blocks.right}
          <li class="widget_categories">
            <h2>{$block.block_displayname|escape}</h2>
            <ul>
              <li>{$block.block_content}</li>
            </ul>
          </li>
          {/foreach}
          </ul>
        </div>
      {/if}
    {* End ������ �����*}
    </td>



  </tr>
</table>

{* ��� *}
<table border="0" cellpadding="0" cellspacing="0" width="97%" align="center" bgcolor="#E7EFF8">
  <tr>
    <td width="198" height="45" background="/themes/sleekbluey/images/footer_bg_l.gif" nowrap>
      &nbsp;
    </td>
    <td height="45" background="/themes/sleekbluey/images/footer_bg_c.gif" nowrap align="center">
	    {mod_getvar|escape modname='SYS_config' name='footer'}&nbsp;
    </td>
    <td width="198" height="45" background="/themes/sleekbluey/images/footer_bg_r.gif" nowrap>
      &nbsp;
    </td>
  </tr>
</table>
<br>
{* End ��� *}

</div>

</body>
</html>
{/strip}