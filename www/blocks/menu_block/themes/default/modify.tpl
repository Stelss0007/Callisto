{strip}
  <div class="control-group">
    <label class="control-label" for="date01">��������� ����:</label>
    <div class="controls">
     <select name=menu_type>
        {html_options options=$menutypes_list selected=$menu_type}
      </select>
    </div>
  </div>
      
  <div class="control-group">
    <label class="control-label" for="date01">�������� � ��������:</label>
    <div class="controls">
     {* ��������� ����� ��� ������� html_options *}
      {array name='flat_itemslist'}
      {array_append name='flat_itemslist' key='0' value='������'}
      
      {foreach item=item from=$items_list}
        {array_append name='flat_itemslist' key=$item.id value=$item.menu_title|escape|tree:$item.level}
      {/foreach}

      <select name="parent_id">
        {html_options options=$flat_itemslist selected=$parent_id}
      </select>
    </div>
  </div>

{/strip}