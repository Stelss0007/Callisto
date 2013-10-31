<h2>{#groups_header#}</h2>
<table border='1' width='100%' cellspacing=0 cellpadding=4>
  <colgroup>
    <col width='*'>
    <col width='*'>
    <col width='70'>
  </colgroup>
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
        <a href='/groups/manage/{$group.id}' title="{#sys_edit#}"><img alt="{#sys_edit#}" src="/public/images/system/edit.gif"></a>
        <a href='/groups/delete/{$group.id}' title="{#sys_delete#}" onclick="return confirm('{#sys_confirm_delete#}');"><img alt="{#sys_delete#}" src="/public/images/system/del.gif"></a>
      </td>
    </tr>
   {/foreach}
</table>
<div style="text-align: center;">
  [ <a href='/groups/manage'>{#groups_add#}</a> ]
</div>