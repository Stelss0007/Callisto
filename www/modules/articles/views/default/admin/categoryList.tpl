<div class="row-fluid">		
  <div class="box span12">
    <div class="box-header well" data-original-title>
      <h2><i class="icon-user"></i> {#categorys_header#}</h2>
    </div>
    <div class="box-content">
      <form action="/admin/articles/category_group_operation">
        <div class="btn-toolbar batch-actions-buttons">
          <div class="btn-group">
            <a href='/admin/articles/category_manage' class='btn btn-success'><i class="icon icon-plus-sign icon-white"></i> {#sys_add#}</a>
            <a href='#' rel="activate" class="btn btn-icon btn-star-o" title="{#sys_activate#}"><i class="icon-play"></i> {#sys_activate#}</a>
            <a href='#' rel="deactivate" class="btn btn-icon btn-star-o" title="{#sys_deactivate#}"><i class="icon-pause"></i> {#sys_deactivate#}</a>
          </div>

          <div class="btn-group delete-category">
            <a class="btn btn-danger batch-delete-button table_actions_link" rel="delete" href="#"><i class="icon-trash icon-white"></i> {#sys_delete#}</a>
          </div>
        </div>

        <table  width='100%' cellspacing=0 cellpadding=4 class="table table-striped table-bordered bootstrap-datatable datatable">
          <colgroup>
            <col width='10'>
            <col width='10'>
            <col width='*'>
            <col width='90'>
            <col width='140'>
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
                {#sys_title#}
              </th>
              <th>
                {#sys_active#}
              </th>
             
              <th>
                {#sys_actions#}
              </th>
            </tr>
          </thead>
          <tbody>
            {foreach from=$categories_list item=category}
              {cycle name="categories" values="even, odd" assign="class" print=false}
              <tr class='{$class}'>
                <th>
                  <input type="checkbox" name="entities[]" class="td_entities" value="{$category.id}">
                </th>
                <td>
                  {$category.id}
                </td>
                <td>
                  {$category.article_category_title|escape}
                </td>
                
                <td>
                  {$category.article_category_active}
                </td>
                
                <td style="text-align: center;">
                  <div class="btn-group">
                    {if $category.article_category_active}
                      <a href='/admin/articles/category_activation/{$category.id}' onclick="return confirm('{#sys_confirm_deactivate#}')" title='{#sys_disabled#}' class="btn btn-icon btn-pause"><i class="icon-pause"></i></a>
                    {else}
                      <a href='/admin/articles/category_activation/{$category.id}' onclick="return confirm('{#sys_confirm_activate#}')" title='{#sys_enabled#}' class="btn btn-icon btn-play"><i class="icon-play"></i></a>
                    {/if}
                    <a href='/admin/articles/category_manage/{$category.id}' title="{#sys_edit#}" class="btn btn-icon btn-edit"><i class="icon-edit"></i></a>
                    <a href='/admin/articles/category_delete/{$category.id}' title="{#sys_delete#}" class="btn btn-icon btn-delete"><i class="icon-trash"></i></a>
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