<div class="row-fluid sortable">		
  <div class="box span12">
    <div class="box-header well" data-original-title>
      <h2><i class="icon-database"></i> {#city_header#}</h2>
    </div>
    <div class="box-content">

    <form action="/admin/cities/group_operation">
      <div class="btn-toolbar batch-actions-buttons">
        <div class="btn-group">
          <a href='/admin/cities/create{if $parent_id}/{$parent_id}{/if}' class='btn btn-success'><i class="icon icon-plus-sign icon-white"></i> {#sys_add#}</a>
          <a href='/admin/configuration/cities' class="btn btn-default" title="{#sys_configuration#}"><i class="icon-cog"></i> {#sys_configuration#}</a>
          <a href='#' rel="activate" class="btn btn-default" title="{#sys_activate#}"><i class="icon-play"></i> {#sys_activate#}</a>
          <a href='#' rel="deactivate" class="btn btn-default" title="{#sys_deactivate#}"><i class="icon-pause"></i> {#sys_deactivate#}</a>
        </div>

        <div class="btn-group delete-group">
          <a class="btn btn-danger batch-delete-button table_actions_link" rel="delete" href="#"><i class="icon-trash icon-white"></i> {#sys_delete#}</a>
        </div>
      </div>
      <table width='100%' cellspacing=0 cellpadding=4 class="table table-striped table-bordered bootstrap-datatable">
        <colgroup>
          <col width='30'>
          <col width='*'>
          <col width='*'>
          <col width='60'>
          <col width='*'>
          <col width='*'>
          <col width='*'>
          <col width='*'>
          <col width='*'>
          <col width='100'>
        </colgroup>
        <thead>
          <tr>
            <th style="width: 25px;">
                <input type="checkbox" name="entities[]" class="td_entiies_group" value="">
            </th>
            <th>
              {#cities_title#} RU
            </th>
            <th>
              {#cities_title#} EN
            </th>
            <th>
              {#cities_code#}
            </th>
            <th>
              {#cities_country#}
            </th>
            <th>
              {#cities_areaInSqKm#}
            </th>
            <th>
              {#cities_population#}
            </th>
            <th>
               
            </th>
          </tr>
        </thead>
        <tbody>
          {foreach from=$cities item=cities name=city}
            {cycle name="cities" values="even,odd" assign="class" print=false}
            <tr class='{$class}'>
              <th>
                  <input type="checkbox" name="entities[]" class="td_entities" value="{$cities.id}">
              </th>
              
              <td>
                {$cities.name_ru}
              </td>
              <td>
                {$cities.name_en}
              </td>
              <td>
                {$cities.code}
              </td>
              <td>
                {$countries[$cities.country_id]}
              </td>
              <td>
                {$cities.areaInSqKm}
              </td>
              <td>
                {$cities.population}
              </td>
             
              <td>
                <div class="btn-group">
                  <a href='/admin/cities/modify/{$cities.id}' title="{#sys_edit#}" class="btn btn-icon"><i class="icon-edit"></i></a>
                  <a href='/admin/cities/delete/{$cities.id}' title="{#sys_delete#}" class="btn btn-icon btn-delete" onclick="return confirm('{#sys_confirm_delete#}');"><i class="icon-trash"></i></a>
                </div>
              </td>
            </tr>
          {/foreach}
        </tbody>
      </table>
    </form>
    
    </div>
  </div><!--/span-->

</div><!--/row-->