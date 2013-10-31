{strip}
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
    <title>{$module_page_title}</title>
    <meta http-equiv="Content-Type" content="text/html; charset=windows-1251" />
    <meta name="description" content="{$module_meta_description}"/>
    <meta name="keywords" lang="ru" content="{$module_meta_keywords}"/>
    {appJsLoad modname='kernel' scriptname='jQuery'}
    {appCssOutput}
    {appJsOutput}
    <link rel="stylesheet" href="/public/js/jsValidate/jsValidate.css" type="text/css" />
    <script type="text/javascript" src="/public/js/jQuery/jQuery.js"></script>
    <script type="text/javascript" src="/public/js/jsValidate/jsValidate.js"></script>
  </head>
  <body>
    <div id="main">

      <table class='siteheader'>
        <tr>
          <td>
            <a class='logo-winter' href='/index.php' title='SEOSPRINT - Всё для максимальной раскрутки!'></a>
          </td>
          <td align='right' valign='bottom' nowrap='nowrap'>
            
          </td>
          <td align='left' valign='bottom' nowrap='nowrap' width='150'>
           
          </td>
          <td align='right' valign='bottom' width='90' nowrap='nowrap'>
            
          </td>
        </tr>
        <tr>
          <td colspan='3'>
            <ul class='mainmenu'>
              {*<li>
                <a href='' class='active'>Главная</a>
              </li>
              <li>
                <a href='/index.php?module=article&type=user&func=article_view&id=17'>О портале</a>
              </li>
              <li>
                <a href=''>Технология сервиса</a>
              </li>
              <li>
                <a href=''>Партнерам</a>
              </li>
              <li>
                <a href=''>Статьи</a>
              </li>
              <li>
                <a href=''>Выплаты</a>
              </li>
              <li>
                <a href=''>Форум</a>
              </li>
              <li>
                <a href=''>Помощь</a>
              </li>*}
              {* Верхняя часть *}
              {if $blocks.top}
                {foreach item=block from=$blocks.top}

                  <li>
                    {$block.block_content}
                  </li>

                {/foreach}
              {/if}
              {* End верхняя часть*}
            </ul>
          </td>
          <td valign='top'>
            
          </td>
        </tr>
      </table>


      <table class="site">
        <tr>
          <td class="fblock">
            <span class='sbtitle'>Меню пользователя</span>
            {* Левая часть *}
              {if $blocks.left}
                {foreach item=block from=$blocks.left}
                 <span id='mnu_title1' class='usermnutitle-g'>
                  {$block.block_displayname|escape}
                 </span>
                 <div id='mnu_tblock3' class='usermnublock'>
                  <span class='usermnudelim'></span>
                  <div class="left_content">
                    {$block.block_content}
                  </div>
                  <span class='usermnudelim'></span>
                </div>
                {/foreach}
              {/if}
            {* End левая часть*}
            </div>

            <span class='sbtitle'>Мой баланс</span>
            <div class='balance-block' title='Баланс пользователя'>0.00 <span class='text12'>руб</span>
            </div>
          </td>

       <td class="contentmain">
      
            <h2 class="browsein">
              {browsein date=$module_browsein|escape}
            </h2>
  
            {$module_content}
            
       </td>
      <td class="fblock">

        <span class="sbtitle">Выбор заданий</span>
        <div class="usermenu">
          <span id="tsk_mnu1" class='usermnutitle-g'>По параметрам</span>
          <div id="tsk_mnu_block1" class="usermnublock" >
            <span class='usermnuline-act'>
              <b>Все задания</b>
            </span>
            <span class='usermnuline'>
              Только новые задания
            </span>
            <span class='usermnuline'>
              Многоразовые задания
            </span>
            <span class='usermnuline'>
              Избранное
            </span>
            <span class='usermnuline'>
              Над которыми работаю
            </span>
            <span class='usermnuline'>
              Находятся на проверке
            </span>
            <span class='usermnuline'>
              Оплачены
            </span>
            <span class='usermnuline'>
              Отклонены
            </span>
          </div>

          {* Левая часть *}
          {if $blocks.right}
            {foreach item=block from=$blocks.right}
             <span id='mnu_title1' class='usermnutitle-g'>
              {$block.block_displayname|escape}
             </span>
             <div id='mnu_tblock3' class='usermnublock'>
              <span class='usermnudelim'></span>
              <div class="left_content">
                {$block.block_content}
              </div>
              <span class='usermnudelim'></span>
            </div>
            {/foreach}
          {/if}
        {* End левая часть*}
          
        </div>
        <span class="sbtitle">Наши здесь</span>
        <table class="soc-table">
          <tr>
            <td><a class="soc-twitter" target='_blank' href="http://twitter.com/#!/seo_sprint"></a></td>
            <td><a class="soc-vk" target='_blank' href="http://vkontakte.ru/company_seosprint"></a></td>
            <td><a class="soc-fbook" target='_blank' href="http://www.facebook.com/pages/SEO-sprint/185661371507529"></a></td>
            <td><a class="soc-tube" target='_blank' href="http://www.youtube.com/user/gisinfo"></a></td>

          </tr>
        </table>
      </td>
     </tr>
   </table>
   <div class="empty"></div>
</div>
<div id="footer">
      <div id="wrap">
        <div class="copyrate">
          Сайт под умправлением CMS "Calisto"<br />
          Beta v0.0.12
        </div>
        
        <div class="footermenu">
          <a href="http://vkontakte.ru/id12188100">Персональные даные</a>
        </div>

      </div>
</div>

</body>
</html>
{/strip}
