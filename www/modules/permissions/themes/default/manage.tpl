<form action="" method="post">
  <input type="hidden" name='id' value="{$id}">
  <table class="outer" cellSpacing="1" cellPadding="4" width="100%">
    <colgroup>
      <col width="25%">
      <col width="75%">
    </colgroup>
    <thead>
      <th colspan="2">
        �������������� ���� �������
      </th>
    </thead>
    <tbody>
    <tr>
      <td class="head">
        ������
      </td>
      <td>
        {html_options name=gid options=$groups selected=$gid}
      </td>
    </tr>
    <tr>
      <td class="head">
        ������
      </td>
      <td>
        <input type="text" name='pattern' value='{$pattern}'>
      </td>
    </tr>
    <tr>
      <td class="head">
        ������� �������
      </td>
      <td>
        {html_options name=level options=$levels selected=$level}
      </td>
    </tr>
    <tr>
      <td class="head">
        ��������
      </td>
      <td>
        <textarea name=description>{$description}</textarea>
      </td>
    </tr>
    </tbody>  
  </table>
  <input type="submit" name='submit' value="Save">
</form>