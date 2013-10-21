<h2>{#permissions_header#}</h2>
<table border='1' width='100%' cellspacing=0 cellpadding=4>
  <tr>
    <th>
      {#permissions_groups_title#}
    </th>
    <th>
      {#permissions_element#}
    </th>
    <th>
      {#permissions_object#}
    </th>
    <th>
      {#permissions_access_type#}
    </th>
    <th>
      {#permissions_order#}
    </th>
    <th>
     {#permissions_actions#}
    </th>
   </tr>
  {foreach from=$group_permission item=permission name=permission_}
    {cycle name="permsls" values="even,odd" assign="class" print=false}
    <tr class='{$class}'>
      <td>
        {$group[$permission.gid]}
      </td>
      <td>
        {#permissions_element#}
      </td>
      <td>
        {$permission.pattern}
      </td>
      <td>
        {$levels[$permission.level]}
      </td>
      <td style="text-align: center;">
          {if !$smarty.foreach.permission_.first}
            <a href="/menu/weight_up/{$permission.user_group_permission_weight}"><img border="0" src="/files/shared/images/system/up.gif"></a>
          {/if}
          {if !$smarty.foreach.permission_.first && !$smarty.foreach.permission_.last}
            &nbsp;
          {/if}
          {if !$smarty.foreach.permission_.last}
            <a href="/menu/weight_down/{$permission.user_group_permission_weight}"><img border="0" src="/files/shared/images/system/down.gif"></a>
          {/if}
      </td>
      <td>
        <a href='/permissions/manage/{$permission.id}' title="{#sys_edit#}"><img alt="{#sys_edit#}" src="/files/shared/images/system/edit.gif"></a>
        <a href='/permissions/delete/{$permission.id}' title="{#sys_delete#}" onclick="return confirm('{#sys_confirm_delete#}');"><img alt="{#sys_delete#}" src="/files/shared/images/system/del.gif"></a>
      </td>
    </tr>
   {/foreach}
</table>
<div style="text-align: center;">
  [ <a href='/permissions/manage'>Добавить</a> ]
</div>