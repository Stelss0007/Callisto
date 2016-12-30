{array name='yes_no'}
{array_append name='yes_no' key='1' value=Да}
{array_append name='yes_no' key='0' value=Нет}

<form action="" method="post">
  <input type="hidden" name='id' value="{$id}">
  <table width='100%' class="outer" cellSpacing="1" cellPadding="4" >
  <col width='220' >
  <col width='*'>
  <thead>
    <tr>
      <th colspan="2">{#user_edit#}</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td class="head">
        {#user_login#}
      </td>
      <td  class="even">
        <input type="text" name='login' size='40' value='{$login}'>
      </td>
    </tr>

    <tr>
      <td class="head">
        {#user_pass#}
      </td>
      <td class="even">
        <input type="password" name='pass' size='40' value=''>
      </td>
    </tr>

    <tr>
      <td class="head">
        {#user_group#}
      </td>
      <td class="even">
        {html_options name=gid options=$groups_list selected=$gid}
      </td>
    </tr>

    <tr>
      <td class="head">
        {#user_email#}
      </td>
      <td class="even">
        <input type="text" name='mail' size='40' value='{$mail}'>
      </td>
    </tr>
    <tr>
      <td class="head">
        {#user_fio#}
      </td>
      <td class="even">
        <input type="text" name='displayname' size='40' value='{$displayname}'>
      </td>
    </tr>
    <tr>
      <td class="head">
        {#user_active#}
      </td>
      <td class="even">
        {html_radios name=active options=$yes_no checked=$active separator=" "}
      </td>
    </tr>
  </tbody>
</table>
    <center>
      <input type="submit" name='submit' value="{#sys_save#}">
    </center>
</form>