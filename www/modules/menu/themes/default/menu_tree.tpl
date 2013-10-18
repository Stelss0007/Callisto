<h2>Меню</h2>
<table border='1' width='100%' cellspacing=0 cellpadding=4>
   <colgroup>
    <col width='340'>
    <col width='*'>
    <col width='40'>
    <col width='80'>
  </colgroup>
  <thead>
    <tr>
      <th>
        Название
      </th>
      <th>
        Путь (URL)
      </th>
      <th>
        Порядок
      </th>
      <th>
        Действия
      </th>
   </tr>
  </thead>
  <tbody>
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
        <a href='/menu/delete/{$menu.id}' onclick="return confirm('Удалить элемент?')">Delete</a>
      </td>
    </tr>
   {/foreach}
  </tbody>
</table>
<div style="text-align: center;">
  [ <a href='/menu/create{if $parent_id}/{$parent_id}{/if}'>Добавить</a> ]
</div>