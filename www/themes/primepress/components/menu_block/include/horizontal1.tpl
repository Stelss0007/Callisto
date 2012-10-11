<div class="horizontal1">
<ul class="menu">
{foreach item=item from=$items_list name=menu_items}
{* Формируем масив переменные для урла *}
{array name='url_vars'}
{array_append name='url_vars' key='id' value=$item.id}   
{if $item.id == $cur_item_id}
<li class="current_page_item"><a href="{$item.content}">{$item.displayname|escape}</a></li>
{else}
<li><a href="{$item.content}">{$item.displayname|escape}</a></li>
{/if}
{/foreach}
</ul>
</div>