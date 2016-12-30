{strip}
{array name='yes_no'}
{array_append name='yes_no' key='1' value='Да'}
{array_append name='yes_no' key='0' value='Нет'}

<form action="/admin/menu/manage" method="post" class="form-horizontal">
  <input type="hidden" name='id' value="{$id}">
  <div class="row-fluid">
    <div class="box span12">
      <div class="box-header well" data-original-title>
        <h2><i class="icon-edit"></i>  {#menu_edit_element#}</h2>
        <div class="box-icon">
        </div>
      </div>
      <div class="box-content">
        
        <fieldset>
           {* <legend>Manage form</legend>*}
            <br><br>
             <div class="form-group">
              <label class="col-sm-3 control-label" for="date01">{#menu_parent#}</label>
              <div class="controls col-sm-5">
                {* Формируем плоский масив для функции html_options *}
                {array name='flat_itemslist'}
                {array_append name='flat_itemslist' key='0' value='Корень'}

                {foreach item=item from=$items_list}
                  {array_append name='flat_itemslist' key=$item->id value=$item->menu_title|escape|tree:$item->level}
                {/foreach}

                <select name=menu_parent_id  data-rel="chosen" class="form-control selectpicker">
                  {html_options options=$flat_itemslist selected=$menu_parent_id }
                </select>
              </div>
             </div>
              
             <div class="form-group">
              <label class="col-sm-3 control-label" for="date01">{#menu_active#}</label>
              <div class="controls col-sm-5">
                 {html_radios name="menu_active" options=$yes_no checked=$menu_active separator=" "}
              </div>
             </div>
              
             <div class="form-group">
              <label class="col-sm-3 control-label" for="date01">{#menu_name#}</label>
              <div class="controls col-sm-5">
                 <input type="text" size="70" name="menu_title" style="" class="form-control" value="{$menu_title|escape}">
              </div>
             </div>
              
             <div class="form-group">
              <label class="col-sm-3 control-label" for="date01">Маска, где развернуты вложенные элементы</label>
              <div class="controls col-sm-5">
                <input type="text" size="70" name="menu_item_pattern" style="" class="form-control" value="{$menu_item_pattern}">
              </div>
             </div>
              
             <div class="form-group">
              <label class="col-sm-3 control-label" for="date01">{#menu_description#}</label>
              <div class="controls col-sm-5">
                 <textarea name="menu_description" rows="5" cols="70" style="" class="form-control">{$menu_description|escape}</textarea>
              </div>
             </div>
              
             <div class="form-group">
              <label class="col-sm-3 control-label" for="date01">{#menu_type#}</label>
              <div class="controls col-sm-5 type-select">
                <label>
                {if $menu_item_type==1}
                  <input type="radio" value="1" name="menu_item_type" checked> Разделитель
                {else}
                  <input type="radio" value="1" name="menu_item_type"> Разделитель
                {/if}
                </label>
                <br/>
                <label>
                {if $menu_item_type==2}
                  <input type="radio" value="2" name="menu_item_type" checked> Заголовок
                {else}
                  <input type="radio" value="2" name="menu_item_type"> Заголовок
                {/if}
                </label>
                <br/>
                <label>
                {if $menu_item_type==3}
                  <input type="radio" value="3" name="menu_item_type" checked> Url
                {else}
                  <input type="radio" value="3" name="menu_item_type"> Url
                  {/if}
                </label>
                <br/>
                <label>
                {if $menu_item_type==4}
                  <input type="radio" value="4" name="menu_item_type" checked> Html код
                {else}
                  <input type="radio" value="4" name="menu_item_type"> Html код
                {/if}
                </label>
                
                <div class="type-value">
                  {if $menu_item_type==3}
                    <input size="70" type="text"  name="menu_content3" id="menu_content3" class="form-control" style="width: 98%;" value="{$menu_content|escape}">
                  {else}
                    <input size="70" type="text"  name="menu_content3" id="menu_content3" class="form-control" style="width: 98%;" value="">
                  {/if}

                  {if $menu_item_type==4}
                    <textarea name="menu_content4" id="menu_content4" rows="5" class="form-control" style="width: 98%;" cols="70">{$menu_content|escape}</textarea>
                  {else}
                    <textarea name="menu_content4" id="menu_content4" rows="5" class="form-control" style="width: 98%;" cols="70"></textarea>
                  {/if}
                </div>

              </div>
             </div>
           
              
            <div class="form-actions col-sm-8">
              <button type="submit" class="btn btn-primary" name="submit" value="submit">{#sys_save#}</button>
              <button type="reset" class="btn">Cancel</button>
            </div>
        
        </fieldset>
      </div>
    </div><!--/span-->

  </div><!--/row-->
</form>
{/strip}

{literal}
  <style>
    .type-value input, .type-value textarea {
      display: none;
    }
  </style>
  <script>
    $('.type-select input').change(function(){
      $('.type-value').children().hide();
      $('#menu_content'+$(this).val()).show();
    });
  </script>
{/literal}