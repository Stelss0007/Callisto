{strip}
<ul>
{foreach from=$menu_list item=menu}
  <li>
    <a href='{$menu.menu_content}'>{$menu.menu_title}</a>
  </li>
{/foreach}
</ul>
{/strip}