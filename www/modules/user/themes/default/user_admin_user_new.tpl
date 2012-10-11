{strip}
{* Для всех да нет *}
{array name='yes_no'}
{array_append name='yes_no' key='1' value=Да}
{array_append name='yes_no' key='0' value=Нет}
<form name="userform" action="/index.php?module=user&type=admin&func=user_create" method="post">
  <table class="outer" cellSpacing="1" cellPadding="4" width="100%">
    <colgroup>
      <col width="30%">
      <col width="70%">
    </colgroup>

    <thead>
      <tr>
        <th colSpan="2">Добавление пользователя</th>
      </tr>
    </thead>

    <tfoot>
      <tr>
        <td class="even" colspan="2" align="center">
          <input class="formButton" type="submit" value="Добавить" name="submit">
        </td>
      </tr>
    <tfoot>

    <tbody>
      <tr>
        <td class="head">Имя пользователя(login)</td>
        <td class="even"><input maxLength="25" size="30" name="login" value="{$login|escape}"></td>
      </tr>
      <tr>
        <td class="head">Пароль</td>
        <td class="even"><input type="text" maxLength="20" size="10" value name="pass" value="{$pass|escape}"></td>
      </tr>
      <tr>
        <td class="head">Имя (Ф.И.О.)</td>
        <td class="even"><input maxLength="60" size="40" name="displayname" value="{$displayname|escape}"></td>
      </tr>
      <tr>
        <td class="head">E-mail</td>
        <td class="even"><input maxLength="60" size="30" name="mail" value="{$mail|escape}"></td>
      </tr>
      
      <tr>
        <td class="head">Группа </td>
        <td class="even">
          <select name = 'gid'>
            {html_options options=$group_list selected=2}
          </select>
        </td>
      </tr>

      <tr>
        <td class="head">Активирован</td>
        <td class="even">
          {html_radios name="active" options=$yes_no checked=1 separator=" "}
        </td>
      </tr>
    
      <tr>
        <td class="head">ICQ</td>
        <td class="even">
          <input maxLength="10" size="10" name="icq" value="{$icq|escape}">
        </td>
      </tr>

      <tr>
        <td class="head">Интересы</td>
        <td class="even">
          <input maxLength="255" size="70" name="interests" value="{$interests|escape}">
        </td>
      </tr>

      <tr>
        <td class="head">О себе</td>
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