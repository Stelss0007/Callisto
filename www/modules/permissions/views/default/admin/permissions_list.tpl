<div class="row-fluid sortable">		
  <div class="box span12">
    <div class="box-header well" data-original-title>
      <h2><i class="icon-eye-open"></i> {#permissions_header#}</h2>
      <div class="box-icon">
        <a href="#" class="btn btn-setting btn-round"><i class="icon-cog"></i></a>
        <a href="#" class="btn btn-minimize btn-round"><i class="icon-chevron-up"></i></a>
        <a href="#" class="btn btn-close btn-round"><i class="icon-remove"></i></a>
      </div>
    </div>
    <div class="box-content">

      <table class="table table-striped table-bordered bootstrap-datatable datatable" width='100%' cellspacing=0 cellpadding=4>
        <thead>
          <tr>
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
      <div style="text-align: center;">
        <a href='/admin/permissions/manage' class='btn'><i class="icon icon-add"></i> Добавить</a>
      </div>


    </div>
  </div><!--/span-->

</div><!--/row-->