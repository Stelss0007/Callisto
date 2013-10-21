<h2>����� �������������</h2>
<table border='1' width='100%' cellspacing=0 cellpadding=2>
  <thead style="">
    <tr>
      <th>
        ID
      </th>
      <th>
        �����
      </th>
      <th>
        ���(�.�.�)
      </th>
      <th>
        E-mail
      </th>
      <th>
        ������
      </th>
      <th>
        ���� �����������
      </th>
      <th>
        ��������� ���� � ��������
      </th>
      <th>
        ��������
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
          <a href='/users/activation/{$user.id}' onclick="return confirm('��������������?')">Disabled</a>&nbsp;|&nbsp;
        {else}
          <a href='/users/activation/{$user.id}' onclick="return confirm('������������?')">Enabled</a>&nbsp;|&nbsp;
        {/if}
        <a href='/users/manage/{$user.id}'>Edit</a>&nbsp;|&nbsp;
        <a href='/users/delete/{$user.id}' onclick="return confirm('������� �������?')">Delete</a>
      </td>
    </tr>
   {/foreach}
  </tbody>
</table>
<div style="text-align: center;">
  [ <a href='/users/manage'>��������</a> ]
</div>