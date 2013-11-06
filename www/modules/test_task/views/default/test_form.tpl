{appJsLoad modname='test_task'}
<form action='/test_task/save_data' id="test_form">
  <input type="hidden" id="element_id" value="{$id}">
  <table>
    <tr>
      <td>Field 1</td>
      <td><input type="text" name="field_1" value="{$field_1}"></td>
    </tr>
    <tr>
      <td>Field 2</td>
      <td><input type="text" name="field_2" value="{$field_2}"></td>
    </tr>
    <tr>
      <td>Field 3</td>
      <td><input type="text" name="field_3" value="{$field_3}"></td>
    </tr>
    <tr>
      <td>Field 4</td>
      <td><input type="text" name="field_4" value="{$field_4}"></td>
    </tr>
  </table>
</form>