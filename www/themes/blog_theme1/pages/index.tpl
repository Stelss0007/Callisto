<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
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

              <div class="content_box">
                <h2>Ancient Blog Template for everyone</h2>

                <a href="http://www.templatemo.com" target="_parent"><img class="image_wrapper" src="images/templatemo_image_03.jpg" alt="free templates" /></a>
                <p> Nunc aliquam, dolor vitae sollicitudin lacinia, nibh orci sagittis diam, dignissim sodales dui erat nec eros. Fusce quis enim. Aenean eleifend, neque hendrerit elementum sodales, odio erat sagittis quam, sed tempor orci magna vitae tellus. Proin dui mauris, tempor eget, pulvinar sed, pretium sit amet, dui.</p>
              </div>

              <div class="content_box">
                <h2>Featured Posts</h2>
                <a href="http://www.templatemo.com/page/1" target="_parent"><img class="image_wrapper image_fl" src="images/templatemo_image_01.jpg" alt="image" /></a>
                <h5><a href="#">Quisque in diam a justo condimentum</a></h5>
                <p>Cum sociis natoque penatibus et magnis dis parturient mont nascetur ridiculus mus. Curabitur quis velit quis tortor tincidu nt aliquetus leo velit, convallis id, ultrices.</p>
                <a class="more float_r" href="#"></a>

                <div class="clear h30"></div>

                <a href="http://www.templatemo.com/page/2" target="_parent"><img class="image_wrapper image_fl" src="images/templatemo_image_02.jpg" alt="image" /></a>
                <h5><a href="#">Quisque in diam a justo condimentum</a></h5>
                <p>Cum sociis natoque penatibus et magnis dis parturient mont nascetur ridiculus mus. Curabitur quis velit quis tortor tincidu nt aliquetus leo velit, convallis id, ultrices.</p>
                <a class="more float_r" href="#"></a>
                <div class="clear"></div>
              </div>	

              <div class="content_box last_box">
                <h2>Popular Posts</h2>
                <p>Quisque in diam a justo condimentum molestie. Vivamus a velit. Cum sociis natoque penatibus et magni dis parturient montes, nascetur ridiculus musa velit. Cum sociis natoque penatibus et magnis dis parturit montes, nascetur ridiculus mus. Curabitur quis velit quis tortor tincidunt aliquet.</p>
                <ul class="tmo_list">
                  <li class="col_3"><a href="#">Condimentum molestie</a></li>
                  <li class="col_3"><a href="#">Vivamus a velit</a></li>
                  <li class="col_3"><a href="#">Cum sociis natoque</a></li>
                  <li class="col_3"><a href="#">Senatibus et magnis</a></li>
                  <li class="col_3"><a href="#">Adis parturient montes</a></li>
                  <li class="col_3"><a href="#">Rnascetur ridiculumus</a></li>
                  <li class="col_3"><a href="#">Curabitur quis velit</a></li>
                  <li class="col_3"><a href="#">Quis tortor tincidunt</a></li>
                  <li class="col_3"><a href="#">Vivamus leo velitllid</a></li>
                </ul>
              </div>


            </div> <!-- end of content -->
            <div id="templatemo_content_bottom"></div>
          </div> <!-- end of content wrapper -->

          <div id="templatemo_sidebar">

            <div class="sidebar_box_wrapper">

              <div class="sidebar_box">
                <div class="sb_title"><img src="images/categories.png" alt="Categories" /></div>
                <div class="sb_content">
                  <ul class="tmo_list">
                    <li><a href="#">Curabitur quis velit quis tortor</a></li>
                    <li><a href="#">Sed ut perspiciatis unde omnis</a></li>
                    <li><a href="#">Fnatus error sit voluptatem</a></li>
                    <li><a href="#">Cum sociis natoque penatibus</a></li>
                    <li><a href="#">Rotam rem aperiame</a></li>
                    <li><a href="#">Veritatis quasi architecto</a></li>
                  </ul>	
                </div>
              </div>

              <div class="sidebar_box">
                <div class="sb_title"><img src="images/recent_blog_entries.png" alt="Recent Blog Entries" /></div>
                <div class="sb_content">
                  <ul class="tmo_list">
                    <li><a href="http://www.webdesignmo.com/blog" target="_parent">Web Design Blog</a></li>
                    <li><a href="http://www.flashmo.com" target="_parent">Flash Templates</a></li>
                    <li><a href="http://www.templatemo.com" target="_parent">HTML CSS Layouts</a></li>
                    <li><a href="#">Proin luctus placerat arcu</a></li>
                    <li><a href="#">Achitecto beatae</a></li>
                    <li><a href="#">Fvitae dicsunt explicabo</a></li>
                  </ul>	
                </div>
              </div>
            </div>

            <div class="templatemo_cleaner"></div>            

            <div class="templatemo_sidebar_bottom"></div>

            <div class="templatemo_cleaner"></div>

            <div>
              <a href="#" class="ads_125"><img src="images/ads_125.jpg" alt="125x125 banner 1" /></a>
              <a href="#" class="ads_125"><img src="images/ads_125.jpg" alt="125x125 banner 2" /></a>
              <a href="#" class="ads_125"><img src="images/ads_125.jpg" alt="125x125 banner 3" /></a>
              <a href="#" class="ads_125"><img src="images/ads_125.jpg" alt="125x125 banner 4" /></a>			
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
          Copyright � 2048 <a href="#">Your Company Name</a> | 
          Designed by <a href="http://www.templatemo.com" target="_parent">Free CSS Templates</a> | 
          Validate <a href="http://validator.w3.org/check?uri=referer">XHTML</a> &amp; 
          <a href="http://jigsaw.w3.org/css-validator/check/referer">CSS</a>
        </div> <!-- end of footer -->

      </div> <!-- end of wrapper 02 -->
    </div> <!-- end of wrapper 01 -->

  </body>
</html>