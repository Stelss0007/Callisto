{strip}

{array name='yes_no'}
{array_append name='yes_no' key='1' value='��'}
{array_append name='yes_no' key='0' value='���'}

<form name="item_new_form" action="" method="post">
  <input type="hidden" name="id" value="{$id}">
  <table class="outer" cellSpacing="1" cellPadding="4" width="100%">
    <colgroup>
      <col width="25%">
      <col width="75%">
    </colgroup>
    
    <thead>
      <tr>
        <th colSpan="2">�������������� ��������</th>
      </tr>
    </thead>
    
    <tfoot>
      <tr>
        <td class="foot" colspan="2" align="center">
          <input class="formButton" type="submit" value="�������������" name="submit">
        </td>
      </tr>
    </tfoot>

    <tbody>
      <tr>
        <td class="head">���������� �</td>
        <td class="even">
          {* ��������� ������� ����� ��� ������� html_options *}
          {array name='flat_itemslist'}
          {array_append name='flat_itemslist' key='0' value='������'}

          {foreach item=item from=$items_list}
            {array_append name='flat_itemslist' key=$item.id value=$item.title|escape|tree:$item.level}
          {/foreach}

          <select name=parent_id>
            {html_options options=$flat_itemslist selected=$parent_id}
          </select>
        </td>
      </tr>

      <tr>
        <td class="head">�������</td>
        <td class="even">
          {html_radios name="active" options=$yes_no checked=$active separator=" "}
        </td>
      </tr>

      <tr>
        <td class="head">���</td>
        <td class="even">
          <input size="70" name="displayname" value="{$displayname|escape}">
        </td>
      </tr>

      <tr>
        <td class="head">�����, ��� ���������� ��������� ��������</td>
        <td class="even">
          <input size="70" name="item_pattern" value="{$item_pattern}">
        </td>
      </tr>      

      <tr>
        <td class="head">��������</td>
        <td class="even">
          <textarea name="description" rows="5" cols="70">{$description|escape}</textarea>
        </td>
      </tr>

      <tr>
        <th>��� : </th>
        <th>��������� : </th>
      </tr>

      <tr>
        {if $item_type==1}
          <td class="head">
            <input type="radio" value="1" name="item_type" checked> �����������
          </td>
        {else}
          <td class="head">
            <input type="radio" value="1" name="item_type"> �����������
          </td>
        {/if}
        <td class="even">&nbsp</td>
      </tr>

      <tr>
        {if $item_type==2}
          <td class="head">
            <input type="radio" value="2" name="item_type" checked> ���������
          </td>
        {else}
          <td class="head">
            <input type="radio" value="2" name="item_type"> ���������
          </td>
        {/if}
        <td class="even">&nbsp</td>
      </tr>

      {if $item_type==3}
        <tr>
          <td class="head">
            <input type="radio" value="3" name="item_type" checked> Url
          </td>
          <td class="even">
            <input size="70" name="content3" value="{$content3|escape}">
          </td>
        </tr>
      {else}
        <tr>
          <td class="head">
            <input type="radio" value="3" name="item_type"> Url
          </td>
          <td class="even">
            <input size="70" name="content3" value="">
          </td>
        </tr>
      {/if}

      {if $item_type==4}
        <tr>
          <td class="head">
            <input type="radio" value="4" name="item_type" checked> Html ���
          </td>
          <td class="even">
            <textarea name="content4" rows="5" cols="70">{$content4|escape}</textarea>
          </td>
        </tr>
      {else}
        <tr>
          <td class="head">
            <input type="radio" value="4" name="item_type"> Html ���
          </td>
          <td class="even">
            <textarea name="content4" rows="5" cols="70"></textarea>
          </td>
        </tr>
      {/if}
    <tbody>        
    
  </table>
</form>
{/strip}