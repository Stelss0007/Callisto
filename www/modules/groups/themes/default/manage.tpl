<form action="" method="post">
<table>
  <input type="hidden" name='id' value="{$id}">
  <tr>
    <td>
      ��� ������
    </td>
    <td>
      <input type="text" name='group_displayname' value='{$group_displayname}'>
    </td>
  </tr>

  <tr>
    <td>
      ��������
    </td>
    <td>
      <textarea name=group_description>{$group_description}</textarea>
    </td>
  </tr>
</table>
    <input type="submit" name='submit' value="Save">
</form>