<h2>Групы пользователей</h2>
<table border='0' width='100%' cellspacing=0 cellpadding=2>
  <thead style="text-align: left; font-size: 12px; background-color: #64BC51; color: #fff;">
  <tr>
    <th>
      ID
    </th>
    <th>
      Логин
    </th>
    <th>
      Имя(Ф.И.О)
    </th>
    <th>
      E-mail
    </th>
    <th>
      Группа
    </th>
    <th>
      Дата Регистрации
    </th>
    <th>
      Последний вход в стистему
    </th>
    <th>
      Действия
    </th>
   </tr>
  </thead>
  <tbody>
   {foreach from=$users item=user}
    {cycle name="users" values="even,odd" assign="class" print=false}
    <tr class='{$class}'>
      <td>
        {$user.id}
      </td>
      
      <td>
        {$user.login}
      </td>
      
      <td>
        {$user.displayname}
      </td>
     
      <td>
        {$user.mail}
      </td>
     
      <td>
        {$groups[$user.gid]}
      </td>
      
      <td>
        {$user.addtime|date_format:'%d.%m.%Y'}
      </td>
      
      <td>
        {$user.last_visit|date_format:'%d.%m.%Y %H:%M'}
      </td>
      
      <td>
        {if $user.active}
          <a href='/users/activation/{$user.id}' onclick="return confirm('Деактивировать?')">Disabled</a>&nbsp;|&nbsp;
        {else}
          <a href='/users/activation/{$user.id}' onclick="return confirm('Активировать?')">Enabled</a>&nbsp;|&nbsp;
        {/if}
        <a href='/users/manage/{$user.id}'>Edit</a>&nbsp;|&nbsp;
        <a href='/users/delete/{$user.id}' onclick="return confirm('Удалить элемент?')">Delete</a>
      </td>
    </tr>
   {/foreach}
  </tbody>
</table>
<div style="text-align: center;">
  [ <a href='/users/manage'>Добавить</a> ]
</div>