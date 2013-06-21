{strip}
  <tr>
    <td width="20%" align="left" class="head">Начинать с элемента :</td>
    <td width="80%" align="left" class="even">
      {* Формируем масив для вункции html_options *}
      {array name='flat_itemslist'}

      {foreach item=item from=$items_list}
        {array_append name='flat_itemslist' key=$item.id value=$item.displayname|escape|tree:$item.level}
      {/foreach}

      <select name="parent_id">
        {html_options options=$flat_itemslist selected=$parent_id}
      </select>
    </td>
  </tr>

{/strip}
