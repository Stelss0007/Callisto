{strip}
{******************************�����*******************************************}
  <table class="outer" cellSpacing="1" cellPadding="4" width="100%">
    <colgroup>
      <col width="20%">
      <col width="10%">
      <col width="30%">
      <col width="10%">
      <col width="10%">
    </colgroup>

    <thead>
      <tr align="middle">
        <th colspan="6">������������� ����� �����</th>
      </tr>

      <tr align="middle">
        <td class="head" nowrap>������������ ���</td>
        <td class="head">��� �����</td>
        <td class="head">�����</td>
        <td class="head">�������</td>
        <td class="head">��������</td>
      </tr>
    </thead>
    <tfoot>
      <tr align="middle">
        <td colspan="6">[<a href='/blocks/install/l'>�������� ����</a>]</td>
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
            <a href="/blocks/weight_up/{$block.block_weight}/{$block.block_position}"><img border="0" src="/public/images/system/up.gif"></a>
          {/if}
          {if !$smarty.foreach.fblock_l.first && !$smarty.foreach.fblock_l.last}
            &nbsp;
          {/if}
          {if !$smarty.foreach.fblock_l.last}
            <a href="/blocks/weight_down/{$block.block_weight}/{$block.block_position}"><img border="0" src="/public/images/system/down.gif"></a>
          {/if}
        </td>

        <td class="{$class}" align="center" nowrap>
          {* �������� ��� ������ *}
          {array name='url_vars'}
          {array_append name='url_vars' key='id' value=$block.id}
          <a href=""><img border="0" src="/public/images/system/info.gif" alt="����������"></a>&nbsp;
          {if $block.block_active}
            <a href="/blocks/deactive/{$block.id}"><img border="0" src="/public/images/system/deactivate.gif" alt="��������������"></a>&nbsp;
            <a href="/blocks/modify/{$block.id}"><img border="0" src="/public/images/system/edit.gif" alt="�������������"></a>&nbsp;
          {else}
            <a href="/blocks/active/{$block.id}"><img border="0" src="/public/images/system/activate.gif" alt="������������"></a>&nbsp;
            <a href="/blocks/modify/{$block.id}"><img border="0" src="/public/images/system/edit.gif" alt="�������������"></a>&nbsp;
            <a href="/blocks/delete/{$block.id}/{$block.block_weight}/{$block.block_position}" onclick="return confirm('�������?')"><img border="0" src="/public/images/system/del.gif" alt="�������"></a>&nbsp;
          {/if}

        </td>
      </tr>
    {/foreach}
    </tbody>
  </table>
<hr><br>
{******************************������*******************************************}

<table class="outer" cellSpacing="1" cellPadding="4" width="100%">
    <colgroup>
      <col width="20%">
      <col width="10%">
      <col width="30%">
      <col width="10%">
      <col width="10%">
    </colgroup>

    <thead>
      <tr align="middle">
        <th colspan="6">������������� ����� ������</th>
      </tr>

      <tr align="middle">
        <td class="head" nowrap>������������ ���</td>
        <td class="head">��� �����</td>
        <td class="head">�����</td>
        <td class="head">�������</td>
        <td class="head">��������</td>
      </tr>
    </thead>
    <tfoot>
      <tr align="middle">
        <td colspan="6">[<a href='/blocks/install/r'>�������� ����</a>]</td>
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
            <a href="/blocks/weight_up/{$block.block_weight}/{$block.block_position}"><img border="0" src="/public/images/system/up.gif"></a>
          {/if}
          {if !$smarty.foreach.fblock_r.first && !$smarty.foreach.fblock_r.last}
            &nbsp;
          {/if}
          {if !$smarty.foreach.fblock_r.last}
            <a href="/blocks/weight_down/{$block.block_weight}/{$block.block_position}"><img border="0" src="/public/images/system/down.gif"></a>
          {/if}
        </td>

        <td class="{$class}" align="center" nowrap>
          {* �������� ��� ������ *}
          {array name='url_vars'}
          {array_append name='url_vars' key='id' value=$block.id}
          <a href=""><img border="0" src="/public/images/system/info.gif" alt="����������"></a>&nbsp;
          {if $block.block_active}
            <a href="/blocks/deactive/{$block.id}"><img border="0" src="/public/images/system/deactivate.gif" alt="��������������"></a>&nbsp;
            <a href="/blocks/modify/{$block.id}"><img border="0" src="/public/images/system/edit.gif" alt="�������������"></a>&nbsp;
          {else}
            <a href="/blocks/active/{$block.id}"><img border="0" src="/public/images/system/activate.gif" alt="������������"></a>&nbsp;
            <a href="/blocks/modify/{$block.id}"><img border="0" src="/public/images/system/edit.gif" alt="�������������"></a>&nbsp;
            <a href="/blocks/delete/{$block.id}/{$block.block_weight}/{$block.block_position}" onclick="return confirm('�������?')"><img border="0" src="/public/images/system/del.gif" alt="�������"></a>&nbsp;
          {/if}

        </td>
      </tr>
    {/foreach}
    </tbody>
  </table>
