{strip}
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
    <title>{$module_page_title}</title>
    <meta http-equiv="Content-Type" content="text/html; charset=windows-1251;" />
    <meta name="description" content="{$module_meta_description}"/>
    <meta name="keywords" lang="ru" content="{$module_meta_keywords}"/>
    <link rel="stylesheet" href="themes/green_test/css/style.css" type="text/css" />
    <link rel="stylesheet" href="/scripts/js/jsValidate/jsValidate.css" type="text/css" />
    <script type="text/javascript" src="/scripts/js/jQuery/jQuery.js"></script>
    <script type="text/javascript" src="/scripts/js/jsValidate/jsValidate.js"></script>
    <script type="text/javascript" src="/scripts/js/jQuery/testTask.js"></script>
  </head>
  <body>
    <div id="main">
      <table class='siteheader'>
        <tr>
          <td>
            <a class='logo-winter' href='/index.php' title='Callisto - �������� �������'></a>
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
          </td>
          <td valign='top'>
          </td>
        </tr>
      </table>
      <table class="site">
        <tr>
          <td class="fblock">
            <span class='sbtitle'>���� ������������</span>
            <div class='usermenu'>
              <span id='mnu_title1' class='usermnutitle-g'>
                ����������
              </span>
              <div id='mnu_tblock1' class='usermnublock'>
                <span class='usermnudelim'></span>
                <a class='usermnuline' href="/">�������</a>
                <a class='usermnuline' href="index.php?module=user&func=login">����</a>
                <a class='usermnuline' href="index.php?module=test">Test</a>
                <a class='usermnuline' href="index.php?module=article&type=admin&func=article_new">������� ������</a>
                <a class='usermnuline' href="index.php?module=article&type=user&func=article_list">������</a>
                <a class='usermnuline' href="index.php?module=groups&type=admin">������ �������������</a>
                <a class='usermnuline' href="index.php?module=user&type=admin&func=user_list">������������</a>
                <a class='usermnuline-act' href="index.php?module=blocks&type=admin">�����</a>
                <span class='usermnudelim'></span>
              </div>

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
          </td>
       <td class="contentmain">
          <h2 class="browsein">
            {browsein date=$module_browsein|escape}
          </h2>
          {$module_content}

          <div class="usermenu">
          {* ������ ����� *}
          {if $blocks.bottom}
            {foreach item=block from=$blocks.bottom}
            <div {if $block.block_css_class}class='{$block.block_css_class}'{/if}>
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
             </div>
            {/foreach}
          {/if}
        {* End ������ �����*}
        </div>
       </td>
      <td class="fblock">
        <span class="sbtitle">����� �������</span>
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
      </td>
     </tr>
   </table>
   <div class="empty"></div>
</div>
<div id="footer">
  <div id="wrap">
    <div class="copyrate">
      ���� ��� ������������ CMS "Calisto"<br />
      Beta v0.0.1
    </div>

    <div class="footermenu">
      <a href="http://vkontakte.ru/id12188100">������������ �����</a>
    </div>
  </div>
</div>
</body>
</html>
{/strip}
