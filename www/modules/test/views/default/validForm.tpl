<div class="error" style="color: red; font-weight: bold;">
{$sysMessage}
</div>

<form method="post" action='/index.php?module=test&action=valid'>
  <table>
    <col style="text-align: right;">
    <col>
    <tr>
      <td>
        *First Name: 
      </td>
      <td>
        <input type="text" name="firstname[]" value="{$firstname.0}" maxlength="80" />
      </td>
    </tr>
    <tr>
      <td>
        *First Name2:
      </td>
      <td>
        <input type="text" name="firstname[]" value="{$firstname.1}" maxlength="80" />
      </td>
    </tr>
    <tr>
      <td>
        *Last Name:
      </td>
      <td>
        <input type="text" name="lastname" value="{$lastname}" maxlength="80" />
      </td>
    </tr>
    <tr>
      <td>
        Mobile: 
      </td>
      <td>
        <input type="text" name="mobile" value="{$mobile}" />
      </td>
    </tr>
    <tr>
      <td>
        *Email: 
      </td>
      <td>
        <input type="text" name="email" value="{$email}" />
      </td>
    </tr>
    <tr>
      <td>
        Comment: 
      </td>
      <td>
        <textarea name="comment">{$comment}</textarea>
      </td>
    </tr>
  </table>

  <p><input type="checkbox" name="t-and-c" id="t-and-c" value="true" /> </p>

  <p><strong>* Required</strong></p>

  <p><input type="submit" value="Send" /></p>

</form>
      

{literal}


<div id="fb-root"></div>
<script>

var location_lang = 'fr_FR'
  
// /////////////  Twiter  /////////////////////////
!function(d,s,id)
  {
  var js,fjs=d.getElementsByTagName(s)[0];
  if(!d.getElementById(id))
    {
    js=d.createElement(s);
    js.id=id;
    js.src="//platform.twitter.com/widgets.js?lang=ru";
    fjs.parentNode.insertBefore(js,fjs);
    }
  }
(document,"script","twitter-wjs");
  
// /////////////    FB   //////////////////////////
(function(d, s, id) 
  {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/"+location_lang+"/all.js#xfbml=1";
  fjs.parentNode.insertBefore(js, fjs);
  }
(document, 'script', 'facebook-jssdk'));
  
// ////////////  Google  ////////////////////////// 
  window.___gcfg = {lang: location_lang};
    
(function() 
  {
    var po = document.createElement('script'); 
    po.type = 'text/javascript'; po.async = true;
    po.src = 'https://apis.google.com/js/plusone.js';
    var s = document.getElementsByTagName('script')[0]; 
    s.parentNode.insertBefore(po, s); 
  })();
    
    
// //////// LinkedIn ////////////////////////////////////
(function(d, s, id) 
  {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//platform.linkedin.com/in.js";
  fjs.parentNode.insertBefore(js, fjs);
  }
(document, 'script', 'linkedin'));
  
 
</script>

<style>.twitter-share-button{width: 96px !important;}#plusone{width: 95px;}.fb_edge_widget_with_comment{top: -5px !important;}</style>
 


<div style="width: 550px; height: 20px;">
  <span class="fb-like"  data-send="false" data-layout="button_count" data-width="450" data-show-faces="false"></span>
  <span class="fb-send"  data-send="false" data-layout="button_count" data-width="450" data-show-faces="false"></span>
  <a href="https://twitter.com/share?a=1&lang=fr" class="twitter-share-button" style="width: 96px;" data-lang='fr' lang='fr'></a>
  <script type="IN/Share" data-counter="right" data-lang='fr'></script>
  <g:plusone size="medium"></g:plusone>
  
</div>

{/literal}