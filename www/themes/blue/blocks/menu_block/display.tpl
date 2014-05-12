{strip}
<ul class="list2 left-menu">
    {foreach from=$menu_list item=menu}
        <li><em><img src="/themes/blue/img/arrow2.png" alt=""></em><p><a href="{$menu.menu_content}">{$menu.menu_title}</a></p></li>
    {/foreach}
</ul> 
{/strip}