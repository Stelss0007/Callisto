<h2>{#groups_header#}</h2>
<table  width='100%' cellspacing=0 cellpadding=4 class="admin_table">
  <colgroup>
    <col width='*'>
    <col width='*'>
    <col width='70'>
  </colgroup>
  <thead>
    <tr>
      <th>
        {#groups_title#}
      </th>
      <th>
        {#groups_description#}
      </th>
      <th>
        {#groups_actions#}
      </th>
     </tr>
  </thead>
    <tbody>
     {foreach from=$groups_list item=group}
      {cycle name="groups" values="even,odd" assign="class" print=false}
      <tr class='{$class}'>
        <td>
          {$group.group_displayname}
        </td>

        <td>
          {$group.group_description}
        </td>

        <td style="text-align: center;">
          <a href='/groups/manage/{$group.id}' title="{#sys_edit#}" class="btn-icon btn-edit"</a>
          <a href='/groups/delete/{$group.id}' title="{#sys_delete#}" onclick="return confirm('{#sys_confirm_delete#}');" class="btn-icon btn-delete"></a>
        </td>
      </tr>
     {/foreach}
    </tbody>
</table>
<div style="text-align: center;">
  [ <a href='/groups/manage'>{#groups_add#}</a> ]
</div>