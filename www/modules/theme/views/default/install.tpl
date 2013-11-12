<h2>{#themes_add_header#}</h2>
<table class="admin_table" width='100%' cellspacing=0 cellpadding=4>
  <thead>
  <tr>
    <th>
      {#sys_title#}
    </th>
    <th>
      {#sys_description#}
    </th>
    <th>
      {#sys_author#}
    </th>
    <th>
      {#sys_name#}
    </th>
    <th>
      {#sys_version#}
    </th>
    <th style="width: 85px;">
     {#sys_actions#}
    </th>
   </tr>
  </thead>
  <tbody>
  {foreach from=$themes_list_all item=theme name=theme_}
    {cycle name="permsls" values="even,odd" assign="class" print=false}
    <tr class='{$class}'>
      <td>
        {$theme.title}&nbsp;
      </td>
      <td>
        {$theme.description}&nbsp;
      </td>
      <td>
        {$theme.author}&nbsp;
      </td>
      <td>
        {$theme.name}&nbsp;
      </td>
      <td style="text-align: center;">
        {$theme.version}&nbsp;
      </td>
      <td>
        <a href='/theme/add/{$theme.name}' class="btn-icon btn-upload" title="{#sys_install#}"><span>&nbsp;{#sys_install#}</span></a>
      </td>
    </tr>
   {/foreach}
  </tbody>
</table>