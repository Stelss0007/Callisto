<h2>����� ������� ����</h2>
<table border='1' width='100%' cellspacing=0 cellpadding=4>
  <tr>
    <th>
      ������
    </th>
    <th>
      �������
    </th>
    <th>
      ������
    </th>
    <th>
      ����� �������
    </th>
    <th>
      �������������
    </th>
    <th>
      ��������
    </th>
   </tr>
  {foreach from=$group_permission item=permission}
    {cycle name="permsls" values="even,odd" assign="class" print=false}
    <tr class='{$class}'>
      <td>
        {$group[$permission.gid]}
      </td>
      <td>
        �������
      </td>
      <td>
        {$permission.pattern}
      </td>
      <td>
        {$levels[$permission.level]}
      </td>
      <td>
        <a href='/sysPermissions/permission_weight_up/{$permission.weight}'>UP</a>
        &nbsp;
        <a href='/sysPermissions/permission_weight_down/{$permission.weight}'>DOWN</a>
      </td>
      <td>
        <a href='/sysPermissions/manage/{$permission.id}'>Edit</a>
        <a href='/sysPermissions/delete/{$permission.id}' onclick="return confirm('������� �������?')">Delete</a>
      </td>
    </tr>
   {/foreach}
</table>
<div style="text-align: center;">
  [ <a href='/sysPermissions/manage'>��������</a> ]
</div>