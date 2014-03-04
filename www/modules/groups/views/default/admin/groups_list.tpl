<div class="row-fluid sortable">		
  <div class="box span12">
    <div class="box-header well" data-original-title>
      <h2><i class="icon-user"></i> {#groups_header#}</h2>
      <div class="box-icon">
        <a href="#" class="btn btn-setting btn-round"><i class="icon-cog"></i></a>
        <a href="#" class="btn btn-minimize btn-round"><i class="icon-chevron-up"></i></a>
        <a href="#" class="btn btn-close btn-round"><i class="icon-remove"></i></a>
      </div>
    </div>
    <div class="box-content">
      <table  width='100%' cellspacing=0 cellpadding=4 class="table table-striped table-bordered bootstrap-datatable datatable">
        <colgroup>
          <col width='*'>
          <col width='*'>
          <col width='90'>
        </colgroup>
        <thead>
          <tr>
            <th>
              {#groups_title#}
            </th>
            <th>
              {#groups_description#}
            </th>
            <th>
              {#groups_actions#}
            </th>
          </tr>
        </thead>
        <tbody>
          {foreach from=$groups_list item=group}
            {cycle name="groups" values="even,odd" assign="class" print=false}
            <tr class='{$class}'>
              <td>
                {$group.group_displayname}
              </td>

              <td>
                {$group.group_description}
              </td>

              <td style="text-align: center;">
                <div class="btn-group">
                  <a href='/admin/groups/manage/{$group.id}' title="{#sys_edit#}" class="btn btn-icon btn-edit"><i class="icon-edit"></i></a>
                  <a href='/admin/groups/delete/{$group.id}' title="{#sys_delete#}" onclick="return confirm('{#sys_confirm_delete#}');" class="btn btn-icon btn-delete"><i class="icon-trash"></i></a>
                </div>
              </td>
            </tr>
          {/foreach}
        </tbody>
      </table>
      <div style="text-align: center;">
        <a href='/admin/groups/manage' class='btn'><i class="icon icon-add"></i> {#groups_add#}</a> 
      </div>

    </div>
  </div><!--/span-->

</div><!--/row-->