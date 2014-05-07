{strip}
{******************************СЛЕВА*******************************************}
  <table class="admin_table" cellSpacing="1" cellPadding="4" width="100%">
    <colgroup>
      <col width="20%">
      <col width="10%">
      <col width="30%">
      <col width="5%">
      <col width="5%">
    </colgroup>

    <thead>
      <tr align="middle">
        <th colspan="6">Установленные блоки слева</th>
      </tr>

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
        <td colspan="6">[<a href='/blocks/install/l'>Добавить блок</a>]</td>
      </tr>
    </tfoot>

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
            <a href="/blocks/weight_up/{$block.block_weight}/{$block.block_position}" class="btn-icon btn-up" title="{#sys_up#}"></a>
          {/if}
          {if !$smarty.foreach.fblock_l.first && !$smarty.foreach.fblock_l.last}
            &nbsp;
          {/if}
          {if !$smarty.foreach.fblock_l.last}
            <a href="/blocks/weight_down/{$block.block_weight}/{$block.block_position}" class="btn-icon btn-down" title="{#sys_down#}"></a>
          {/if}
        </td>

        <td class="{$class}" align="center" nowrap>
          {* Действия над блоком *}
          {array name='url_vars'}
          {array_append name='url_vars' key='id' value=$block.id}
          {if $block.block_active}
            <a href="/blocks/deactive/{$block.id}" class="btn-icon btn-pause" title="{#sys_disabled#}"></a>&nbsp;
            <a href="/blocks/modify/{$block.id}" class="btn-icon btn-edit" title="{#sys_edit#}"></a>&nbsp;
          {else}
            <a href="/blocks/active/{$block.id}" class="btn-icon btn-play" title="{#sys_enabled#}"></a>
            <a href="/blocks/modify/{$block.id}" class="btn-icon btn-edit" title="{#sys_edit#}"></a>
            <a href="/blocks/delete/{$block.id}/{$block.block_weight}/{$block.block_position}" onclick="return confirm('{#sys_delete#}?')" class="btn-icon btn-delete" title="{#sys_delete#}"></a>&nbsp;
          {/if}

        </td>
      </tr>
    {/foreach}
    </tbody>
  </table>
<hr><br>
{******************************СПРАВА*******************************************}

<table class="admin_table" cellSpacing="1" cellPadding="4" width="100%">
    <colgroup>
      <col width="20%">
      <col width="10%">
      <col width="30%">
      <col width="5%">
      <col width="5%">
    </colgroup>

    <thead>
      <tr align="middle">
        <th colspan="6">Установленные блоки справа</th>
      </tr>

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
        <td colspan="6">[<a href='/blocks/install/r'>Добавить блок</a>]</td>
      </tr>
    </tfoot>

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
            <a href="/blocks/weight_up/{$block.block_weight}/{$block.block_position}" class="btn-icon btn-up" title="{#sys_up#}"></a>
          {/if}
          {if !$smarty.foreach.fblock_r.first && !$smarty.foreach.fblock_r.last}
            &nbsp;
          {/if}
          {if !$smarty.foreach.fblock_r.last}
            <a href="/blocks/weight_down/{$block.block_weight}/{$block.block_position}" class="btn-icon btn-down" title="{#sys_down#}"></a>
          {/if}
        </td>

        <td class="{$class}" align="center" nowrap>
          {* Действия над блоком *}
          {array name='url_vars'}
          {array_append name='url_vars' key='id' value=$block.id}
          {if $block.block_active}
            <a href="/blocks/deactive/{$block.id}" class="btn-icon btn-pause" title="{#sys_disabled#}"></a>&nbsp;
            <a href="/blocks/modify/{$block.id}" class="btn-icon btn-edit" title="{#sys_edit#}"></a>&nbsp;
          {else}
            <a href="/blocks/active/{$block.id}" class="btn-icon btn-play" title="{#sys_enabled#}"></a>
            <a href="/blocks/modify/{$block.id}" class="btn-icon btn-edit" title="{#sys_edit#}"></a>
            <a href="/blocks/delete/{$block.id}/{$block.block_weight}/{$block.block_position}" onclick="return confirm('{#sys_delete#}?')" class="btn-icon btn-delete" title="{#sys_delete#}"></a>&nbsp;
          {/if}

        </td>
      </tr>
    {/foreach}
    </tbody>
  </table>
<hr><br>
{******************************СВЕРХУ*******************************************}

