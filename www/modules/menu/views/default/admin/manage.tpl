{strip}
{array name='yes_no'}
{array_append name='yes_no' key='1' value='Да'}
{array_append name='yes_no' key='0' value='Нет'}

<form action="" method="post" name="item_new_form" class="form-horizontal">
  <input type="hidden" name='id' value="{$id}">
  <div class="row-fluid sortable">
    <div class="box span12">
      <div class="box-header well" data-original-title>
        <h2><i class="icon-edit"></i> {#user_edit#}</h2>
        <div class="box-icon">
          <a href="#" class="btn btn-setting btn-round"><i class="icon-cog"></i></a>
          <a href="#" class="btn btn-minimize btn-round"><i class="icon-chevron-up"></i></a>
          <a href="#" class="btn btn-close btn-round"><i class="icon-remove"></i></a>
        </div>
      </div>
      <div class="box-content">

          <fieldset>
           {* <legend>Manage form</legend>*}
            <br><br>

            <div class="control-group">
              <label class="control-label" for="date01">Находиться в</label>
              <div class="controls">
                  {* Формируем плоский масив для функции html_options *}
                  {array name='flat_itemslist'}
                  {array_append name='flat_itemslist' key='0' value='Корень'}

                  {foreach item=item from=$items_list}
                    {array_append name='flat_itemslist' key=$item.id value=$item.menu_title|escape|tree:$item.level}
                  {/foreach}

                  <select name=menu_parent_id>
                    {html_options options=$flat_itemslist selected=$menu_parent_id}
                  </select>
              </div>
            </div>

            <div class="control-group">
              <label class="control-label" for="date01">Активна</label>
              <div class="controls">
                  {html_radios name="menu_active" options=$yes_no checked=$menu_active separator=" "}
              </div>
            </div>
              
            <div class="control-group">
              <label class="control-label" for="date01">Имя</label>
              <div class="controls">
                 <input size="70" name="menu_title" value="{$menu_title|escape}">
              </div>
            </div>

            <div class="control-group">
              <label class="control-label" for="date01">Маска, где развернуты вложенные элементы</label>
              <div class="controls">
                 <input size="70" name="menu_item_pattern" value="{$menu_item_pattern}">
              </div>
            </div>

            <div class="control-group">
              <label class="control-label" for="date01">Описание</label>
              <div class="controls">
                 <textarea name="menu_description" rows="5" cols="70">{$menu_description|escape}</textarea>
              </div>
            </div>

            <div class="control-group">
              <table>
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
              <table>
            </div>

            
            <div class="form-actions">
              <button type="submit" class="btn btn-primary">{#sys_save#}</button>
              <button type="reset" class="btn">Cancel</button>
            </div>
          </fieldset>
 

      </div>
    </div><!--/span-->

  </div><!--/row-->
</form>
              
{/strip}              