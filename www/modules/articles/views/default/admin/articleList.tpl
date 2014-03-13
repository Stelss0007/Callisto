<div class="row-fluid">		
  <div class="box span12">
    <div class="box-header well" data-original-title>
      <h2><i class="icon-user"></i> {#articles_header#}</h2>
    </div>
    <div class="box-content">
      <form action="/admin/articles/article_operation">
        <div class="btn-toolbar batch-actions-buttons">
          <div class="btn-group">
            <a href='/admin/articles/article_manage' class='btn btn-success'><i class="icon icon-plus-sign icon-white"></i> {#sys_add#}</a>
            <a href='/admin/articles/config' class="btn btn-icon btn-star-o" title="{#sys_configuration#}"><i class="icon-wrench"></i> {#sys_configuration#}</a>
            <a href='#' rel="activate" class="btn btn-icon btn-star-o" title="{#sys_activate#}"><i class="icon-play"></i> {#sys_activate#}</a>
            <a href='#' rel="deactivate" class="btn btn-icon btn-star-o" title="{#sys_deactivate#}"><i class="icon-pause"></i> {#sys_deactivate#}</a>
          </div>

          <div class="btn-group delete-article">
            <a class="btn btn-danger batch-delete-button table_actions_link" rel="delete" href="#"><i class="icon-trash icon-white"></i> {#sys_delete#}</a>
          </div>
        </div>

        <table  width='100%' cellspacing=0 cellpadding=4 class="table table-striped table-bordered bootstrap-datatable datatable">
          <colarticle>
            <col width='10'>
            <col width='10'>
            <col width='*'>
            <col width='*'>
            <col width='90'>
          </colarticle>
          <thead>
            <tr>
              <th>
                <input type="checkbox" name="entities[]" class="td_entiies_article" value="">
              </th>
              <th>
                ID
              </th>
              <th>
                {#articles_title#}
              </th>
              <th>
                {#articles_description#}
              </th>
              <th>
                {#articles_actions#}
              </th>
            </tr>
          </thead>
          <tbody>
            {foreach from=$articles_list item=article}
              {cycle name="articles" values="even,odd" assign="class" print=false}
              <tr class='{$class}'>
                <th>
                  <input type="checkbox" name="entities[]" class="td_entities" value="{$article.id}">
                </th>
                <td>
                  {$article.id}
                </td>
                <td>
                  {$article.article_displayname}
                </td>

                <td>
                  {$article.article_description}
                </td>

                <td style="text-align: center;">
                  <div class="btn-group">
                    <a href='/admin/articles/manage/{$article.id}' title="{#sys_edit#}" class="btn btn-icon btn-edit"><i class="icon-edit"></i></a>
                    <a href='/admin/articles/delete/{$article.id}' title="{#sys_delete#}" class="btn btn-icon btn-delete"><i class="icon-trash"></i></a>
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