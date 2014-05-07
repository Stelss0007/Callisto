<h2>{#permissions_header#}</h2>
<table class="admin_table" width='100%' cellspacing=0 cellpadding=4>
  <thead>
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
    <th style="width: 85px;">
     {#permissions_actions#}
    </th>
   </tr>
  </thead>
  <tbody>
  {foreach from=$group_permission item=permission name=permission_}
    {cycle name="permsls" values="even,odd" assign="class" print=false}
    <tr class='{$class}'>
      <td>
        {$group[$permission.group_permission_gid]}
      </td>
      <td>
        {#permissions_element#}
      </td>
      <td>
        {$permission.group_permission_pattern}
      </td>
      <td>
        {$levels[$permission.group_permission_level]}
      </td>
      <td style="text-align: center;">
          {if !$smarty.foreach.permission_.first}
            <a href="/menu/weight_up/{$permission.group_permission_weight}" class="btn-icon btn-up" title="{#sys_up#}"></a>
          {/if}
          {if !$smarty.foreach.permission_.first && !$smarty.foreach.permission_.last}
            
          {/if}
          {if !$smarty.foreach.permission_.last}
            <a href="/menu/weight_down/{$permission.group_permission_weight}" class="btn-icon btn-down"  title="{#sys_down#}"></a>
          {/if}
      </td>
      <td>
        <a href='/permissions/manage/{$permission.id}' class="btn-icon btn-edit" title="{#sys_edit#}"></a>
        <a href='/permissions/delete/{$permission.id}' class="btn-icon btn-delete" title="{#sys_delete#}" onclick="return confirm('{#sys_confirm_delete#}');"></a>
      </td>
    </tr>
   {/foreach}
  </tbody>
</table>
<div style="text-align: center;">
  [ <a href='/permissions/manage'>Добавить</a> ]
</div>