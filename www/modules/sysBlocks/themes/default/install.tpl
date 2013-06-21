{strip}
  <table class="outer" cellSpacing="1" cellPadding="4" width="100%">
    <colgroup>
      <col width="20%">
      <col width="10%">
      <col width="50%">
      <col width="10%">
      <col width="10%">
    </colgroup>

    <thead>
      <tr align="middle">
        <th colspan="5">��������� �����</th>
      </tr>

      <tr align="middle">
        <td class="head" nowrap>������������ ���</td>
        <td class="head">��� �����</td>
        <td class="head">��������</td>
        <td class="head">������</td>
        <td class="head">��������</td>
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
          
          {array name='url_vars'}
          {array_append name='url_vars' key='block_name' value=$block.block_name}
          <a href=""><img border="0" src="/files/shared/images/system/info.gif" alt="����������"></a>&nbsp;
          <a href="/sysBlocks/add/{$position}/{$block.block_name}"><img border="0" src="/files/shared/images/system/add.gif" alt="��������"></a>
        </td>
      </tr>
      {/foreach}
    </tbody>

  </table>

{/strip}