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
   {foreach from=$menus item=menu name=menu_}
    {cycle name="menu" values="even,odd" assign="class" print=false}
    <tr class='{$class}'>
      <td>
        <a href="/menu/menu_list/{$menu.id}">{$menu.menu_title|escape|tree:$menu.level}{if $menu.menu_subitem_counter > 0}&nbsp;({$menu.menu_subitem_counter}){/if}</a>
      </td>
     
      <td>
        <a href="{$menu.menu_content}">{$menu.menu_content}</a>
      </td>
      <td style="text-align: center;">
        {if !$smarty.foreach.menu_.first}
            <a href="/menu/weight_up/{$menu.menu_weight}/{$menu.menu_parent_id}"><img border="0" src="/public/images/system/up.gif"></a>
        {/if}
        {if !$smarty.foreach.menu_.first && !$smarty.foreach.menu_.last}
          &nbsp;
        {/if}
        {if !$smarty.foreach.menu_.last}
          <a href="/menu/weight_down/{$menu.menu_weight}/{$menu.menu_parent_id}"><img border="0" src="/public/images/system/down.gif"></a>
        {/if}
      </td>
      <td>
        <a href='/menu/modify/{$menu.id}' title="{#sys_edit#}"><img alt="{#sys_edit#}" src="/public/images/system/edit.gif"></a>
        <a href='/menu/delete/{$menu.id}' title="{#sys_delete#}" onclick="return confirm('{#sys_confirm_delete#}');"><img alt="{#sys_delete#}" src="/public/images/system/del.gif"></a>
      </td>
    </tr>
   {/foreach}
  </tbody>
</table>
<div style="text-align: center;">
  [ <a href='/menu/create{if $parent_id}/{$parent_id}{/if}'>Добавить</a> ]
</div>