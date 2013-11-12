<h2>{#themes_header#}</h2>
<table class="admin_table" width='100%' cellspacing=0 cellpadding=4>
  <thead>
  <tr>
    <th style="width: 30px;"></th>
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
        {if $theme.active != '1'}
          <a href='/theme/activate/{$theme.id}' class="btn-icon btn-star-o" title="{#sys_activate#}"></a>
        {else}
          <span class="btn-icon btn-star" style="color: #E57C00; text-shadow: 1px 1px 1px #ccc;"></span>
        {/if}
        &nbsp;
      </td>
      <td>
        {$theme.theme_title}&nbsp;
      </td>
      <td>
        {$theme.theme_description}&nbsp;
      </td>
      <td>
        {$theme.theme_author}&nbsp;
      </td>
      <td>
        {$theme.theme_name}&nbsp;
      </td>
      <td style="text-align: center;">
        {$theme.theme_version}&nbsp;
      </td>
      <td>
        {if $theme.active != '1'}
          <a href='/theme/delete/{$theme.id}' class="btn-icon btn-delete" title="{#sys_delete#}"><span>&nbsp;{#sys_delete#}</span></a>
        {/if}
        &nbsp;
      </td>
    </tr>
   {/foreach}
  </tbody>
</table>
  <center>
    <a href="/theme/install">{#sys_add#}</a>
  </center>