<hr><br>
{******************************������*******************************************}

<table class="outer" cellSpacing="1" cellPadding="4" width="100%">
    <colgroup>
      <col width="20%">
      <col width="10%">
      <col width="30%">
      <col width="10%">
      <col width="10%">
    </colgroup>

    <thead>
      <tr align="middle">
        <th colspan="6">������������� ����� ������</th>
      </tr>

      <tr align="middle">
        <td class="head" nowrap>������������ ���</td>
        <td class="head">��� �����</td>
        <td class="head">�����</td>
        <td class="head">�������</td>
        <td class="head">��������</td>
      </tr>
    </thead>
    <tfoot>
      <tr align="middle">
        <td colspan="6">[<a href='/blocks/install/t'>�������� ����</a>]</td>
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
            <a href="/blocks/weight_up/{$block.block_weight}/{$block.block_position}"><img border="0" src="/public/images/system/up.gif"></a>
          {/if}
          {if !$smarty.foreach.fblock_t.first && !$smarty.foreach.fblock_t.last}
            &nbsp;
          {/if}
          {if !$smarty.foreach.fblock_t.last}
            <a href="/blocks/weight_down/{$block.block_weight}/{$block.block_position}"><img border="0" src="/public/images/system/down.gif"></a>
          {/if}
        </td>

        <td class="{$class}" align="center" nowrap>
          {* �������� ��� ������ *}
          {array name='url_vars'}
          {array_append name='url_vars' key='id' value=$block.id}
          <a href=""><img border="0" src="/public/images/system/info.gif" alt="����������"></a>&nbsp;
          {if $block.block_active}
            <a href="/blocks/deactive/{$block.id}"><img border="0" src="/public/images/system/deactivate.gif" alt="��������������"></a>&nbsp;
            <a href="/blocks/modify/{$block.id}"><img border="0" src="/public/images/system/edit.gif" alt="�������������"></a>&nbsp;
          {else}
            <a href="/blocks/active/{$block.id}"><img border="0" src="/public/images/system/activate.gif" alt="������������"></a>&nbsp;
            <a href="/blocks/modify/{$block.id}"><img border="0" src="/public/images/system/edit.gif" alt="�������������"></a>&nbsp;
            <a href="/blocks/delete/{$block.id}/{$block.block_weight}/{$block.block_position}" onclick="return confirm('�������?')"><img border="0" src="/public/images/system/del.gif" alt="�������"></a>&nbsp;
          {/if}

        </td>
      </tr>
    {/foreach}
    </tbody>
  </table>
<hr><br>

{******************************�����*******************************************}

