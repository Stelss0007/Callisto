<form action="" method="post">
<table>
  <input type="hidden" name='id' value="{$id}">
  <tr>
    <td>
      Имя группы
    </td>
    <td>
      <input type="text" name='group_displayname' value='{$group_displayname}'>
    </td>
  </tr>

  <tr>
    <td>
      Описание
    </td>
    <td>
      <textarea name=group_description>{$group_description}</textarea>
    </td>
  </tr>
</table>
    <input type="submit" name='submit' value="Save">
</form>