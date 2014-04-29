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

    {literal}
      <script language="javascript" type="text/javascript">
        function clearText(field)
        {
          if (field.defaultValue == field.value)
            field.value = '';
          else if (field.value == '')
            field.value = field.defaultValue;
        }
      </script>
    {/literal}
  </head>
  <body>

    <div id="templatemo_wrapper_01">
      <div id="templatemo_wrapper_02">

        <div id="templatemo_header">
          <div id="site_title">
            <a href="#">Free Blog Template</a>
          </div>

          <div id="header_right">

            <a href="#" class="button twitter"></a>
            <a href="#" class="button mail"></a>
            <a href="#" class="button rss"></a>

            <div id="search_box">
              <form action="#" method="get">
                <input type="text" value="Enter a keyword here..." name="q" size="10" id="searchfield" title="searchfield" onfocus="clearText(this)" onblur="clearText(this)" />
                <input type="submit" name="Search" value="" id="searchbutton" title="Search" />
              </form>
            </div>

            <div id="templatemo_menu">
              <ul>
                <li><a href="#" class="current">Popular</a></li>
                <li><a href="#">Archives</a></li>
                <li><a href="#">Gallery</a></li>
                <li><a href="#">About</a></li>
                <li><a href="#" class="last">Contact</a></li>
              </ul>    	
            </div> <!-- end of templatemo_menu -->        
          </div>
        </div> <!-- end of templatemo_header -->


        <div id="templatemo_main">

          <div id="templatemo_content_wrapper">
            <div id="templatemo_content_top"></div>
            <div id="templatemo_content">
              <span class="browsein">
                {browsein date=$module_browsein|escape}
              </span>
                {$module_content}
            </div> <!-- end of content -->
            <div id="templatemo_content_bottom"></div>
          </div> <!-- end of content wrapper -->

          <div id="templatemo_sidebar">

            <div class="sidebar_box_wrapper">
              
            {* Левая часть *}
              {if $blocks.left}
                {foreach item=block from=$blocks.left}
                  <div class="sidebar_box">
                    <div class="sb_title">
                      {$block.block_displayname|escape}
                    </div>
                    <div class="sb_content">
                        {$block.block_content}
                    </div>
                 </div>
                {/foreach}
              {/if}
            {* End левая часть*}
            
            {* Правая часть *}
              {if $blocks.right}
                {foreach item=block from=$blocks.right}
                  <div class="sidebar_box">
                    <div class="sb_title">
                      {$block.block_displayname|escape}
                    </div>
                    <div class="sb_content">
                        {$block.block_content}
                    </div>
                 </div>
                {/foreach}
              {/if}
            {* End правая часть*}
            
            
            <div class="templatemo_cleaner"></div>            

            <div class="templatemo_sidebar_bottom"></div>

            <div class="templatemo_cleaner"></div>

            <div>
              	
            </div>

            <div class="templatemo_cleaner"></div>

            <div align="center">
              <a href="http://validator.w3.org/check?uri=referer"><img style="border:0;width:88px;height:31px" src="http://www.w3.org/Icons/valid-xhtml10" alt="Valid XHTML 1.0 Transitional" width="88" height="31" vspace="8" border="0" /></a> &nbsp;&nbsp;&nbsp;
              <a href="http://jigsaw.w3.org/css-validator/check/referer"><img style="border:0;width:88px;height:31px"  src="http://jigsaw.w3.org/css-validator/images/vcss-blue" alt="Valid CSS!" vspace="8" border="0" /></a>
            </div>

          </div> <!-- end of sidebar -->

          <div class="clear"></div>
        </div> <!-- end of main -->

        <div id="templatemo_footer">
          Copyright © 2048 <a href="#">Your Company Name</a> | 
          Designed by <a href="http://www.templatemo.com" target="_parent">Free CSS Templates</a> | 
          Validate <a href="http://validator.w3.org/check?uri=referer">XHTML</a> &amp; 
          <a href="http://jigsaw.w3.org/css-validator/check/referer">CSS</a>
        </div> <!-- end of footer -->

      </div> <!-- end of wrapper 02 -->
    </div> <!-- end of wrapper 01 -->

  </body>
</html>