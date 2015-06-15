{* да нет *}
{array name='yes_no'}
{array_append name='yes_no' key='1' value=Да}
{array_append name='yes_no' key='0' value=Нет}

{array name='site_list_lenght_list'}
{array_append name='site_list_lenght_list' key='5' value=5}
{array_append name='site_list_lenght_list' key='10' value=10}
{array_append name='site_list_lenght_list' key='15' value=15}
{array_append name='site_list_lenght_list' key='20' value=20}
{array_append name='site_list_lenght_list' key='25' value=25}
{array_append name='site_list_lenght_list' key='30' value=30}
{array_append name='site_list_lenght_list' key='50' value=50}
{array_append name='site_list_lenght_list' key='100' value=100}

{array name='site_seo_robots_list'}
{array_append name='site_seo_robots_list' key='index, follow' value='index, follow'}
{array_append name='site_seo_robots_list' key='noindex, follow' value='noindex, follow'}
{array_append name='site_seo_robots_list' key='index, nofollow' value='index, nofollow'}
{array_append name='site_seo_robots_list' key='noindex, nofollow' value='noindex, nofollow'}


{array name='site_email_type'}
{array_append name='site_email_type' key='phpmail' value='PHP Mail'}
{array_append name='site_email_type' key='sendmail' value='Sendmail'}
{array_append name='site_email_type' key='smtp' value='SMTP'}


{array name='site_smtp_sec'}
{array_append name='site_smtp_sec' key='' value='None'}
{array_append name='site_smtp_sec' key='ssl' value='SSL'}
{array_append name='site_smtp_sec' key='tsl' value='TSL'}

