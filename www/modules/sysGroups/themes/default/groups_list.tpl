<h2>Групы пользователей</h2>
<table border='1' width='100%' cellspacing=0 cellpadding=4>
  <tr>
    <th>
      Имя Группы
    </th>
    <th>
      Описание
    </th>
    <th>
      Действия
    </th>
   </tr>
   {foreach from=$groups item=group}
    {cycle name="groups" values="even,odd" assign="class" print=false}
    <tr class='{$class}'>
      <td>
        {$group.group_displayname}
      </td>
     
      <td>
        {$group.group_description}
      </td>
      
      <td>
        <a href='/sysGroups/manage/{$group.id}'>Edit</a>
        <a href='/sysGroups/delete/{$group.id}' onclick="return confirm('Удалить элемент?')">Delete</a>
      </td>
    </tr>
   {/foreach}
</table>
<div style="text-align: center;">
  [ <a href='/sysGroups/manage'>Добавить</a> ]
</div>