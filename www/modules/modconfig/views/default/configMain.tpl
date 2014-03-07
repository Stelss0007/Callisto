<div class="tabs">  
  <div class="tabs_buttons">  
    <a href="#main_cfg">{#config_main_config#}</a>
    <a href="#mail_cfg">{#config_mail_config#}</a>
    <a href="#seo_cfg">{#config_seo_config#}</a>
  </div>

  <div class="tabs_contents">
    
    <div id="main_cfg">
      <form action='/modconfig/config_update' method="post">
        <input type="hidden" name='referer' value="/modconfig/#main_cfg">
        <table class="outer" cellSpacing="1" cellPadding="4" width="100%">
          <colgroup>
            <col width="25%">
            <col width="75%">
          </colgroup>
          <thead>
            <th colspan="2">
              {#config_main_config#}
            </th>
          </thead>
          <tbody>
          <tr>
            <td class="head">
              {#sys_title#}
            </td>
            <td class="even">
              <input type="text" name="config[site_title]" value="{$site_title}" style="width: 98%;">
            </td>
          </tr>
          <tr>
            <td class="head">
              {#sys_slogan#}
            </td>
            <td class="even">
              <input type="text" name="config[site_slogan]" value="{$site_slogan}" style="width: 98%;">
            </td>
          </tr>
          
          <tr>
            <td class="head">
              {#sys_footer#}
            </td>
            <td class="even">
              <input type="text" name="config[site_footer]" value="{$site_footer}" style="width: 98%;">
            </td>
          </tr>
                    
          <tr>
            <td class="head">
              {#sys_dateformat#}
            </td>
            <td class="even">
              {html_options name="config[site_dateformat]" options=$site_dateformat_list selected=$site_dateformat}
            </td>
          </tr>
          
          <tr>
            <td class="head">
              {#sys_timeformat#}
            </td>
            <td class="even">
              {html_options name="config[site_timeformat" options=$site_timeformat_list selected=$site_timeformat}
            </td>
          </tr>
          
          <tr>
            <td class="head">
              Описание
            </td>
            <td class="even">
              <textarea name='config[site_description]' style="width: 98%;">{$site_description}</textarea>
            </td>
          </tr>
          </tbody>  
        </table>
        <center>    
          <input type="submit" name='submit' value="{#sys_save#}">
        </center>
      </form>
      
    </div>
    
    
    <div id="mail_cfg">
      <h2>{#config_mail_config#}</h2>
    </div>
    
    <div id="seo_cfg">
      <h2>{#config_seo_config#}</h2>
    </div>

  </div>
</div>

{literal}
  <style>
    div.tabs_contents>div {display: none}
    div.items>div:target {display: block}

    div.tabs_contents>div:not(:target) {display: none}
    div.tabs_contents>div:target {display: block}



    /* Tabbed example */
    div.tabs 
      {
      min-height: 7em;		/* No height: can grow if :target doesn't work */
      position: relative;	/* Establish a containing block */
      line-height: 1;     /* Easier to calculate with */
      z-index: 0          /* So that we can put other things behind */
      }			
    div.tabs > div 
      {
      display: inline   /* We want the buttons all on one line */
      }
      
    div.tabs > div.tabs_buttons > a 
      {
      color: black;			/* Looks more like a button than a link */
      background: #CCC;		/* Active tabs are light gray */
      padding: 0.2em 6px;		/* Some breathing space */
      
      border: 0.1em outset #BBB;	/* Make it look like a button */
      border-bottom: 0.1em solid #CCC /* Visually connect tab and tab body */
      }
      
    div.tabs > div:not(:target) > a 
      {
      border-bottom: none;		/* Make the bottom border disappear */
      background: #E3E3E3     /* Inactive tabs are dark gray */
      }
      
    div.tabs > div:target > a,	/* Apply to the targeted item or... */
    :target .tabs_buttons > a,
    .tabs_buttons  a:active
      {		/* ... to the default item */
      border-bottom: 0.1em solid #CCC; /* Visually connect tab and tab body */
      background: #CCC		/* Active tab is light gray */
      }
    div.tabs > div > div 
      {
      background: #F2F2F2;		/* Light gray */
     
      left: 0; top: 4px;		/* The top needs some calculation... */
      bottom: 0; right: 0;		/* Other sides flush with containing block */
      overflow: auto;		/* Scroll bar if needed */
      padding: 1.3em;		/* Looks better */
      border: 0.1em outset #BBB;	/* 3D look */
      position: relative;
      }
      
    div.tabs > div:not(:target) > div 
      { /* Protect CSS1 & CSS2 browsers */
      position: relative; 	/* All these DIVs overlap */
      }
    div.tabs > div:target > div,
    :target .tabs_buttons > div 
      {
      position: absolute;		/* All these DIVs overlap */
      z-index: -1			/* Raise it above the others */
      }

    div.tabs :target 
      {
      outline: none
      }
      
    div.tabs div.tabs_buttons a:active,
    div.tabs div.tabs_buttons a:target
      {		/* ... to the default item */
      border-bottom: 0.1em solid #fff; /* Visually connect tab and tab body */
      background: #CCC		/* Active tab is light gray */
      }

  </style>
{/literal}