<form action="" method="post">
<table>
  <input type="hidden" name='id' value="{$id}">
  <tr>
    <td>
      ������
    </td>
    <td>
      {html_options name=gid options=$groups selected=$gid}
    </td>
  </tr>
  <tr>
    <td>
      ������
    </td>
    <td>
      <input type="text" name='pattern' value='{$pattern}'>
    </td>
  </tr>
  <tr>
    <td>
      ������� �������
    </td>
    <td>
      {html_options name=level options=$levels selected=$level}
    </td>
  </tr>
  <tr>
    <td>
      ��������
    </td>
    <td>
      <textarea name=description>{$description}</textarea>
    </td>
  </tr>
</table>
    <input type="submit" name='submit' value="Save">
</form>