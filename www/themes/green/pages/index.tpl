{strip}
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
    <link rel="shortcut icon" href="/public/favicon.png" type="image/png">
    <title>{$site_name}::{$module_page_title}</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="description" content="{if $module_meta_description}{$module_meta_description}{else}{$appConfig.site_seo_description}{/if}"/>
    <meta name="keywords" content="{if $module_meta_keywords}{$module_meta_keywords}{else}{$appConfig.site_seo_keywords}{/if}"/>
    <meta name="robots" content="{if $module_meta_robots}{$module_meta_robots}{else}{$appConfig.site_seo_robots}{/if}"/>
    {appJsLoad modname='kernel' scriptname='jQuery'}
    {appCssOutput cache=0}
    {appJsOutput}
{*    
    {appLessLoad}
    {appLessOutput}
    
    {appSassLoad}
    {appSassOutput}
*} 
  </head>
  <body>
    <div id="main">
      <table class='siteheader'>
        <tr>
          <td>
            <a class='logo-winter' href='/index.php' title=''></a>
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
            <div class='mainmenu' data-block-list-position="top">
              <!-- Block Template --> 
              <div class="app-block-template">
                    <input type="hidden" class="app-block-name" value="">  
                    <div class="app-block-content">
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
          </td>
          <td valign='top'>
            
          </td>
        </tr>
      </table>


      <table class="site">
        <tr>
          <td class="fblock">
            <span class='sbtitle'>Заголовок</span>
            <div data-block-list-position="left">
              <!-- Block Template --> 
              <div class="app-block-template">
                    <span id='mnu_title1' class='usermnutitle-g app-block-name'>
                    </span>
                    <div id='mnu_tblock3' class='usermnublock'>
                      <span class='usermnudelim'></span>
                      <div class="left_content app-block-content">
                      </div>
                      <span class='usermnudelim'></span>
                    </div>
              </div>
              <!-- Block Template End -->    
              {if $blocks.left}
                {foreach item=block from=$blocks.left}
                 {theme_block block=$block} 
                    <span id='mnu_title1' class='usermnutitle-g app-block-name'>
                     {$block.displayname|escape}
                    </span>
                    <div id='mnu_tblock3' class='usermnublock'>
                      <span class='usermnudelim'></span>
                      <div class="left_content app-block-content">
                        {$block.content}
                      </div>
                      <span class='usermnudelim'></span>
                    </div>
                  {/theme_block} 
                {/foreach}
              {/if}
             </div>
          </td>

       <td class="contentmain">
      
            <h2 class="browsein">
              {browsein data=$module_browsein}
            </h2>
  
            {$module_content}
            
            <div data-block-list-position="bottom">
              <!-- Block Template --> 
              <div class="app-block-template">
                    <h3 class="app-block-name"></h3>
                    <div class="app-block-content">
                    </div>
              </div>
              <!-- Block Template End -->  
              {if $blocks.bottom}
                {foreach item=block from=$blocks.bottom}
                  {theme_block block=$block} 
                    <h3 class="app-block-name">{$block.displayname|escape}</h3>
                    <div class="app-block-content">
                        {$block.content}
                    </div>
                  {/theme_block} 
                {/foreach}
              {/if}
            </div>
            
       </td>
      <td class="fblock">

        <span class="sbtitle">1111</span>
        <div class="usermenu" data-block-list-position="right">
          <!-- Block Template --> 
          <div class="app-block-template">
                <span id='mnu_title1' class='usermnutitle-g app-block-name'>
                </span>
                <div id='mnu_tblock3' class='usermnublock'>
                  <span class='usermnudelim'></span>
                  <div class="left_content app-block-content">
                  </div>
                  <span class='usermnudelim'></span>
                </div>
          </div>
          <!-- Block Template End -->  
          {if $blocks.right}
            {foreach item=block from=$blocks.right}
              {theme_block block=$block} 
                <span id='mnu_title1' class='usermnutitle-g app-block-name'>
                 {$block.displayname|escape}
                </span>
                <div id='mnu_tblock3' class='usermnublock'>
                 <span class='usermnudelim'></span>
                 <div class="left_content app-block-content">
                   {$block.content}
                 </div>
                 <span class='usermnudelim'></span>
               </div>
              {/theme_block} 
            {/foreach}
          {/if}

          
        </div>
        <span class="sbtitle">Привет</span>
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
          CMS "Calisto"<br />
          Beta v0.0.12
        </div>
        
        <div class="footermenu">
          <a href="http://vkontakte.ru/id12188100">VK</a>
        </div>

      </div>
</div>

</body>
</html>
{/strip}
