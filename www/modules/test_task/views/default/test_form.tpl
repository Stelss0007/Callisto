{appJsLoad modname='test_task'}
{array name='field_5_lst'}
{array_append name='field_5_lst' key='1' value='1'}
{array_append name='field_5_lst' key='2' value='2'}
{array_append name='field_5_lst' key='3' value='3'}
{array_append name='field_5_lst' key='4' value='4'}
{array_append name='field_5_lst' key='5' value='5'}

{array name='field_6_lst'}
{array_append name='field_6_lst' key='1' value='1'}
{array_append name='field_6_lst' key='2' value='2'}

<form action='/test_task/save_data' id="test_form">
  <input type="hidden" id="element_id" value="{$id}">
  <input type="hidden" id="update_time" value="{$update_time}">
  <table>
    <tr>
      <td>Select 1</td>
      <td>
        <select name='field_5' id='field_5'>
         {html_options options=$field_5_lst selected=$field_5}
        </select>
      </td>
    </tr>
    <tr>
      <td>Field 1</td>
      <td><input type="text" name="field_1" id="field_1" value="{$field_1|trim}" size="80"></td>
    </tr>
    <tr>
      <td>Field 2</td>
      <td><input type="text" name="field_2" id="field_2" value="{$field_2}" size="80"></td>
    </tr>
    <tr>
      <td>Field 3</td>
      <td><input type="text" name="field_3" id="field_3" value="{$field_3}" size="80"></td>
    </tr>
    <tr>
      <td>Field 4</td>
      <td><input type="text" name="field_4" id="field_4" value="{$field_4}" size="80"></td>
    </tr>
   
  </table>
</form>