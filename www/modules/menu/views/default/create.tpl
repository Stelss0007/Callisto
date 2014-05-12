{strip}
{array name='yes_no'}
{array_append name='yes_no' key='1' value='Да'}
{array_append name='yes_no' key='0' value='Нет'}

<form name="item_new_form" action="/admin/menu/manage" method="post">
  <input type="hidden" name="id" value="{$id}">
  <table class="outer" cellSpacing="1" cellPadding="4" width="100%">
    <colgroup>
      <col width="25%">
      <col width="75%">
    </colgroup>
    
    <thead>
      <tr>
        <th colSpan="2">Редактирование элемента</th>
      </tr>
    </thead>
    
    <tfoot>
      <tr>
        <td class="foot" colspan="2" align="center">
          <input class="formButton" type="submit" value="Редактировать" name="submit">
        </td>
      </tr>
    </tfoot>

    <tbody>
      <tr>
        <td class="head">Находиться в</td>
        <td class="even">
          {* Формируем плоский масив для функции html_options *}
          {array name='flat_itemslist'}
          {array_append name='flat_itemslist' key='0' value='Корень'}

          {foreach item=item from=$items_list}
            {array_append name='flat_itemslist' key=$item.id value=$item.menu_title|escape|tree:$item.level}
          {/foreach}

          <select name=menu_parent_id>
            {html_options options=$flat_itemslist selected=$menu_parent_id}
          </select>
        </td>
      </tr>

      <tr>
        <td class="head">Активна</td>
        <td class="even">
          {html_radios name="menu_active" options=$yes_no checked=$menu_active separator=" "}
        </td>
      </tr>

      <tr>
        <td class="head">Имя</td>
        <td class="even">
          <input size="70" name="menu_title" value="{$menu_title|escape}">
        </td>
      </tr>

      <tr>
        <td class="head">Маска, где развернуты вложенные элементы</td>
        <td class="even">
          <input size="70" name="menu_item_pattern" value="{$menu_item_pattern}">
        </td>
      </tr>      

      <tr>
        <td class="head">Описание</td>
        <td class="even">
          <textarea name="menu_description" rows="5" cols="70">{$menu_description|escape}</textarea>
        </td>
      </tr>

      <tr>
        <th>Тип : </th>
        <th>Параметры : </th>
      </tr>

      <tr>
        {if $menu_item_type==1}
          <td class="head">
            <input type="radio" value="1" name="menu_item_type" checked> Разделитель
          </td>
        {else}
          <td class="head">
            <input type="radio" value="1" name="menu_item_type"> Разделитель
          </td>
        {/if}
        <td class="even">&nbsp</td>
      </tr>

      <tr>
        {if $menu_item_type==2}
          <td class="head">
            <input type="radio" value="2" name="menu_item_type" checked> Заголовок
          </td>
        {else}
          <td class="head">
            <input type="radio" value="2" name="menu_item_type"> Заголовок
          </td>
        {/if}
        <td class="even">&nbsp</td>
      </tr>

      {if $menu_item_type==3}
        <tr>
          <td class="head">
            <input type="radio" value="3" name="menu_item_type" checked> Url
          </td>
          <td class="even">
            <input size="70" name="menu_content3" value="{$menu_content|escape}">
          </td>
        </tr>
      {else}
        <tr>
          <td class="head">
            <input type="radio" value="3" name="menu_item_type"> Url
          </td>
          <td class="even">
            <input size="70" name="menu_content3" value="">
          </td>
        </tr>
      {/if}

      {if $menu_item_type==4}
        <tr>
          <td class="head">
            <input type="radio" value="4" name="menu_item_type" checked> Html код
          </td>
          <td class="even">
            <textarea name="menu_content4" rows="5" cols="70">{$menu_content|escape}</textarea>
          </td>
        </tr>
      {else}
        <tr>
          <td class="head">
            <input type="radio" value="4" name="menu_item_type"> Html код
          </td>
          <td class="even">
            <textarea name="menu_content4" rows="5" cols="70"></textarea>
          </td>
        </tr>
      {/if}
    <tbody>        
    
  </table>
</form>
{/strip}