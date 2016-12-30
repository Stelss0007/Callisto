{strip}
  {******************************СЛЕВА*******************************************}
  <div class="row-fluid">		
    <div class="box span12">
      <div class="box-header well" data-original-title>
        <h2><i class="icon-layout"></i> Установленные блоки слева</h2>
      </div>
      <div class="box-content">
        <form action="/admin/blocks/group_operation">
          <div class="btn-toolbar batch-actions-buttons">
            <div class="btn-group">
              <a href='/admin/blocks/install/l' class='btn btn-success'><i class="icon icon-plus-sign icon-white"></i> {#sys_add#}</a>
              <a href='#' rel="activate" class="btn btn-default" title="{#sys_activate#}"><i class="icon-play"></i> {#sys_activate#}</a>
              <a href='#' rel="deactivate" class="btn btn-default" title="{#sys_deactivate#}"><i class="icon-pause"></i> {#sys_deactivate#}</a>
            </div>

            <div class="btn-group delete-group">
              <a class="btn btn-danger batch-delete-button table_actions_link" rel="delete" href="#"><i class="icon-trash icon-white"></i> {#sys_delete#}</a>
            </div>
          </div>

          <table class="table table-striped table-bordered bootstrap-datatable" cellSpacing="1" cellPadding="4" width="100%">
            <colgroup>
              <col width='10'>
              <col width='200'>
              <col width='200'>
              <col width='*'>
              <col width='50'>
              <col width='90'>
            </colgroup>
            <thead>
              <tr align="middle">
                <th style="width: 25px;">
                  <input type="checkbox" name="entities[]" class="td_entiies_group" value="">
                </th>
                <th class="head" nowrap>Отображаемое имя</th>
                <th class="head">Имя блока</th>
                <th class="head">Маска</th>
                <th class="head">Порядок</th>
                <th class="head" style="width: 90px;">Действия</th>
              </tr>
            </thead>

            <tbody>
              {foreach item=block from=$blocks_list_l name=fblock_l}
                {cycle name="instblc" values="even,odd" assign="class" print=false}

                <tr align="middle">
                  <th style="width: 20px;">
                    <input type="checkbox" name="entities[]" class="td_entities" value="{$block->id}">
                  </th>
                  <td class="{$class}" align="left">{$block->displayname|escape}</td>
                  <td class="{$class}" align="left">{$block->name|escape}</td>
                  <td class="{$class}" align="left">{$block->pattern|escape}</td>

                  {* Weight *}
                  <td class="{$class}" align="center" nowrap style="width: 90px;">
                    <div class="btn-group" style="text-align: center;">
                      {if !$smarty.foreach.fblock_l.first}
                        <a href="/admin/blocks/weight_up/{$block->id}" class="btn btn-icon btn-up" title="{#sys_up#}"><i class="icon-arrow-up"></i></a>
                      {/if}
                      {if !$smarty.foreach.fblock_l.last}
                        <a href="/admin/blocks/weight_down/{$block->id}" class="btn btn-icon btn-down" title="{#sys_down#}"><i class="icon-arrow-down"></i></a>
                      {/if}
                    </div>
                  </td>

                  <td class="{$class}" align="center" nowrap style="width: 120px;">
                    <div class="btn-group">
                      {* Действия над блоком *}
                      {array name='url_vars'}
                      {array_append name='url_vars' key='id' value=$block->id}
                      {if $block->active}
                        <a href="/admin/blocks/deactive/{$block->id}" class="btn btn-icon btn-pause" title="{#sys_deactivate#}"><i class="icon-pause"></i></a>
                        <a href="/admin/blocks/modify/{$block->id}" class="btn btn-icon btn-edit" title="{#sys_edit#}"><i class="icon-edit"></i></a>
                        {else}
                        <a href="/admin/blocks/active/{$block->id}" class="btn btn-icon btn-play" title="{#sys_activate#}"><i class="icon-play"></i></a>
                        <a href="/admin/blocks/modify/{$block->id}" class="btn btn-icon btn-edit" title="{#sys_edit#}"><i class="icon-edit"></i></a>
                        <a href="/admin/blocks/delete/{$block->id}/{$block->weight}/{$block->position}" class="btn btn-icon btn-delete" title="{#sys_delete#}"><i class="icon-trash"></i></a>
                        {/if}
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

  <hr><br>
  {******************************СПРАВА*******************************************}

  <div class="row-fluid">		
    <div class="box span12">
      <div class="box-header well" data-original-title>
        <h2><i class="icon-layout"></i> Установленные блоки справа</h2>
      </div>
      <div class="box-content">
        <form action="/admin/blocks/group_operation">
          <div class="btn-toolbar batch-actions-buttons">
            <div class="btn-group">
              <a href='/admin/blocks/install/r' class='btn btn-success'><i class="icon icon-plus-sign icon-white"></i> {#sys_add#}</a>
              <a href='#' rel="activate" class="btn btn-default" title="{#sys_activate#}"><i class="icon-play"></i> {#sys_activate#}</a>
              <a href='#' rel="deactivate" class="btn btn-default" title="{#sys_deactivate#}"><i class="icon-pause"></i> {#sys_deactivate#}</a>
            </div>

            <div class="btn-group delete-group">
              <a class="btn btn-danger batch-delete-button table_actions_link" rel="delete" href="#"><i class="icon-trash icon-white"></i> {#sys_delete#}</a>
            </div>
          </div>

          <table class="table table-striped table-bordered bootstrap-datatable" cellSpacing="1" cellPadding="4" width="100%">
            <colgroup>
              <col width='10'>
              <col width='200'>
              <col width='200'>
              <col width='*'>
              <col width='50'>
              <col width='90'>
            </colgroup>

            <thead>
              <tr align="middle">
                <th style="width: 25px;">
                  <input type="checkbox" name="entities[]" class="td_entiies_group" value="">
                </th>
                <th class="head" nowrap>Отображаемое имя</th>
                <th class="head">Имя блока</th>
                <th class="head">Маска</th>
                <th class="head">Порядок</th>
                <th class="head">Действия</th>
              </tr>
            </thead>
            <tbody>
              {foreach item=block from=$blocks_list_r name=fblock_r}
                {cycle name="instblc" values="even,odd" assign="class" print=false}

                <tr align="middle">
                  <th style="width: 20px;">
                    <input type="checkbox" name="entities[]" class="td_entities" value="{$block->id}">
                  </th>
                  <td class="{$class}" align="left">{$block->displayname|escape}</td>
                  <td class="{$class}" align="left">{$block->name|escape}</td>
                  <td class="{$class}" align="left">{$block->pattern|escape}</td>

                  {* Weight *}
                  <td class="{$class}" align="center" nowrap style="width: 90px;">
                    <div class="btn-group" style="text-align: center;">
                      {if !$smarty.foreach.fblock_r.first}
                        <a href="/admin/blocks/weight_up/{$block->id}" class="btn btn-icon btn-up" title="{#sys_up#}"><i class="icon-arrow-up"></i></a>
                      {/if}
                      {if !$smarty.foreach.fblock_r.first && !$smarty.foreach.fblock_r.last}
                      {/if}
                      {if !$smarty.foreach.fblock_r.last}
                        <a href="/admin/blocks/weight_down/{$block->id}" class="btn btn-icon btn-down" title="{#sys_down#}"><i class="icon-arrow-down"></i></a>
                        {/if}
                    </div>
                  </td>

                  <td class="{$class}" align="center" nowrap style="width: 120px;">
                    <div class="btn-group">
                      {* Действия над блоком *}
                      {array name='url_vars'}
                      {array_append name='url_vars' key='id' value=$block->id}
                      {if $block->active}
                        <a href="/admin/blocks/deactive/{$block->id}" class="btn btn-icon btn-pause" title="{#sys_deactivate#}"><i class="icon-pause"></i></a>
                        <a href="/admin/blocks/modify/{$block->id}" class="btn btn-icon btn-edit" title="{#sys_edit#}"><i class="icon-edit"></i></a>
                        {else}
                        <a href="/admin/blocks/active/{$block->id}" class="btn btn-icon btn-play" title="{#sys_activate#}"><i class="icon-play"></i></a>
                        <a href="/admin/blocks/modify/{$block->id}" class="btn btn-icon btn-edit" title="{#sys_edit#}"><i class="icon-edit"></i></a>
                        <a href="/admin/blocks/delete/{$block->id}/{$block->weight}/{$block->position}" class="btn btn-icon btn-delete" title="{#sys_delete#}"><i class="icon-trash"></i></a>
                        {/if}
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

  <hr><br>
  {******************************СВЕРХУ*******************************************}

  <div class="row-fluid">		
    <div class="box span12">
      <div class="box-header well" data-original-title>
        <h2><i class="icon-layout"></i> Установленные блоки сверху</h2>
      </div>
      <div class="box-content">
        <form action="/admin/blocks/group_operation">
          <div class="btn-toolbar batch-actions-buttons">
            <div class="btn-group">
              <a href='/admin/blocks/install/t' class='btn btn-success'><i class="icon icon-plus-sign icon-white"></i> {#sys_add#}</a>
              <a href='#' rel="activate" class="btn btn-default" title="{#sys_activate#}"><i class="icon-play"></i> {#sys_activate#}</a>
              <a href='#' rel="deactivate" class="btn btn-default" title="{#sys_deactivate#}"><i class="icon-pause"></i> {#sys_deactivate#}</a>
            </div>

            <div class="btn-group delete-group">
              <a class="btn btn-danger batch-delete-button table_actions_link" rel="delete" href="#"><i class="icon-trash icon-white"></i> {#sys_delete#}</a>
            </div>
          </div>

          <table class="table table-striped table-bordered bootstrap-datatable" cellSpacing="1" cellPadding="4" width="100%">
            <colgroup>
              <col width='10'>
              <col width='200'>
              <col width='200'>
              <col width='*'>
              <col width='50'>
              <col width='90'>
            </colgroup>

            <thead>
              <tr align="middle">
                <th style="width: 25px;">
                  <input type="checkbox" name="entities[]" class="td_entiies_group" value="">
                </th>
                <th class="head" nowrap>Отображаемое имя</th>
                <th class="head">Имя блока</th>
                <th class="head">Маска</th>
                <th class="head">Порядок</th>
                <th class="head">Действия</th>
              </tr>
            </thead>
           
            <tbody>
              {foreach item=block from=$blocks_list_t name=fblock_t}
                {cycle name="instblc" values="even,odd" assign="class" print=false}

                <tr align="middle">
                  <th style="width: 20px;">
                    <input type="checkbox" name="entities[]" class="td_entities" value="{$block->id}">
                  </th>
                  <td class="{$class}" align="left">{$block->displayname|escape}</td>
                  <td class="{$class}" align="left">{$block->name|escape}</td>
                  <td class="{$class}" align="left">{$block->pattern|escape}</td>

                  {* Weight *}
                  <td class="{$class}" align="center" nowrap style="width: 90px;">
                    <div class="btn-group" style="text-align: center;">
                      {if !$smarty.foreach.fblock_t.first}
                        <a href="/admin/blocks/weight_up/{$block->id}" class="btn btn-icon btn-up" title="{#sys_up#}"><i class="icon-arrow-up"></i></a>
                      {/if}
                      {if !$smarty.foreach.fblock_t.last}
                        <a href="/admin/blocks/weight_down/{$block->id}" class="btn btn-icon btn-down" title="{#sys_down#}"><i class="icon-arrow-down"></i></a>
                      {/if}
                    </div>
                  </td>

                  <td class="{$class}" align="center" nowrap  style="width: 120px;">
                    <div class="btn-group">
                      {* Действия над блоком *}
                      {array name='url_vars'}
                      {array_append name='url_vars' key='id' value=$block->id}
                      {if $block->active}
                        <a href="/admin/blocks/deactive/{$block->id}" class="btn btn-icon btn-pause" title="{#sys_deactivate#}"><i class="icon-pause"></i></a>
                        <a href="/admin/blocks/modify/{$block->id}" class="btn btn-icon btn-edit" title="{#sys_edit#}"><i class="icon-edit"></i></a>
                        {else}
                        <a href="/admin/blocks/active/{$block->id}" class="btn btn-icon btn-play" title="{#sys_activate#}"><i class="icon-play"></i></a>
                        <a href="/admin/blocks/modify/{$block->id}" class="btn btn-icon btn-edit" title="{#sys_edit#}"><i class="icon-edit"></i></a>
                        <a href="/admin/blocks/delete/{$block->id}/{$block->weight}/{$block->position}" class="btn btn-icon btn-delete" title="{#sys_delete#}"><i class="icon-trash"></i></a>
                        {/if}
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


  <hr><br>

  {******************************СНИЗУ*******************************************}


  <div class="row-fluid">		
    <div class="box span12">
      <div class="box-header well" data-original-title>
        <h2><i class="icon-layout"></i> Установленные блоки снизу</h2>
      </div>
      <div class="box-content">
        <form action="/admin/blocks/group_operation">
          <div class="btn-toolbar batch-actions-buttons">
            <div class="btn-group">
              <a href='/admin/blocks/install/b' class='btn btn-success'><i class="icon icon-plus-sign icon-white"></i> {#sys_add#}</a>
              <a href='#' rel="activate" class="btn btn-default" title="{#sys_activate#}"><i class="icon-play"></i> {#sys_activate#}</a>
              <a href='#' rel="deactivate" class="btn btn-default" title="{#sys_deactivate#}"><i class="icon-pause"></i> {#sys_deactivate#}</a>
            </div>

            <div class="btn-group delete-group">
              <a class="btn btn-danger batch-delete-button table_actions_link" rel="delete" href="#"><i class="icon-trash icon-white"></i> {#sys_delete#}</a>
            </div>
          </div>

          <table class="table table-striped table-bordered bootstrap-datatable" cellSpacing="1" cellPadding="4" width="100%">
            <colgroup>
              <col width='10'>
              <col width='200'>
              <col width='200'>
              <col width='*'>
              <col width='50'>
              <col width='90'>
            </colgroup>

            <thead>
              <tr align="middle">
                <th style="width: 25px;">
                  <input type="checkbox" name="entities[]" class="td_entiies_group" value="">
                </th>
                <th class="head" nowrap>Отображаемое имя</th>
                <th class="head">Имя блока</th>
                <th class="head">Маска</th>
                <th class="head">Порядок</th>
                <th class="head">Действия</th>
              </tr>
            </thead>

            <tbody>
              {foreach item=block from=$blocks_list_b name=fblock_b}
                {cycle name="instblc" values="even,odd" assign="class" print=false}

                <tr align="middle">
                  <th style="width: 20px;">
                    <input type="checkbox" name="entities[]" class="td_entities" value="{$block->id}">
                  </th>
                  <td class="{$class}" align="left">{$block->displayname|escape}</td>
                  <td class="{$class}" align="left">{$block->name|escape}</td>
                  <td class="{$class}" align="left">{$block->pattern|escape}</td>

                  {* Weight *}
                  <td class="{$class}" align="center" nowrap style="width: 90px;">
                    <div class="btn-group" style="text-align: center;">
                      {if !$smarty.foreach.fblock_b.first}
                        <a href="/admin/blocks/weight_up/{$block->id}" class="btn btn-icon btn-up" title="{#sys_up#}"><i class="icon-arrow-up"></i></a>
                      {/if}

                      {if !$smarty.foreach.fblock_b.last}
                        <a href="/admin/blocks/weight_down/{$block->id}" class="btn btn-icon btn-down" title="{#sys_down#}"><i class="icon-arrow-down"></i></a>
                      {/if}
                    </div>
                  </td>

                  <td class="{$class}" align="center" nowrap  style="width: 120px;">
                    <div class="btn-group">
                      {* Действия над блоком *}
                      {array name='url_vars'}
                      {array_append name='url_vars' key='id' value=$block->id}
                      {if $block->active}
                        <a href="/admin/blocks/deactive/{$block->id}" class="btn btn-icon btn-pause" title="{#sys_deactivate#}"><i class="icon-pause"></i></a>
                        <a href="/admin/blocks/modify/{$block->id}" class="btn btn-icon btn-edit" title="{#sys_edit#}"><i class="icon-edit"></i></a>
                        {else}
                        <a href="/admin/blocks/active/{$block->id}" class="btn btn-icon btn-play" title="{#sys_activate#}"><i class="icon-play"></i></a>
                        <a href="/admin/blocks/modify/{$block->id}" class="btn btn-icon btn-edit" title="{#sys_edit#}"><i class="icon-edit"></i></a>
                        <a href="/admin/blocks/delete/{$block->id}/{$block->weight}/{$block->position}" class="btn btn-icon btn-delete" title="{#sys_delete#}"><i class="icon-trash"></i></a>
                        {/if}
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


  <hr><br>
  {******************************ПОЦЕНТРУ****************************************}

  <div class="row-fluid">		
    <div class="box span12">
      <div class="box-header well" data-original-title>
        <h2><i class="icon-layout"></i> Установленные блоки по центру</h2>
      </div>
      <div class="box-content">
        <form action="/admin/blocks/group_operation">
          <div class="btn-toolbar batch-actions-buttons">
            <div class="btn-group">
              <a href='/admin/blocks/install/c' class='btn btn-success'><i class="icon icon-plus-sign icon-white"></i> {#sys_add#}</a>
              <a href='#' rel="activate" class="btn btn-default" title="{#sys_activate#}"><i class="icon-play"></i> {#sys_activate#}</a>
              <a href='#' rel="deactivate" class="btn btn-default" title="{#sys_deactivate#}"><i class="icon-pause"></i> {#sys_deactivate#}</a>
            </div>

            <div class="btn-group delete-group">
              <a class="btn btn-danger batch-delete-button table_actions_link" rel="delete" href="#"><i class="icon-trash icon-white"></i> {#sys_delete#}</a>
            </div>
          </div>
          <table class="table table-striped table-bordered bootstrap-datatable" cellSpacing="1" cellPadding="4" width="100%">
            <colgroup>
              <col width='10'>
              <col width='200'>
              <col width='200'>
              <col width='*'>
              <col width='50'>
              <col width='90'>
            </colgroup>

            <thead>
              <tr align="middle">
                <th style="width: 25px;">
                  <input type="checkbox" name="entities[]" class="td_entiies_group" value="">
                </th>
                <th class="head" nowrap>Отображаемое имя</th>
                <th class="head">Имя блока</th>
                <th class="head">Маска</th>
                <th class="head">Порядок</th>
                <th class="head">Действия</th>
              </tr>
            </thead>
            <tbody>
              {foreach item=block from=$blocks_list_c name=fblock_c}
                {cycle name="instblc" values="even,odd" assign="class" print=false}

                <tr align="middle">
                  <th style="width: 20px;">
                    <input type="checkbox" name="entities[]" class="td_entities" value="{$block->id}">
                  </th>
                  <td class="{$class}" align="left">{$block->displayname|escape}</td>
                  <td class="{$class}" align="left">{$block->name|escape}</td>
                  <td class="{$class}" align="left">{$block->pattern|escape}</td>

                  {* Weight *}
                  <td class="{$class}" align="center" nowrap style="width: 90px;">
                    <div class="btn-group" style="text-align: center;">
                      {if !$smarty.foreach.fblock_c.first}
                        <a href="/admin/blocks/weight_up/{$block->id}" class="btn btn-icon btn-up" title="{#sys_up#}"><i class="icon-arrow-up"></i></a>
                      {/if}

                      {if !$smarty.foreach.fblock_c.last}
                        <a href="/admin/blocks/weight_down/{$block->id}" class="btn btn-icon btn-down" title="{#sys_down#}"><i class="icon-arrow-down"></i></a>
                      {/if}
                    </div>
                  </td>

                  <td class="{$class}" align="center" nowrap style="width: 120px;">
                    <div class="btn-group">
                      {* Действия над блоком *}
                      {array name='url_vars'}
                      {array_append name='url_vars' key='id' value=$block->id}
                      {if $block->active}
                        <a href="/admin/blocks/deactive/{$block->id}" class="btn btn-icon btn-pause" title="{#sys_deactivate#}"><i class="icon-pause"></i></a>
                        <a href="/admin/blocks/modify/{$block->id}" class="btn btn-icon btn-edit" title="{#sys_edit#}"><i class="icon-edit"></i></a>
                        {else}
                        <a href="/admin/blocks/active/{$block->id}" class="btn btn-icon btn-play" title="{#sys_activate#}"><i class="icon-play"></i></a>
                        <a href="/admin/blocks/modify/{$block->id}" class="btn btn-icon btn-edit" title="{#sys_edit#}"><i class="icon-edit"></i></a>
                        <a href="/admin/blocks/delete/{$block->id}/{$block->weight}/{$block->position}" class="btn btn-icon btn-delete" title="{#sys_delete#}"><i class="icon-trash"></i></a>
                        {/if}
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