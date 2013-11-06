{strip}
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
    <title>{$module_page_title}</title>
    <meta http-equiv="Content-Type" content="text/html; charset=windows-1251" />
    <meta name="description" content="{$module_meta_description}"/>
    <meta name="keywords" lang="ru" content="{$module_meta_keywords}"/>
    {appJsLoad modname='kernel' scriptname='jQuery'}
    {appCssOutput cache=0}
    {appJsOutput}
  </head>
  <body>
    <div id="main">
      <table class='siteheader'>
        <tr>
          <td>
            <a class='logo-winter' href='/index.php' title='SEOSPRINT - �� ��� ������������ ���������!'></a>
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
                <a href='' class='active'>�������</a>
              </li>
              <li>
                <a href='/index.php?module=article&type=user&func=article_view&id=17'>� �������</a>
              </li>
              <li>
                <a href=''>���������� �������</a>
              </li>
              <li>
                <a href=''>���������</a>
              </li>
              <li>
                <a href=''>������</a>
              </li>
              <li>
                <a href=''>�������</a>
              </li>
              <li>
                <a href=''>�����</a>
              </li>
              <li>
                <a href=''>������</a>
              </li>*}
              {* ������� ����� *}
              {if $blocks.top}
                {foreach item=block from=$blocks.top}

                  <li>
                    {$block.block_content}
                  </li>

                {/foreach}
              {/if}
              {* End ������� �����*}
            </ul>
          </td>
          <td valign='top'>
            
          </td>
        </tr>
      </table>


      <table class="site">
        <tr>
          <td class="fblock">
            <span class='sbtitle'>���� ������������</span>
            {* ����� ����� *}
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
            {* End ����� �����*}
            </div>

            <span class='sbtitle'>��� ������</span>
            <div class='balance-block' title='������ ������������'>0.00 <span class='text12'>���</span>
            </div>
          </td>

       <td class="contentmain">
      
            <h2 class="browsein">
              {browsein date=$module_browsein|escape}
            </h2>
  
            {$module_content}
            
       </td>
      <td class="fblock">

        <span class="sbtitle">������ �����</span>
        <div class="usermenu">
          {* ����� ����� *}
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
        {* End ����� �����*}
          
        </div>
        <span class="sbtitle">���� �����</span>
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
          ���� ��� ������������ CMS "Calisto"<br />
          Beta v0.0.12
        </div>
        
        <div class="footermenu">
          <a href="http://vkontakte.ru/id12188100">������������ �����</a>
        </div>

      </div>
</div>

</body>
</html>
{/strip}