<table class="outer" cellSpacing="1" cellPadding="4" width="100%">
    <colgroup>
      <col width="20%">
      <col width="10%">
      <col width="30%">
      <col width="10%">
      <col width="10%">
    </colgroup>

    <thead>
      <tr align="middle">
        <th colspan="6">������������� ����� �����</th>
      </tr>

      <tr align="middle">
        <td class="head" nowrap>������������ ���</td>
        <td class="head">��� �����</td>
        <td class="head">�����</td>
        <td class="head">�������</td>
        <td class="head">��������</td>
      </tr>
    </thead>
    <tfoot>
      <tr align="middle">
        <td colspan="6">[<a href='/blocks/install/b'>�������� ����</a>]</td>
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
            <a href="/blocks/weight_up/{$block.block_weight}/{$block.block_position}"><img border="0" src="/public/images/system/up.gif"></a>
          {/if}
          {if !$smarty.foreach.fblock_b.first && !$smarty.foreach.fblock_b.last}
            &nbsp;
          {/if}
          {if !$smarty.foreach.fblock_b.last}
            <a href="/blocks/weight_down/{$block.block_weight}/{$block.block_position}"><img border="0" src="/public/images/system/down.gif"></a>
          {/if}
        </td>

        <td class="{$class}" align="center" nowrap>
          {* �������� ��� ������ *}
          {array name='url_vars'}
          {array_append name='url_vars' key='id' value=$block.id}
          <a href=""><img border="0" src="/public/images/system/info.gif" alt="����������"></a>&nbsp;
          {if $block.block_active}
            <a href="/blocks/deactive/{$block.id}"><img border="0" src="/public/images/system/deactivate.gif" alt="��������������"></a>&nbsp;
            <a href="/blocks/modify/{$block.id}"><img border="0" src="/public/images/system/edit.gif" alt="�������������"></a>&nbsp;
          {else}
            <a href="/blocks/active/{$block.id}"><img border="0" src="/public/images/system/activate.gif" alt="������������"></a>&nbsp;
            <a href="/blocks/modify/{$block.id}"><img border="0" src="/public/images/system/edit.gif" alt="�������������"></a>&nbsp;
            <a href="/blocks/delete/{$block.id}/{$block.block_weight}/{$block.block_position}" onclick="return confirm('�������?')"><img border="0" src="/public/images/system/del.gif" alt="�������"></a>&nbsp;
          {/if}

        </td>
      </tr>
    {/foreach}
    </tbody>
  </table>
<hr><br>
{******************************��������****************************************}

<table class="outer" cellSpacing="1" cellPadding="4" width="100%">
    <colgroup>
      <col width="20%">
      <col width="10%">
      <col width="30%">
      <col width="10%">
      <col width="10%">
    </colgroup>

    <thead>
      <tr align="middle">
        <th colspan="6">������������� ����� ��������</th>
      </tr>

      <tr align="middle">
        <td class="head" nowrap>������������ ���</td>
        <td class="head">��� �����</td>
        <td class="head">�����</td>
        <td class="head">�������</td>
        <td class="head">��������</td>
      </tr>
    </thead>
    <tfoot>
      <tr align="middle">
        <td colspan="6">[<a href='/blocks/install/c'>�������� ����</a>]</td>
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
            <a href="/blocks/weight_up/{$block.block_weight}/{$block.block_position}"><img border="0" src="/public/images/system/up.gif"></a>
          {/if}
          {if !$smarty.foreach.fblock_c.first && !$smarty.foreach.fblock_c.last}
            &nbsp;
          {/if}
          {if !$smarty.foreach.fblock_c.last}
            <a href="/blocks/weight_down/{$block.block_weight}/{$block.block_position}"><img border="0" src="/public/images/system/down.gif"></a>
          {/if}
        </td>

        <td class="{$class}" align="center" nowrap>
          {* �������� ��� ������ *}
          {array name='url_vars'}
          {array_append name='url_vars' key='id' value=$block.id}
          <a href=""><img border="0" src="/public/images/system/info.gif" alt="����������"></a>&nbsp;
          {if $block.block_active}
            <a href="/blocks/deactive/{$block.id}"><img border="0" src="/public/images/system/deactivate.gif" alt="��������������"></a>&nbsp;
            <a href="/blocks/modify/{$block.id}"><img border="0" src="/public/images/system/edit.gif" alt="�������������"></a>&nbsp;
          {else}
            <a href="/blocks/active/{$block.id}"><img border="0" src="/public/images/system/activate.gif" alt="������������"></a>&nbsp;
            <a href="/blocks/modify/{$block.id}"><img border="0" src="/public/images/system/edit.gif" alt="�������������"></a>&nbsp;
            <a href="/blocks/delete/{$block.id}/{$block.block_weight}/{$block.block_position}" onclick="return confirm('�������?')"><img border="0" src="/public/images/system/del.gif" alt="�������"></a>&nbsp;
          {/if}

        </td>
      </tr>
    {/foreach}
    </tbody>
  </table>


{/strip}