<h2>����</h2>
<table border='1' width='100%' cellspacing=0 cellpadding=4>
  <tr>
    <th>
      ��������
    </th>
    <th>
      ���� (URL)
    </th>
    <th>
      �������
    </th>
    <th>
      ��������
    </th>
   </tr>
   {foreach from=$menus item=menu}
    {cycle name="menu" values="even,odd" assign="class" print=false}
    <tr class='{$class}'>
      <td>
        <a href="/menu/menu_list/{$menu.id}">{$menu.title}</a>
      </td>
     
      <td>
        <a href="{$menu.content}">{$menu.content}</a>
      </td>
      <td>
        
      </td>
      <td>
        <a href='/menu/manage/{$menu.id}'>Edit</a>
        <a href='/menu/delete/{$menu.id}' onclick="return confirm('������� �������?')">Delete</a>
      </td>
    </tr>
   {/foreach}
</table>
<div style="text-align: center;">
  [ <a href='/menu/manage'>��������</a> ]
</div>