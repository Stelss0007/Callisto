{strip}
  <div class="row-fluid">		
    <div class="box span12">
      <div class="box-header well" data-original-title>
        <h2><i class="icon-layout"></i> Доступные блоки</h2>
      </div>
      <div class="box-content">
        <form action="/admin/blocks/group_operation">
          <input type="hidden" name="position" value="{$position}">
          <div class="btn-toolbar batch-actions-buttons">
            <div class="btn-group">
              <a href='#' rel="install" class='btn btn-success'><i class="icon icon-download icon-white"></i> {#sys_install#}</a>
            </div>
          </div>

          <table class="table table-striped table-bordered bootstrap-datatable" cellSpacing="1" cellPadding="4" width="100%">
            <colgroup>
              <col width="10">
              <col width="20%">
              <col width="10%">
              <col width="50%">
              <col width="10%">
              <col width="10">
            </colgroup>

            <thead>
              <tr align="middle">
                <th>
                  <input type="checkbox" name="entities[]" class="td_entiies_group" value="">
                </th>
                <th class="head" nowrap>Отображаемое имя</th>
                <th class="head">Имя блока</th>
                <th class="head">Описание</th>
                <th class="head">Версия</th>
                <th class="head">Действия</th>
              </tr>
            </thead>

            <tbody>
              {foreach item=block from=$blocks_list_all}
                {cycle name="allblc" values="even,odd" assign="class" print=false}
                <tr align="middle">
                  <th style="width: 20px;">
                    <input type="checkbox" name="entities[]" class="td_entities" value="{$block.name}">
                  </th>
                  <td class="{$class}" align="left">{$block.displayname|escape}</td>
                  <td class="{$class}" align="left">{$block.name|escape}</td>
                  <td class="{$class}" align="left">{$block.description|escape}</td>
                  <td class="{$class}">{$block.block_version|escape}</td>
                  <td class="{$class}">
                    <div class="btn-group">
                      {array name='url_vars'}
                      {array_append name='url_vars' key='name' value=$block.name}
                      <a href="/admin/blocks/info/{$block.name}/{$position}" class="btn"><i class="icon icon-info-circled"></i></a>
                      <a href="/admin/blocks/add/{$position}/{$block.name}" class="btn"><i class="icon icon-download"></i></a>
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