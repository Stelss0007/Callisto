<div class="row-fluid">		
  <div class="box span12">
    <div class="box-header well" data-original-title>
      <h2><i class="icon-eye-open"></i> {#permissions_header#}</h2>
    </div>
    <div class="box-content">
      <form action="/admin/permissions/group_operation">
        <div class="btn-toolbar batch-actions-buttons">
          <div class="btn-group">
            <a href='/admin/permissions/manage' class='btn btn-success'><i class="icon icon-plus-sign icon-white"></i> {#sys_add#}</a>
            <a href='/admin/permissions/config' class="btn btn-icon btn-star-o" title="{#sys_configuration#}"><i class="icon-wrench"></i> {#sys_configuration#}</a>
            <a href='#' rel="activate" class="btn btn-icon btn-star-o " title="{#sys_activate#}"><i class="icon-play"></i> {#sys_activate#}</a>
            <a href='#' rel="deactivate" class="btn btn-icon btn-star-o " title="{#sys_deactivate#}"><i class="icon-pause"></i> {#sys_deactivate#}</a>
          </div>

          <div class="btn-group delete-group">
            <a class="btn btn-danger batch-delete-button table_actions_link" rel="delete" href="#"><i class="icon-trash icon-white"></i> {#sys_delete#}</a>
          </div>
        </div>

        <table class="table table-striped table-bordered bootstrap-datatable datatable" width='100%' cellspacing=0 cellpadding=4>
          <thead>
            <tr>
              <th style="width: 10px;">
                <input type="checkbox" name="entities[]" class="td_entiies_group" value="">
              </th>
              <th>
                {#permissions_groups_title#}
              </th>
              <th>
                {#permissions_element#}
              </th>
              <th>
                {#permissions_object#}
              </th>
              <th>
                {#permissions_access_type#}
              </th>
              <th style="width: 75px;">
                {#permissions_order#}
              </th>
              <th style="width: 85px;">
                {#permissions_actions#}
              </th>
            </tr>
          </thead>
          <tbody>
            {foreach from=$group_permission item=permission name=permission_}
              {cycle name="permsls" values="even,odd" assign="class" print=false}
              <tr class='{$class}'>
                <th>
                  <input type="checkbox" name="entities[]" class="td_entities" value="{$permission.id}">
                </th>
                <td>
                  {$group[$permission.group_permission_gid]}
                </td>
                <td>
                  {#permissions_element#}
                </td>
                <td>
                  {$permission.group_permission_pattern}
                </td>
                <td>
                  {$levels[$permission.group_permission_level]}
                </td>
                <td style="text-align: center;">
                  <div class="btn-group">
                    {if !$smarty.foreach.permission_.first}
                      <a href="/admin/permissions/weight_up/{$permission.group_permission_weight}" class="btn btn-icon btn-up" title="{#sys_up#}"><i class="icon-arrow-up"></i></a>
                      {/if}
                      {if !$smarty.foreach.permission_.first && !$smarty.foreach.permission_.last}

                    {/if}
                    {if !$smarty.foreach.permission_.last}
                      <a href="/admin/permissions/weight_down/{$permission.group_permission_weight}" class="btn btn-icon btn-down"  title="{#sys_down#}"><i class="icon-arrow-down"></i></a>
                      {/if}
                  </div>
                </td>
                <td>
                  <div class="btn-group">
                    <a href='/admin/permissions/manage/{$permission.id}' class="btn btn-icon btn-edit" title="{#sys_edit#}"><i class="icon-edit"></i></a>
                    <a href='/admin/permissions/delete/{$permission.id}' class="btn btn-icon btn-delete" title="{#sys_delete#}" onclick="return confirm('{#sys_confirm_delete#}');"><i class="icon-trash"></i></a>
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