<table class="admin_table" cellSpacing="1" cellPadding="4" width="100%">
    <colgroup>
      <col width="20%">
      <col width="10%">
      <col width="30%">
      <col width="5%">
      <col width="5%">
    </colgroup>

    <thead>
      <tr align="middle">
        <th colspan="6">Установленные блоки сверху</th>
      </tr>

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
        <td colspan="6">[<a href='/blocks/install/t'>Добавить блок</a>]</td>
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
            <a href="/blocks/weight_up/{$block.block_weight}/{$block.block_position}" class="btn-icon btn-up" title="{#sys_up#}"></a>
          {/if}
          {if !$smarty.foreach.fblock_t.first && !$smarty.foreach.fblock_t.last}
            &nbsp;
          {/if}
          {if !$smarty.foreach.fblock_t.last}
            <a href="/blocks/weight_down/{$block.block_weight}/{$block.block_position}" class="btn-icon btn-down" title="{#sys_down#}"></a>
          {/if}
        </td>

        <td class="{$class}" align="center" nowrap>
          {* Действия над блоком *}
          {array name='url_vars'}
          {array_append name='url_vars' key='id' value=$block.id}
          {if $block.block_active}
            <a href="/blocks/deactive/{$block.id}" class="btn-icon btn-pause" title="{#sys_disabled#}"></a>&nbsp;
            <a href="/blocks/modify/{$block.id}" class="btn-icon btn-edit" title="{#sys_edit#}"></a>&nbsp;
          {else}
            <a href="/blocks/active/{$block.id}" class="btn-icon btn-play" title="{#sys_enabled#}"></a>
            <a href="/blocks/modify/{$block.id}" class="btn-icon btn-edit" title="{#sys_edit#}"></a>
            <a href="/blocks/delete/{$block.id}/{$block.block_weight}/{$block.block_position}" onclick="return confirm('{#sys_delete#}?')" class="btn-icon btn-delete" title="{#sys_delete#}"></a>&nbsp;
          {/if}

        </td>
      </tr>
    {/foreach}
    </tbody>
  </table>
<hr><br>

{******************************СНИЗУ*******************************************}

<table class="admin_table" cellSpacing="1" cellPadding="4" width="100%">
    <colgroup>
      <col width="20%">
      <col width="10%">
      <col width="30%">
      <col width="5%">
      <col width="5%">
    </colgroup>

    <thead>
      <tr align="middle">
        <th colspan="6">Установленные блоки снизу</th>
      </tr>

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
        <td colspan="6">[<a href='/blocks/install/b'>Добавить блок</a>]</td>
      </tr>
    </tfoot>

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
            <a href="/blocks/weight_up/{$block.block_weight}/{$block.block_position}" class="btn-icon btn-up" title="{#sys_up#}"></a>
          {/if}
          {if !$smarty.foreach.fblock_b.first && !$smarty.foreach.fblock_b.last}
            &nbsp;
          {/if}
          {if !$smarty.foreach.fblock_b.last}
            <a href="/blocks/weight_down/{$block.block_weight}/{$block.block_position}" class="btn-icon btn-down" title="{#sys_down#}"></a>
          {/if}
        </td>

        <td class="{$class}" align="center" nowrap>
          {* Действия над блоком *}
          {array name='url_vars'}
          {array_append name='url_vars' key='id' value=$block.id}
          {if $block.block_active}
            <a href="/blocks/deactive/{$block.id}" class="btn-icon btn-pause" title="{#sys_disabled#}"></a>&nbsp;
            <a href="/blocks/modify/{$block.id}" class="btn-icon btn-edit" title="{#sys_edit#}"></a>&nbsp;
          {else}
            <a href="/blocks/active/{$block.id}" class="btn-icon btn-play" title="{#sys_enabled#}"></a>
            <a href="/blocks/modify/{$block.id}" class="btn-icon btn-edit" title="{#sys_edit#}"></a>
            <a href="/blocks/delete/{$block.id}/{$block.block_weight}/{$block.block_position}" onclick="return confirm('{#sys_delete#}?')" class="btn-icon btn-delete" title="{#sys_delete#}"></a>&nbsp;
          {/if}

        </td>
      </tr>
    {/foreach}
    </tbody>
  </table>
<hr><br>
{******************************ПОЦЕНТРУ****************************************}

<table class="admin_table" cellSpacing="1" cellPadding="4" width="100%">
    <colgroup>
      <col width="20%">
      <col width="10%">
      <col width="30%">
      <col width="5%">
      <col width="5%">
    </colgroup>

    <thead>
      <tr align="middle">
        <th colspan="6">Установленные блоки поцентру</th>
      </tr>

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
        <td colspan="6">[<a href='/blocks/install/c'>Добавить блок</a>]</td>
      </tr>
    </tfoot>

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
            <a href="/blocks/weight_up/{$block.block_weight}/{$block.block_position}" class="btn-icon btn-up" title="{#sys_up#}"></a>
          {/if}
          {if !$smarty.foreach.fblock_c.first && !$smarty.foreach.fblock_c.last}
            &nbsp;
          {/if}
          {if !$smarty.foreach.fblock_c.last}
            <a href="/blocks/weight_down/{$block.block_weight}/{$block.block_position}" class="btn-icon btn-down" title="{#sys_down#}"></a>
          {/if}
        </td>

        <td class="{$class}" align="center" nowrap>
          {* Действия над блоком *}
          {array name='url_vars'}
          {array_append name='url_vars' key='id' value=$block.id}
          {if $block.block_active}
            <a href="/blocks/deactive/{$block.id}" class="btn-icon btn-pause" title="{#sys_disabled#}"></a>&nbsp;
            <a href="/blocks/modify/{$block.id}" class="btn-icon btn-edit" title="{#sys_edit#}"></a>&nbsp;
          {else}
            <a href="/blocks/active/{$block.id}" class="btn-icon btn-play" title="{#sys_enabled#}"></a>
            <a href="/blocks/modify/{$block.id}" class="btn-icon btn-edit" title="{#sys_edit#}"></a>
            <a href="/blocks/delete/{$block.id}/{$block.block_weight}/{$block.block_position}" onclick="return confirm('{#sys_delete#}?')" class="btn-icon btn-delete" title="{#sys_delete#}"></a>&nbsp;
          {/if}

        </td>
      </tr>
    {/foreach}
    </tbody>
  </table>


{/strip}