{strip}
  {foreach from=$menu_list item=menu}
    <a class="usermnuline" href="{$menu->menu_content}">{$menu->menu_title}</a>
  {/foreach}
{/strip}