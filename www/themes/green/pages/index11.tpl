<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
    <title>{$module_page_title}</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8;charset=utf-8" />
    <meta name="description" content="{$module_meta_description}"/>
    <meta name="keywords" lang="ru" content="{$module_meta_keywords}"/>

    <link rel="stylesheet" href="themes/green/css/style.css" type="text/css" />
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
            <a class='logo-winter' href='/index.php' title='SEOSPRINT - �� ��� ������������ ���������!'></a>
          </td>
          <td align='right' valign='bottom' nowrap='nowrap'>
            <div id='cartvisible'></div>
          </td>
          <td align='left' valign='bottom' nowrap='nowrap' width='150'>
            <div class='nameblock'>
              <span class='nbtitle'>����� ����������</span>
              ���: <b>������</b>
              <br />
              ID: 580312,
              ������: <a style='color: #C08B06' href='/addphone.php'>������������ �������</a>
            </div>
          </td>
          <td align='right' valign='bottom' width='90' nowrap='nowrap'>
            <a href='/userinfo.php?user=580312' style='border: none;'>
              <img class='avatar' src='/images/def-avatar.jpg' border='0' width='60' height='60' alt='avatar' />
            </a>
          </td>
        </tr>
        <tr>
          <td colspan='3'>
            <ul class='mainmenu'>
              <li>
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
              </li>
            </ul>
          </td>
          <td valign='top'>
            <a class='logout' href='' title='�����'></a>
          </td>
        </tr>
      </table>


      <table class="site">
        <tr>
          <td class="fblock">
            <span class='sbtitle'>���� ������������</span>
            <div class='usermenu'>
              <span id='mnu_title1' class='usermnutitle-g'>
                ������������
              </span>
              <div id='mnu_tblock1' class='usermnublock'>
                <span class='usermnudelim'></span>
                <a class='usermnuline' href="?page=main">�������</a>
                <a class='usermnuline' href="index.php?module=user&func=login">����</a>
                <a class='usermnuline' href="index.php?module=test">Test</a>
                <a class='usermnuline' href="index.php?module=article&type=admin&func=article_new">������� ������</a>
                <a class='usermnuline' href="index.php?module=article&type=user&func=article_list">������</a>
                <a class='usermnuline' href="index.php?module=groups&type=admin">������ �������������</a>
                <a class='usermnuline' href="index.php?module=user&type=admin&func=user_list">������������</a>
                <a class='usermnuline-act' href="index.php?module=blocks&type=admin">�����</a>
                <span class='usermnudelim'></span>
              </div>

              <span id='mnu_title3' class='usermnutitle-b'>������ �������</span>
              <div id='mnu_tblock3' class='usermnublock'>
                <span class='usermnudelim'></span>
                <a class='usermnuline' href='/advmanager.php'>���������� ��������
                  <span class='usermnuline-none'></span></a>
                <a class='usermnuline' href='/mails.php'>
                  ��� �����<span class='usermnuline-mail'>0</span>
                </a>
                <a class='usermnuline' href='/refs.php'>��� ��������
                  <span class='usermnuline-ref'>0</span>
                </a>
                <a class='usermnuline' href='/promo.php'>���������� ���������</a>
                <a class='usermnuline' href='/refwelcome.php'>����������� � ����������</a>
                <a class='usermnuline' href='/stat.php'>��� ����������</a>
                <a class='usermnuline' href='/history.php'>������� ��������</a>
                <a class='usermnuline' href='/profile.php'>��� ������ ������</a>
                <a class='usermnuline' href='/withdraw.php'>
                  <b>�������� ������</b></a>
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

            <span class='sbtitle'>��� ������</span>
            <div class='balance-block' title='������ ������������'>0.00 <span class='text12'>���</span>
            </div>
          </td>

          <td class="contentmain">
          
            <h2 class="browsein">
              {browsein date=$module_browsein|escape}
            </h2>
  
            {$module_content}
 
        <div id='rollbaner'>
            <a href='/gobaner.php?link=2254' target='_blank' title='http://rusip.net/klepa-reg.html'>
            <img src='/advbaners/1104181239389.gif' width='468' height='60' alt='' /></a>
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

          SEO sprint 2011<br />
          All rights reserved
        </div>
        <a href='http://www.megastock.ru/' target='_blank' style='margin-left: 20px; border: none;'>
          <img src='/images/88x31_wm_blue_on_white_ru.png' alt='www.megastock.ru' />
        </a>
        <a href='https://passport.webmoney.ru/asp/certview.asp?wmid=293160119471' target='_blank' style='margin-left: 2px; border: none;'>
            <img src='/images/88x31_wm_v_blue_on_white_ru.png' alt='����� ��������� �������� ������ WM �������������� 293160119471' />
        </a>

        <div class="footermenu">
          <a href="/policy.php">������ � ������� ������</a>&nbsp;&sdot;&nbsp;
          <a href="/codex.php">�����������</a>&nbsp;&sdot;&nbsp;

          <a href="/black-links.php">׸���� ������</a>&nbsp;&sdot;&nbsp;
          <a href="/userinfo.php">������������</a>&nbsp;&sdot;&nbsp;
          <a href="/forum/index.php">�����</a>&nbsp;&sdot;&nbsp;
          <a href="/contact.php">��������</a>
          <br />
          ����� �������������:
          <font color='#114C5B'>380 272</font>
          &hellip; ����� �� 24 ����:
          <font color='#114C5B'>2116</font>
          &hellip;
          ����� ���������:
          <font color='#114C5B'>6 554 694.83</font> ���
        </div>

      </div>
</div>
</body>
</html>

