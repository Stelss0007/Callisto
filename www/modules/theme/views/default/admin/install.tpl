
<div class="row-fluid sortable">		
  <div class="box span12">
    <div class="box-header well" data-original-title>
      <h2><i class="icon-picture"></i> {#themes_add_header#}</h2>
      <div class="box-icon">
        <a href="#" class="btn btn-setting btn-round"><i class="icon-cog"></i></a>
        <a href="#" class="btn btn-minimize btn-round"><i class="icon-chevron-up"></i></a>
        <a href="#" class="btn btn-close btn-round"><i class="icon-remove"></i></a>
      </div>
    </div>
    <div class="box-content">
      <form action="/admin/theme/group_operation">
        <div class="btn-toolbar batch-actions-buttons">
          <div class="btn-group">
            <a href='#' rel="install" class='btn btn-success'><i class="icon icon-download-alt icon-white"></i> {#sys_install#}</a>
          </div>
        </div>
        <table  width='100%' cellspacing=0 cellpadding=2 class="table table-striped table-bordered bootstrap-datatable datatable">
          <thead>
            <tr>
              <th style="width: 10px;">
                <input type="checkbox" name="entities[]" class="td_entiies_group" value="">
              </th>
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
              <th style="width: 125px;">
                {#sys_actions#}
              </th>
            </tr>
          </thead>
          <tbody>
            {foreach from=$themes_list_all item=theme name=theme_}
              {cycle name="permsls" values="even,odd" assign="class" print=false}
              <tr class='{$class}'>
                <th>
                  <input type="checkbox" name="entities[]" class="td_entities" value="{$theme.name}">
                </th>
                <td>
                  {$theme.title}&nbsp;
                </td>
                <td>
                  {$theme.description}&nbsp;
                </td>
                <td>
                  {$theme.author}&nbsp;
                </td>
                <td>
                  {$theme.name}&nbsp;
                </td>
                <td style="text-align: center;">
                  {$theme.version}&nbsp;
                </td>
                <td>
                  <a href='/admin/theme/add/{$theme.name}' class="btn btn-icon btn-upload" title="{#sys_install#}"><i class="icon-download-alt"></i><span>&nbsp;{#sys_install#}</span></a>
                </td>
              </tr>
            {/foreach}
          </tbody>
        </table>
      </form>

    </div>
  </div><!--/span-->

</div><!--/row-->
