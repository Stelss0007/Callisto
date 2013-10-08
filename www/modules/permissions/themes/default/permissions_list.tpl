<h2>Права доступа груп</h2>
<table border='1' width='100%' cellspacing=0 cellpadding=4>
  <tr>
    <th>
      Группа
    </th>
    <th>
      Елемент
    </th>
    <th>
      Объект
    </th>
    <th>
      Права доступа
    </th>
    <th>
      Поочередность
    </th>
    <th>
      Действия
    </th>
   </tr>
  {foreach from=$group_permission item=permission}
    {cycle name="permsls" values="even,odd" assign="class" print=false}
    <tr class='{$class}'>
      <td>
        {$group[$permission.gid]}
      </td>
      <td>
        Елемент
      </td>
      <td>
        {$permission.pattern}
      </td>
      <td>
        {$levels[$permission.level]}
      </td>
      <td>
        <a href='/permissions/permission_weight_up/{$permission.weight}'>UP</a>
        &nbsp;
        <a href='/permissions/permission_weight_down/{$permission.weight}'>DOWN</a>
      </td>
      <td>
        <a href='/permissions/manage/{$permission.id}'>Edit</a>
        <a href='/permissions/delete/{$permission.id}' onclick="return confirm('Удалить элемент?')">Delete</a>
      </td>
    </tr>
   {/foreach}
</table>
<div style="text-align: center;">
  [ <a href='/permissions/manage'>Добавить</a> ]
</div>