<div class="accordion" id="accordion">
  
  <div class="panel panel-default">
    <div class="panel-heading">
      <h4 class="panel-title">
        <a data-toggle="collapse" data-parent="#accordion" href="#group-global">
          {#config_group_all#}
        </a>
      </h4>
    </div>
    <div id="group-global" class="panel-collapse collapse in">
      <div class="panel-body">
        
        <div class="control-group">
          <label for="date01" class="control-label">{#site_name#}</label>
          <div class="controls">
            <input type="text" name="modconfig[main][site_name]" value="{$modconfig.main.site_name}" class="form-control" style="width: 98%;">
          </div>
        </div>
          
        <div class="control-group">
          <label for="date01" class="control-label">{#site_slogan#}</label>
          <div class="controls">
            <input type="text" name="modconfig[main][site_slogan]" value="{$modconfig.main.site_slogan}" class="form-control"  style="width: 98%;">
          </div>
        </div>
          
        <div class="control-group">
          <label for="date01" class="control-label">{#site_description#}</label>
          <div class="controls">
            <textarea style="width: 98%;" name="modconfig[main][site_description]" class="form-control" >{$modconfig.main.site_description}</textarea>
          </div>
        </div>
          
        <div class="control-group">
          <label for="date01" class="control-label">{#site_footer#}</label>
          <div class="controls">
            <input type="text" name="modconfig[main][site_footer]" value="{$modconfig.main.site_footer}" class="form-control"  style="width: 98%;">
          </div>
        </div>

        <div class="control-group">
          <label for="date01" class="control-label">{#site_dateformat#}</label>
          <div class="controls">
             <select data-rel="chosen_" name="modconfig[main][site_dateformat]" class="form-control" >
              {html_options options=$site_dateformat_list selected=$modconfig.main.site_dateformat}
             </select>
          </div>
        </div>
          
        <div class="control-group">
          <label for="date01" class="control-label">{#site_timeformat#}</label>
          <div class="controls">
            <select data-rel="chosen_" name="modconfig[main][site_timeformat]" class="form-control" >
              {html_options options=$site_timeformat_list selected=$modconfig.main.site_timeformat}
            </select>
          </div>
        </div>
          
        <div class="control-group">
          <label for="date01" class="control-label">{#site_offline#}</label>
          <div class="controls">
              <div class="btn-group btn-group-yesno" data-toggle-name="modconfig[main][site_offline]" data-toggle="buttons-radio">
                {html_radios name="modconfig[main][site_offline]" options=$yes_no selected=$modconfig.main.site_offline separator=" "}
              </div>
          </div>
        </div>
              
        <div class="control-group">
          <label for="date01" class="control-label">{#site_offline_message#}</label>
          <div class="controls">
            <textarea style="width: 98%;" name="modconfig[main][site_offline_message]" class="form-control" >{$modconfig.main.site_offline_message|default:'Сайт закрыт на техническое обслуживание.<br /> Пожалуйста, зайдите позже.'}</textarea>
          </div>
        </div>
              
        <div class="control-group">
          <label for="date01" class="control-label">{#site_list_lenght#}</label>
          <div class="controls">
            <select data-rel="chosen_" name="modconfig[main][site_list_lenght]" class="form-control" >
              {html_options options=$site_list_lenght_list selected=$modconfig.main.site_list_lenght}
            </select>
          </div>
        </div>
          
      </div>
    </div>
  </div>
  
  
  <div class="panel panel-default">
    <div class="panel-heading">
      <h4 class="panel-title">
        <a data-toggle="collapse" data-parent="#accordion" href="#group-seo">
          {#config_group_seo#}
        </a>
      </h4>
    </div>
    <div id="group-seo" class="panel-collapse collapse">
      <div class="panel-body">
        <div class="panel-body">
          
          <div class="control-group">
            <label for="date01" class="control-label">{#site_seo_description#}</label>
            <div class="controls">
              <textarea style="width: 98%;" name="modconfig[main][site_seo_description]" class="form-control" >{$modconfig.main.site_seo_description}</textarea>
            </div>
          </div>
            
          <div class="control-group">
            <label for="date01" class="control-label">{#site_seo_keywords#}</label>
            <div class="controls">
              <textarea style="width: 98%;" name="modconfig[main][site_seo_keywords]" class="form-control" >{$modconfig.main.site_seo_keywords}</textarea>
            </div>
          </div>
            
          <div class="control-group">
            <label for="date01" class="control-label">{#site_seo_robots#}</label>
            <div class="controls">
             <select data-rel="chosen_" name="modconfig[main][site_seo_robots]" class="form-control" >
              {html_options options=$site_seo_robots_list selected=$modconfig.main.site_seo_robots}
             </select>
            </div>
          </div>
            
      </div>
      </div>
    </div>
  </div>
  
  
  <div class="panel panel-default">
    <div class="panel-heading">
      <h4 class="panel-title">
        <a data-toggle="collapse" data-parent="#accordion" href="#group-mail">
          {#config_group_mail#}
        </a>
      </h4>
    </div>
    <div id="group-mail" class="panel-collapse collapse">
      <div class="panel-body">
        <div class="control-group">
          <label for="date01" class="control-label">{#mail_type#}</label>
          <div class="controls">
            <select data-rel="chosen_" name="modconfig[main][site_email_type]" class="form-control" >
              {html_options options=$site_email_type selected=$modconfig.main.site_email_type}
            </select>
          </div>
        </div>
            
        <div class="control-group">
          <label for="date01" class="control-label">{#mail_site_from#}</label>
          <div class="controls">
            <input type="text" name="modconfig[main][site_email_from]" value="{$modconfig.main.site_email_from}" class="form-control" style="width: 98%;">
          </div>
        </div>
          
        <div class="control-group">
          <label for="date01" class="control-label">{#mail_site_sender#}</label>
          <div class="controls">
            <input type="text" name="modconfig[main][site_email_sender]" value="{$modconfig.main.site_email_sender}" class="form-control" style="width: 98%;">
          </div>
        </div>
          
        <div class="control-group">
          <label for="date01" class="control-label">{#mail_smtp_server#}</label>
          <div class="controls">
            <input type="text" name="modconfig[main][site_email_smtp_server]" value="{$modconfig.main.site_email_smtp_server}" class="form-control" style="width: 98%;">
          </div>
        </div>
          
        <div class="control-group">
          <label for="date01" class="control-label">{#mail_type#}</label>
          <div class="controls">
            <select data-rel="chosen_" name="modconfig[main][site_smtp_sec]" class="form-control" >
              {html_options options=$site_smtp_sec selected=$modconfig.main.site_smtp_sec}
            </select>
          </div>
        </div>
          
        <div class="control-group">
          <label for="date01" class="control-label">{#mail_smtp_port#}</label>
          <div class="controls">
            <input type="text" name="modconfig[main][site_email_smtp_port]" value="{$modconfig.main.site_email_smtp_port}" class="form-control" style="width: 98%;">
          </div>
        </div>
          
        <div class="control-group">
          <label for="date01" class="control-label">{#mail_smtp_user#}</label>
          <div class="controls">
            <input type="text" name="modconfig[main][site_email_smtp_user]" value="{$modconfig.main.site_email_smtp_user}" class="form-control" style="width: 98%;">
          </div>
        </div>
          
        <div class="control-group">
          <label for="date01" class="control-label">{#mail_smtp_password#}</label>
          <div class="controls">
            <input type="text" name="modconfig[main][site_email_smtp_password]" value="{$modconfig.main.site_email_smtp_password}" class="form-control" style="width: 98%;">
          </div>
        </div>
          
        
      </div>
    </div>
  </div>
</div>
