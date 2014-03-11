{strip}
  {******************************СЛЕВА*******************************************}
  <div class="row-fluid">		
    <div class="box span12">
      <div class="box-header well" data-original-title>
        <h2><i class="icon-user"></i> Установленные блоки слева</h2>
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
              <col width="30%">
              <col width="5%">
              <col width="6%">
            </colgroup>

            <thead>
              <tr align="middle">
                <td class="head" nowrap>Отображаемое имя</td>
                <td class="head">Имя блока</td>
                <td class="head">Маска</td>
                <td class="head">Порядок</td>
                <td class="head" style="width: 90px;">Действия</td>
              </tr>
            </thead>
           
            <tbody>
              {foreach item=block from=$blocks_list_l name=fblock_l}
                {cycle name="instblc" values="even,odd" assign="class" print=false}

                <tr align="middle">
                  <td class="{$class}" align="left">{$block.block_displayname|escape}</td>
                  <td class="{$class}" align="left">{$block.block_name|escape}</td>
                  <td class="{$class}" align="left">{$block.block_pattern|escape}</td>

                  {* Weight *}
                  <td class="{$class}" align="center" nowrap>
                    {if !$smarty.foreach.fblock_l.first}
                      <a href="/admin/blocks/weight_up/{$block.block_weight}/{$block.block_position}" class="btn-icon btn-up" title="{#sys_up#}"></a>
                    {/if}
                    {if !$smarty.foreach.fblock_l.first && !$smarty.foreach.fblock_l.last}
                      &nbsp;
                    {/if}
                    {if !$smarty.foreach.fblock_l.last}
                      <a href="/admin/blocks/weight_down/{$block.block_weight}/{$block.block_position}" class="btn-icon btn-down" title="{#sys_down#}"></a>
                    {/if}
                  </td>

                  <td class="{$class}" align="center" nowrap>
                     <div class="btn-group">
                        {* Действия над блоком *}
                        {array name='url_vars'}
                        {array_append name='url_vars' key='id' value=$block.id}
                        {if $block.block_active}
                          <a href="/admin/blocks/deactive/{$block.id}" class="btn btn-icon btn-pause" title="{#sys_disabled#}"><i class="icon-pause"></i></a>
                          <a href="/admin/blocks/modify/{$block.id}" class="btn btn-icon btn-edit" title="{#sys_edit#}"><i class="icon-edit"></i></a>
                        {else}
                          <a href="/admin/blocks/active/{$block.id}" class="btn btn-icon btn-play" title="{#sys_enabled#}"><i class="icon-play"></i></a>
                          <a href="/admin/blocks/modify/{$block.id}" class="btn btn-icon btn-edit" title="{#sys_edit#}"><i class="icon-edit"></i></a>
                          <a href="/admin/blocks/delete/{$block.id}/{$block.block_weight}/{$block.block_position}" class="btn btn-icon btn-delete" title="{#sys_delete#}"><i class="icon-trash"></i></a>
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
        <h2><i class="icon-user"></i> Установленные блоки справа</h2>
      </div>
      <div class="box-content">
        <form action="/admin/blocks/group_operation">
          <div class="btn-toolbar batch-actions-buttons">
            <div class="btn-group">
              <a href='/admin/blocks/install/r' class='btn btn-success'><i class="icon icon-plus-sign icon-white"></i> {#sys_add#}</a>
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
              <col width="30%">
              <col width="5%">
              <col width="5%">
            </colgroup>

            <thead>
              <tr align="middle">
                <td class="head" nowrap>Отображаемое имя</td>
                <td class="head">Имя блока</td>
                <td class="head">Маска</td>
                <td class="head">Порядок</td>
                <td class="head">Действия</td>
              </tr>
            </thead>
            <tbody>
              {foreach item=block from=$blocks_list_r name=fblock_r}
                {cycle name="instblc" values="even,odd" assign="class" print=false}

                <tr align="middle">
                  <td class="{$class}" align="left">{$block.block_displayname|escape}</td>
                  <td class="{$class}" align="left">{$block.block_name|escape}</td>
                  <td class="{$class}" align="left">{$block.block_pattern|escape}</td>

                  {* Weight *}
                  <td class="{$class}" align="center" nowrap>
                    {if !$smarty.foreach.fblock_r.first}
                      <a href="/admin/blocks/weight_up/{$block.block_weight}/{$block.block_position}" class="btn-icon btn-up" title="{#sys_up#}"></a>
                    {/if}
                    {if !$smarty.foreach.fblock_r.first && !$smarty.foreach.fblock_r.last}
                      &nbsp;
                    {/if}
                    {if !$smarty.foreach.fblock_r.last}
                      <a href="/admin/blocks/weight_down/{$block.block_weight}/{$block.block_position}" class="btn-icon btn-down" title="{#sys_down#}"></a>
                    {/if}
                  </td>

                  <td class="{$class}" align="center" nowrap>
                    {* Действия над блоком *}
                    {array name='url_vars'}
                    {array_append name='url_vars' key='id' value=$block.id}
                    {if $block.block_active}
                      <a href="/admin/blocks/deactive/{$block.id}" class="btn-icon btn-pause" title="{#sys_disabled#}"></a>&nbsp;
                      <a href="/admin/blocks/modify/{$block.id}" class="btn-icon btn-edit" title="{#sys_edit#}"></a>&nbsp;
                    {else}
                      <a href="/admin/blocks/active/{$block.id}" class="btn-icon btn-play" title="{#sys_enabled#}"></a>
                      <a href="/admin/blocks/modify/{$block.id}" class="btn-icon btn-edit" title="{#sys_edit#}"></a>
                      <a href="/blocks/delete/{$block.id}/{$block.block_weight}/{$block.block_position}" onclick="return confirm('{#sys_delete#}?')" class="btn-icon btn-delete" title="{#sys_delete#}"></a>&nbsp;
                    {/if}

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
        <h2><i class="icon-user"></i> Установленные блоки сверху</h2>
      </div>
      <div class="box-content">
        <form action="/admin/blocks/group_operation">
          <div class="btn-toolbar batch-actions-buttons">
            <div class="btn-group">
              <a href='/admin/blocks/install/t' class='btn btn-success'><i class="icon icon-plus-sign icon-white"></i> {#sys_add#}</a>
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
              <col width="30%">
              <col width="5%">
              <col width="5%">
            </colgroup>

            <thead>
              <tr align="middle">
                <td class="head" nowrap>Отображаемое имя</td>
                <td class="head">Имя блока</td>
                <td class="head">Маска</td>
                <td class="head">Порядок</td>
                <td class="head">Действия</td>
              </tr>
            </thead>
            <tfoot>
              <tr align="middle">
                <td colspan="6">[<a href='/admin/blocks/install/t'>Добавить блок</a>]</td>
              </tr>
            </tfoot>

            <tbody>
              {foreach item=block from=$blocks_list_t name=fblock_t}
                {cycle name="instblc" values="even,odd" assign="class" print=false}

                <tr align="middle">
                  <td class="{$class}" align="left">{$block.block_displayname|escape}</td>
                  <td class="{$class}" align="left">{$block.block_name|escape}</td>
                  <td class="{$class}" align="left">{$block.block_pattern|escape}</td>

                  {* Weight *}
                  <td class="{$class}" align="center" nowrap>
                    {if !$smarty.foreach.fblock_t.first}
                      <a href="/admin/blocks/weight_up/{$block.block_weight}/{$block.block_position}" class="btn-icon btn-up" title="{#sys_up#}"></a>
                    {/if}
                    {if !$smarty.foreach.fblock_t.first && !$smarty.foreach.fblock_t.last}
                      &nbsp;
                    {/if}
                    {if !$smarty.foreach.fblock_t.last}
                      <a href="/admin/blocks/weight_down/{$block.block_weight}/{$block.block_position}" class="btn-icon btn-down" title="{#sys_down#}"></a>
                    {/if}
                  </td>

                  <td class="{$class}" align="center" nowrap>
                    {* Действия над блоком *}
                    {array name='url_vars'}
                    {array_append name='url_vars' key='id' value=$block.id}
                    {if $block.block_active}
                      <a href="/admin/blocks/deactive/{$block.id}" class="btn-icon btn-pause" title="{#sys_disabled#}"></a>&nbsp;
                      <a href="/admin/blocks/modify/{$block.id}" class="btn-icon btn-edit" title="{#sys_edit#}"></a>&nbsp;
                    {else}
                      <a href="/admin/blocks/active/{$block.id}" class="btn-icon btn-play" title="{#sys_enabled#}"></a>
                      <a href="/admin/blocks/modify/{$block.id}" class="btn-icon btn-edit" title="{#sys_edit#}"></a>
                      <a href="/admin/blocks/delete/{$block.id}/{$block.block_weight}/{$block.block_position}" onclick="return confirm('{#sys_delete#}?')" class="btn-icon btn-delete" title="{#sys_delete#}"></a>&nbsp;
                    {/if}

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
        <h2><i class="icon-user"></i> Установленные блоки снизу</h2>
      </div>
      <div class="box-content">
        <form action="/admin/blocks/group_operation">
          <div class="btn-toolbar batch-actions-buttons">
            <div class="btn-group">
              <a href='/admin/blocks/install/b' class='btn btn-success'><i class="icon icon-plus-sign icon-white"></i> {#sys_add#}</a>
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
              <col width="30%">
              <col width="5%">
              <col width="5%">
            </colgroup>

            <thead>
              <tr align="middle">
                <td class="head" nowrap>Отображаемое имя</td>
                <td class="head">Имя блока</td>
                <td class="head">Маска</td>
                <td class="head">Порядок</td>
                <td class="head">Действия</td>
              </tr>
            </thead>
           
            <tbody>
              {foreach item=block from=$blocks_list_b name=fblock_b}
                {cycle name="instblc" values="even,odd" assign="class" print=false}

                <tr align="middle">
                  <td class="{$class}" align="left">{$block.block_displayname|escape}</td>
                  <td class="{$class}" align="left">{$block.block_name|escape}</td>
                  <td class="{$class}" align="left">{$block.block_pattern|escape}</td>

                  {* Weight *}
                  <td class="{$class}" align="center" nowrap>
                    {if !$smarty.foreach.fblock_b.first}
                      <a href="/admin/blocks/weight_up/{$block.block_weight}/{$block.block_position}" class="btn-icon btn-up" title="{#sys_up#}"></a>
                    {/if}
                    {if !$smarty.foreach.fblock_b.first && !$smarty.foreach.fblock_b.last}
                      &nbsp;
                    {/if}
                    {if !$smarty.foreach.fblock_b.last}
                      <a href="/admin/blocks/weight_down/{$block.block_weight}/{$block.block_position}" class="btn-icon btn-down" title="{#sys_down#}"></a>
                    {/if}
                  </td>

                  <td class="{$class}" align="center" nowrap>
                    {* Действия над блоком *}
                    {array name='url_vars'}
                    {array_append name='url_vars' key='id' value=$block.id}
                    {if $block.block_active}
                      <a href="/admin/blocks/deactive/{$block.id}" class="btn-icon btn-pause" title="{#sys_disabled#}"></a>&nbsp;
                      <a href="/blocks/modify/{$block.id}" class="btn-icon btn-edit" title="{#sys_edit#}"></a>&nbsp;
                    {else}
                      <a href="/admin/blocks/active/{$block.id}" class="btn-icon btn-play" title="{#sys_enabled#}"></a>
                      <a href="/admin/blocks/modify/{$block.id}" class="btn-icon btn-edit" title="{#sys_edit#}"></a>
                      <a href="/admin/blocks/delete/{$block.id}/{$block.block_weight}/{$block.block_position}" onclick="return confirm('{#sys_delete#}?')" class="btn-icon btn-delete" title="{#sys_delete#}"></a>&nbsp;
                    {/if}

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
        <h2><i class="icon-user"></i> Установленные блоки по центру</h2>
      </div>
      <div class="box-content">
        <form action="/admin/blocks/group_operation">
          <div class="btn-toolbar batch-actions-buttons">
            <div class="btn-group">
              <a href='/admin/blocks/install/c' class='btn btn-success'><i class="icon icon-plus-sign icon-white"></i> {#sys_add#}</a>
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
              <col width="30%">
              <col width="5%">
              <col width="5%">
            </colgroup>

            <thead>
               <tr align="middle">
                <td class="head" nowrap>Отображаемое имя</td>
                <td class="head">Имя блока</td>
                <td class="head">Маска</td>
                <td class="head">Порядок</td>
                <td class="head">Действия</td>
              </tr>
            </thead>
            <tbody>
              {foreach item=block from=$blocks_list_c name=fblock_c}
                {cycle name="instblc" values="even,odd" assign="class" print=false}

                <tr align="middle">
                  <td class="{$class}" align="left">{$block.block_displayname|escape}</td>
                  <td class="{$class}" align="left">{$block.block_name|escape}</td>
                  <td class="{$class}" align="left">{$block.block_pattern|escape}</td>

                  {* Weight *}
                  <td class="{$class}" align="center" nowrap>
                    {if !$smarty.foreach.fblock_c.first}
                      <a href="/admin/blocks/weight_up/{$block.block_weight}/{$block.block_position}" class="btn-icon btn-up" title="{#sys_up#}"></a>
                    {/if}
                    {if !$smarty.foreach.fblock_c.first && !$smarty.foreach.fblock_c.last}
                      &nbsp;
                    {/if}
                    {if !$smarty.foreach.fblock_c.last}
                      <a href="/admin/blocks/weight_down/{$block.block_weight}/{$block.block_position}" class="btn-icon btn-down" title="{#sys_down#}"></a>
                    {/if}
                  </td>

                  <td class="{$class}" align="center" nowrap>
                    {* Действия над блоком *}
                    {array name='url_vars'}
                    {array_append name='url_vars' key='id' value=$block.id}
                    {if $block.block_active}
                      <a href="/admin/blocks/deactive/{$block.id}" class="btn-icon btn-pause" title="{#sys_disabled#}"></a>&nbsp;
                      <a href="/admin/blocks/modify/{$block.id}" class="btn-icon btn-edit" title="{#sys_edit#}"></a>&nbsp;
                    {else}
                      <a href="/admin/blocks/active/{$block.id}" class="btn-icon btn-play" title="{#sys_enabled#}"></a>
                      <a href="/admin/blocks/modify/{$block.id}" class="btn-icon btn-edit" title="{#sys_edit#}"></a>
                      <a href="/admin/blocks/delete/{$block.id}/{$block.block_weight}/{$block.block_position}" onclick="return confirm('{#sys_delete#}?')" class="btn-icon btn-delete" title="{#sys_delete#}"></a>&nbsp;
                    {/if}

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