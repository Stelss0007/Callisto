{strip}
{* ��� ���� �� ��� *}
{array name='yes_no'}
{array_append name='yes_no' key='1' value=��}
{array_append name='yes_no' key='0' value=���}
<h1>������ ������ ������������</h1>
��������� ������������! ������ ��������� ����������� ��� ���������� ������ ������� �������,
�������� ����� ����������� ���������. � ��������� ����� ������� ���������.
�������������� ���, ���� � ���-���� ������������.
<form name="userform" action="/index.php?module=user&type=admin&func=user_update" method="post">
  <table class="outer" cellSpacing="1" cellPadding="4" width="100%">
    <colgroup>
      <col width="150" align="left">
      <col width="*">
    </colgroup>

    <thead>
      <tr>
        <th colSpan="2"><h3>��� ������������ ������ (���������� ��� ��������� ������� "�������")</h3></th>
      </tr>
      <tr>
        <th class='head'>��������</th>
        <th class='head'>��������</th>
      </tr>
    </thead>

    <tfoot>
      <tr>
        <td class="even" colspan="2" align="center">
          <input class="formButton" type="submit" value="���������" name="submit">
        </td>
      </tr>
    <tfoot>

    <tbody>
      <tr>
        <td class="head" align="left">��� ������������<br>(login):</td>
        <td class="even"><input maxLength="25" size="30" name="login" value="{$login|escape}"></td>
      </tr>
      <tr>
        <td class="head" align="left">������:</td>
        <td class="even">
          <input type="password" maxLength="20" size="20" value name="pass" value="{$pass|escape}">
          &nbsp;�����������:
          <input type="password" maxLength="20" size="20" value name="pass2" value="{$pass|escape}">
        </td>
      </tr>
      <tr>
        <td class="head" align="left">��� (�.�.�.):</td>
        <td class="even"><input maxLength="60" size="40" name="displayname" value="{$displayname|escape}"></td>
      </tr>
      <tr>
        <td class="head" align="left">E-mail:</td>
        <td class="even"><input maxLength="60" size="30" name="mail" value="{$mail|escape}"></td>
      </tr>
      
      <tr>
        <td class="head" align="left">������: </td>
        <td class="even">
          <select name = 'gid'>
            {html_options options=$group_list selected=$gid}
          </select>
        </td>
      </tr>

      <tr>
        <td class="head" align="left">�����������:</td>
        <td class="even">
          {html_radios name="active" options=$yes_no checked=$active separator=" "}
        </td>
      </tr>
    
      <tr>
        <td class="head" align="left">ICQ:</td>
        <td class="even">
          <input maxLength="10" size="10" name="icq" value="{$icq|escape}">
        </td>
      </tr>

      <tr>
        <td class="head" align="left">��������:</td>
        <td class="even">
          <input maxLength="255" size="70" name="interests" value="{$interests|escape}">
        </td>
      </tr>

      <tr>
        <td class="head" align="left">� ����:</td>
        <td class="even">
          <textarea name="about" rows="8" cols="70">
            {$about|escape}
          </textarea>
        </td>
      </tr>
     
    </tbody>

  </table>
</form>
{/strip}