<div class="row-fluid">		
  <div class="box span12">
    <div class="box-header well" data-original-title>
      <h2><i class="icon-user"></i> {#articles_header#}</h2>
    </div>
    <div class="box-content">
      <div class="btn-group" style="float: right;">
        <form method="GET" class="app-filter">
          <select name="filter[article_category_id]"  data-rel="chosen">
            {html_options options=$article_category_list selected=$article_category_id}
          </select>
          <select name="filter[article_user_id]" data-rel="chosen">
            {html_options options=$article_user_list selected=$article_user_id}
          </select>
          <select name="filter[article_active]" data-rel="chosen">
            {html_options options=$article_status_list selected=$article_active}
          </select>
        </form>
      </div>
      <form action="/admin/articles/group_operation">
        <div class="btn-toolbar batch-actions-buttons">
          <div class="btn-group">
            <a href='/admin/articles/article_manage' class='btn btn-success'><i class="icon icon-plus-sign icon-white"></i> {#sys_add#}</a>
            <a href='/admin/articles/category_list' class="btn btn-icon btn-star-o" title="{#sys_configuration#}"><i class="icon-book"></i> {#sys_categories#}</a>
            <a href='/admin/articles/config' class="btn btn-icon btn-star-o" title="{#sys_configuration#}"><i class="icon-wrench"></i> {#sys_configuration#}</a>
            <a href='#' rel="activate" class="btn btn-icon btn-star-o" title="{#sys_activate#}"><i class="icon-play"></i> {#sys_activate#}</a>
            <a href='#' rel="deactivate" class="btn btn-icon btn-star-o" title="{#sys_deactivate#}"><i class="icon-pause"></i> {#sys_deactivate#}</a>
          </div>

          <div class="btn-group delete-article">
            <a class="btn btn-danger batch-delete-button table_actions_link" rel="delete" href="#"><i class="icon-trash icon-white"></i> {#sys_delete#}</a>
          </div>

        </div>

        <table  width='100%' cellspacing=0 cellpadding=4 class="table table-striped table-bordered bootstrap-datatable" data-source="/admin/articles/ajax_article_list">
          <colgroup>
            <col width='30'>
            <col width='30'>
            <col width='*'>
            <col width='*'>
            <col width='*'>
            <col width='90'>
            <col width='*'>
            <col width='140'>
          </colgroup>
          <thead>
            <tr>
              <th style="width: 25px;">
                <input type="checkbox" name="entities[]" class="td_entiies_group" value="">
              </th>
              <th>
                ID
              </th>
              <th>
                {#articles_title#}
              </th>
              <th>
                {#articles_category#}
              </th>
              <th>
                {#articles_author#}
              </th>
              <th>
                {#articles_active#}
              </th>
              <th>
                {#articles_add_time#}
              </th>
              <th>
                {#articles_actions#}
              </th>
            </tr>
          </thead>
          <tbody>
            
            {foreach from=$articles_list item=article}
              {cycle name="articles" values="even, odd" assign="class" print=false}
              <tr class='{$class}'>
                <th>
                  <input type="checkbox" name="entities[]" class="td_entities" value="{$article.id}">
                </th>
                <td>
                  {$article.id}
                </td>
                <td>
                  {$article.article_title|escape}
                </td>
                <td>
                  {$article_category_list[$article.article_category_id]}
                </td>
                <td>
                  <a href="#{$article.article_user_id}">
                  {$article.login} 
                  </a>
                </td>
                <td>
                  {if $article.article_active == 1}
                    {#sys_yes#}
                  {else}
                    {#sys_no#}
                  {/if}
                </td>
                <td>
                  {$article.article_add_time|date_format}
                </td>

                <td style="text-align: center;">
                  <div class="btn-group">
                    {if $article.article_active}
                      <a href='/admin/articles/activation/{$article.id}' onclick="return confirm('{#sys_confirm_deactivate#}')" title='{#sys_disabled#}' class="btn btn-icon btn-pause"><i class="icon-pause"></i></a>
                    {else}
                      <a href='/admin/articles/activation/{$article.id}' onclick="return confirm('{#sys_confirm_activate#}')" title='{#sys_enabled#}' class="btn btn-icon btn-play"><i class="icon-play"></i></a>
                    {/if}
                    <a href='/admin/articles/article_manage/{$article.id}' title="{#sys_edit#}" class="btn btn-icon btn-edit"><i class="icon-edit"></i></a>
                    <a href='/admin/articles/delete/{$article.id}' title="{#sys_delete#}" class="btn btn-icon btn-delete"><i class="icon-trash"></i></a>
                  </div>
                </td>
              </tr>
            {/foreach}
            
          </tbody>
        </table>
      </form>
      {pagination paging_element_count=7}
    </div>
  </div><!--/span-->

</div><!--/row-->