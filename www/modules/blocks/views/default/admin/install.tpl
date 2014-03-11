{strip}
  <div class="row-fluid">		
    <div class="box span12">
      <div class="box-header well" data-original-title>
        <h2><i class="icon-user"></i> Доступные блоки</h2>
      </div>
      <div class="box-content">
        <form action="/admin/blocks/group_operation">
          <div class="btn-toolbar batch-actions-buttons">
            <div class="btn-group">
              <a href='/admin/blocks/install/l' class='btn btn-success'><i class="icon icon-plus-sign icon-white"></i> {#sys_add#}</a>
              <a href='/admin/blocks/config' class="btn btn-icon btn-star-o" title="{#sys_configuration#}"><i class="icon-wrench"></i> {#sys_configuration#}</a>
              <a href='#' rel="activate" class="btn btn-icon btn-star-o disabled" title="{#sys_activate#}"><i class="icon-play"></i> {#sys_activate#}</a>
              <a href='#' rel="deactivate" class="btn btn-icon btn-star-o disabled" title="{#sys_deactivate#}"><i class="icon-pause"></i> {#sys_deactivate#}</a>
            </div>

            <div class="btn-group delete-group">
              <a class="btn btn-danger batch-delete-button table_actions_link" rel="delete" href="#"><i class="icon-trash icon-white"></i> {#sys_delete#}</a>
            </div>
          </div>

          <table class="table table-striped table-bordered bootstrap-datatable datatable" cellSpacing="1" cellPadding="4" width="100%">
            <colgroup>
              <col width="20%">
              <col width="10%">
              <col width="50%">
              <col width="10%">
              <col width="10%">
            </colgroup>

            <thead>
              <tr align="middle">
                <td class="head" nowrap>Отображаемое имя</td>
                <td class="head">Имя блока</td>
                <td class="head">Описание</td>
                <td class="head">Версия</td>
                <td class="head">Действия</td>
              </tr>
            </thead>

            <tbody>
              {foreach item=block from=$blocks_list_all}
                {cycle name="allblc" values="even,odd" assign="class" print=false}
                <tr align="middle">
                  <td class="{$class}" align="left">{$block.block_displayname|escape}</td>
                  <td class="{$class}" align="left">{$block.block_name|escape}</td>
                  <td class="{$class}" align="left">{$block.block_description|escape}</td>
                  <td class="{$class}">{$block.block_version|escape}</td>
                  <td class="{$class}">
                    <div class="btn-group">
                      {array name='url_vars'}
                      {array_append name='url_vars' key='block_name' value=$block.block_name}
                      <a href=""><img border="0" src="/public/images/system/info.gif" alt="Информация"></a>&nbsp;
                      <a href="/admin/blocks/add/{$position}/{$block.block_name}"><img border="0" src="/public/images/system/add.gif" alt="Добавить"></a>
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
{/strip}