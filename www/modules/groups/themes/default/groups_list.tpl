<h2>����� �������������</h2>
<table border='1' width='100%' cellspacing=0 cellpadding=4>
  <tr>
    <th>
      ��� ������
    </th>
    <th>
      ��������
    </th>
    <th>
      ��������
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
        <a href='/groups/manage/{$group.id}'>Edit</a>
        <a href='/groups/delete/{$group.id}' onclick="return confirm('������� �������?')">Delete</a>
      </td>
    </tr>
   {/foreach}
</table>
<div style="text-align: center;">
  [ <a href='/groups/manage'>��������</a> ]
</div>