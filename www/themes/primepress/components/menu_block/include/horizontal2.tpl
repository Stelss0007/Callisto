<div class="header_menu_cities">
<ul>
{foreach item=item from=$items_list name=menu_items}
{* ��������� ����� ���������� ��� ���� *}
{array name='url_vars'}
{array_append name='url_vars' key='id' value=$item.id}   
{if  $smarty.foreach.menu_items.last}
<li class="no_padding_border">
{else}
<li>
{/if}
{if $item.id == $cur_item_id}
<span style="text-decoration:underline;">{$item.displayname|escape}</span>
{else}
<a href="{$item.content}">{$item.displayname|escape}</a>
{/if}
</li>
{/foreach}
</ul>
</div>