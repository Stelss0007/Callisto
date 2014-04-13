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
            <input type="text" name="modconfig[main][site_name]" value="{$modconfig.main.site_name}" style="width: 98%;">
          </div>
        </div>
          
        <div class="control-group">
          <label for="date01" class="control-label">{#site_slogan#}</label>
          <div class="controls">
            <input type="text" name="modconfig[main][site_slogan]" value="{$modconfig.main.site_slogan}" style="width: 98%;">
          </div>
        </div>
          
        <div class="control-group">
          <label for="date01" class="control-label">{#site_description#}</label>
          <div class="controls">
            <textarea style="width: 98%;" name="modconfig[main][site_description]">{$modconfig.main.site_description}</textarea>
          </div>
        </div>
          
        <div class="control-group">
          <label for="date01" class="control-label">{#site_footer#}</label>
          <div class="controls">
            <input type="text" name="modconfig[main][site_footer]" value="{$modconfig.main.site_footer}" style="width: 98%;">
          </div>
        </div>

        <div class="control-group">
          <label for="date01" class="control-label">{#site_dateformat#}</label>
          <div class="controls">
             <select data-rel="chosen_" name="modconfig[main][site_dateformat]">
              {html_options options=$site_dateformat_list selected=$modconfig.main.site_dateformat}
             </select>
          </div>
        </div>
          
        <div class="control-group">
          <label for="date01" class="control-label">{#site_timeformat#}</label>
          <div class="controls">
            <select data-rel="chosen_" name="modconfig[main][site_timeformat]">
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
            <textarea style="width: 98%;" name="modconfig[main][site_offline_message]">{$modconfig.main.site_offline_message|default:'Сайт закрыт на техническое обслуживание.<br /> Пожалуйста, зайдите позже.'}</textarea>
          </div>
        </div>
              
        <div class="control-group">
          <label for="date01" class="control-label">{#site_list_lenght#}</label>
          <div class="controls">
            <select data-rel="chosen_" name="modconfig[main][site_list_lenght]">
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
              <textarea style="width: 98%;" name="modconfig[main][site_seo_description]">{$modconfig.main.site_seo_description}</textarea>
            </div>
          </div>
            
          <div class="control-group">
            <label for="date01" class="control-label">{#site_seo_keywords#}</label>
            <div class="controls">
              <textarea style="width: 98%;" name="modconfig[main][site_seo_keywords]">{$modconfig.main.site_seo_keywords}</textarea>
            </div>
          </div>
            
          <div class="control-group">
            <label for="date01" class="control-label">{#site_seo_robots#}</label>
            <div class="controls">
             <select data-rel="chosen_" name="modconfig[main][site_seo_robots]">
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
        Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.
      </div>
    </div>
  </div>
</div>
