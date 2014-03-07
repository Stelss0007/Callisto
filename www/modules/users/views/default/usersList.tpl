<h2>Групы пользователей</h2>
<table  width='100%' cellspacing=0 cellpadding=2 class="admin_table">
  <thead style="">
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
      <th style="width: 100px;">
        Действия
      </th>
     </tr>
  </thead>
  <tbody>
   {foreach from=$users_list item=user}
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
        {$groups_list[$user.gid]}
      </td>
      
      <td>
        {$user.addtime|date_format:'%d.%m.%Y'}
      </td>
      
      <td>
        {$user.last_visit|date_format:'%d.%m.%Y %H:%M'}
      </td>
      
      <td>
        {if $user.active}
          <a href='/users/activation/{$user.id}' onclick="return confirm('{#user_disabled#}?')" title='{#user_disabled#}' class="btn-icon btn-pause"></a>
        {else}
          <a href='/users/activation/{$user.id}' onclick="return confirm('{#user_enabled#}?')" title='{#user_enabled#}' class="btn-icon btn-play"></a>
        {/if}
        <a href='/users/manage/{$user.id}' title='{#user_edit#}' class="btn-icon btn-edit"></a>
        <a href='/users/delete/{$user.id}' title='{#user_delete#}' onclick="return confirm({#user_delete#}?')" class="btn-icon btn-delete"></a>
      </td>
    </tr>
   {/foreach}
  </tbody>
</table>
<div style="text-align: center;">
  [ <a href='/users/manage'>Добавить</a> ]
</div>