{array name='yes_no'}
{array_append name='yes_no' key='1' value=��}
{array_append name='yes_no' key='0' value=���}

<h2>�������������� ������������</h2>
<form action="" method="post">
<table width='100%'>
  <input type="hidden" name='id' value="{$id}">
  <col width='220' >
  <col width='*'>
  <tr>
    <td>
      �����
    </td>
    <td>
      <input type="text" name='login' size='40' value='{$login}'>
    </td>
  </tr>
  
  <tr>
    <td>
      ������
    </td>
    <td>
      <input type="password" name='pass' size='40' value=''>
    </td>
  </tr>

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
      Email
    </td>
    <td>
      <input type="text" name='mail' size='40' value='{$mail}'>
    </td>
  </tr>
  <tr>
    <td>
      ���(�.�.�)
    </td>
    <td>
      <input type="text" name='displayname' size='40' value='{$displayname}'>
    </td>
  </tr>
  <tr>
    <td>
      �����������
    </td>
    <td>
      {html_radios name=active options=$yes_no checked=$active separator=" "}
    </td>
  </tr>
</table>
    <center>
      <input type="submit" name='submit' value="Save">
    </center>
</form>