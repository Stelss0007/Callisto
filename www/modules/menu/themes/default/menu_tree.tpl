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
        <a href="/menu/menu_list/{$menu.id}">{$menu.menu_title|escape|tree:$menu.level}{if $menu.menu_subitem_counter > 0}&nbsp;({$menu.menu_subitem_counter}){/if}</a>
      </td>
     
      <td>
        <a href="{$menu.menu_content}">{$menu.menu_content}</a>
      </td>
      <td>
        
      </td>
      <td>
        <a href='/menu/modify/{$menu.id}'>Edit</a>
        <a href='/menu/delete/{$menu.id}' onclick="return confirm('������� �������?')">Delete</a>
      </td>
    </tr>
   {/foreach}
</table>
<div style="text-align: center;">
  [ <a href='/menu/create{if $parent_id}/{$parent_id}{/if}'>��������</a> ]
</div>