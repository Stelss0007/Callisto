
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
<title>{$module_page_title}</title>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1251">
<META HTTP-EQUIV="Pragma" content="no-cache">
<META HTTP-EQUIV="Expires" Content="Mon, 28 Mar 1999 00:00:01 GMT">
<meta name="Document-state" content ="Dynamic">
<meta name="description" content="{$module_meta_description}">
<meta name="keywords" lang="ru" content="{$module_meta_keywords}">
<meta name=Robots content="all">

<link href="themes/test/css/style.css" rel="stylesheet" type="text/css">

</head>

<body>

<div id="wrap">
<div id="conteiner">
<table width="100%"  border="0" cellspacing="0" cellpadding="0">
  <tr valign="top">
    <td width="235" style="background:url(themes/test/images/lbg.gif); background-position:right; background-repeat:repeat-y;">
    
        <div class="company_name">Web-хостинговые услуги</div><div class="company_name_shadow">Web-хостинговые услуги</div>
        <img src="themes/test/images/p2.jpg" alt="image">
        <div class="lmenu">
            <a href="?page=main">Главная</a> 
            <a href="index.php?module=user&func=login">Вход</a>
            <a href="index.php?module=test">Test</a>
            <a href="index.php?module=article&type=admin&func=article_new">Создать статью</a>
            <a href="index.php?module=article&type=user&func=article_list">Статьи</a>
            <a href="index.php?module=groups&type=admin">Группы пользователей</a>
            <a href="index.php?module=user&type=admin&func=user_list">Пользователи</a>
            <a href="index.php?module=blocks&type=admin">Блоки</a>


        </div>
      {* Левая часть *}
      {if $blocks.left}
        <div class="lblock">
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
    {* End левая часть*}
          
      
    </td>
    <td ><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td><img src="themes/test/images/p1.jpg" alt="" width="715" height="267"></td>
      </tr>
      <tr>
        <td class="body_txt">
          {browsein date=$module_browsein|escape}
       </td>
      </tr>
      <tr>
        <td class="body_txt">
          {$module_content}
          <br>
       </td>
      </tr>
    </table></td>
  </tr>
</table></div></div>
    <div id="footer">
        <div class="bottom_menu">
            <a href="#">Главная</a> 
            <a href="#">Про нас</a> 
            <a href="#">Наши клиенты</a>
            <a href="#">Площадки</a>
            <a href="#">Наши цены</a>
            <a href="#">Контакты</a>
        </div>
        <div class="bottom_addr">&copy; 2008 Company Name. Все права защищены.</div>
    </div>

</body>
</html>

