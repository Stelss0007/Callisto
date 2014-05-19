<div class="row-fluid">		
  <div class="box span12">
    <div class="box-header well" data-original-title>
      <h2><i class="icon-user"></i> {#groups_header#}</h2>
    </div>
    <div class="box-content">
      <form action="/admin/groups/group_operation">
        <div class="btn-toolbar batch-actions-buttons">
          <div class="btn-group">
            <a href='/admin/groups/manage' class='btn btn-success'><i class="icon icon-plus-sign icon-white"></i> {#sys_add#}</a>
            <a href='/admin/groups/config' class="btn btn-icon btn-star-o" title="{#sys_configuration#}"><i class="icon-wrench"></i> {#sys_configuration#}</a>
            <a href='#' rel="activate" class="btn btn-icon btn-star-o disabled" title="{#sys_activate#}"><i class="icon-play"></i> {#sys_activate#}</a>
            <a href='#' rel="deactivate" class="btn btn-icon btn-star-o disabled" title="{#sys_deactivate#}"><i class="icon-pause"></i> {#sys_deactivate#}</a>
          </div>

          <div class="btn-group delete-group">
            <a class="btn btn-danger batch-delete-button table_actions_link" rel="delete" href="#"><i class="icon-trash icon-white"></i> {#sys_delete#}</a>
          </div>
        </div>

        <table  width='100%' cellspacing=0 cellpadding=4 class="table table-striped table-bordered bootstrap-datatable">
          <colgroup>
            <col width='10'>
            <col width='10'>
            <col width='*'>
            <col width='*'>
            <col width='90'>
          </colgroup>
          <thead>
            <tr>
              <th>
                <input type="checkbox" name="entities[]" class="td_entiies_group" value="">
              </th>
              <th>
                ID
              </th>
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
                <th>
                  <input type="checkbox" name="entities[]" class="td_entities" value="{$group.id}">
                </th>
                <td>
                  {$group.id}
                </td>
                <td>
                  {$group.group_displayname}
                </td>

                <td>
                  {$group.group_description}
                </td>

                <td style="text-align: center;">
                  <div class="btn-group">
                    <a href='/admin/groups/manage/{$group.id}' title="{#sys_edit#}" class="btn btn-icon btn-edit"><i class="icon-edit"></i></a>
                    <a href='/admin/groups/delete/{$group.id}' title="{#sys_delete#}" class="btn btn-icon btn-delete"><i class="icon-trash"></i></a>
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