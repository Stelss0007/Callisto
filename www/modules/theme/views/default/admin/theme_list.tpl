<div class="row-fluid sortable">		
  <div class="box span12">
    <div class="box-header well" data-original-title>
      <h2><i class="icon-picture"></i> {#themes_header#}</h2>
      <div class="box-icon">
        <a href="#" class="btn btn-setting btn-round"><i class="icon-cog"></i></a>
        <a href="#" class="btn btn-minimize btn-round"><i class="icon-chevron-up"></i></a>
        <a href="#" class="btn btn-close btn-round"><i class="icon-remove"></i></a>
      </div>
    </div>
    <div class="box-content">

      <table  width='100%' cellspacing=0 cellpadding=2 class="table table-striped table-bordered bootstrap-datatable datatable">
        <thead>
          <tr>
            <th style="width: 30px;"></th>
            <th>
              {#sys_title#}
            </th>
            <th>
              {#sys_description#}
            </th>
            <th>
              {#sys_author#}
            </th>
            <th>
              {#sys_name#}
            </th>
            <th>
              {#sys_version#}
            </th>
            <th style="width: 85px;">
              {#sys_actions#}
            </th>
          </tr>
        </thead>
        <tbody>
          {foreach from=$themes_list_all item=theme name=theme_}
            {cycle name="permsls" values="even,odd" assign="class" print=false}
            <tr class='{$class}'>
              <td>
                {if $theme.active != '1'}
                  <a href='/theme/activate/{$theme.id}' class="btn-icon btn-star-o" title="{#sys_activate#}"><i class="icon-star-empty"></i></a>
                  {else}
                  <span class="btn-icon icon-star" style="color: #E57C00; text-shadow: 1px 1px 1px #ccc;"></span>
                {/if}
                &nbsp;
              </td>
              <td>
                {$theme.theme_title}&nbsp;
              </td>
              <td>
                {$theme.theme_description}&nbsp;
              </td>
              <td>
                {$theme.theme_author}&nbsp;
              </td>
              <td>
                {$theme.theme_name}&nbsp;
              </td>
              <td style="text-align: center;">
                {$theme.theme_version}&nbsp;
              </td>
              <td>
                <div class="btn-group">
                  {if $theme.active != '1'}
                    <a href='/admin/theme/activate/{$theme.id}' class="btn btn-icon btn-star-o" title="{#sys_activate#}"><i class="icon-play"></i></a>
                    {else}
                    <span class="btn-icon btn-star" style="color: #E57C00; text-shadow: 1px 1px 1px #ccc;"></span>
                  {/if}
                  {if $theme.active != '1'}
                    <a href='/admin/theme/delete/{$theme.id}' title='{#user_delete#}' onclick="return confirm('{#sys_delete#}?')" class="btn btn-icon btn-delete"><i class="icon-trash"></i></a>
                    {/if}
                </div>
              </td>
            </tr>
          {/foreach}
        </tbody>
      </table>
      <div style="text-align: center;">
        <a href='/admin/theme/install' class='btn'><i class="icon icon-add"></i> {#sys_add#}</a>
      </div>

    </div>
  </div><!--/span-->

</div><!--/row-->
