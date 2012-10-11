{strip}
<form method="POST" action="/index.php?module=groups&type=admin&func=perms_create">

  <table class="outer" cellSpacing="1" cellPadding="4" width="100%">
    <colgroup>
      <col width="25%">
      <col width="75%">
    </colgroup>

    <thead>
      <tr>
        <th colspan="2">Новые права группы "{$group_displayname}"</th>
      </tr>
    </thead>

    <tfoot>
      <tr>
        <td align="center" colSpan="2" class="foot">
          <input type="submit" value="Создать">
        </td>
      </tr>
    </tfoot>

    <tbody>
      <tr>
        <td class="head">Группа</td>
        <td class="even">
          <input type="hidden" name="gid" value="{$id}">
          <input type="hidden" name="ref" value="{$ref}">
          {$group_displayname}
        </td>
      </tr>
      <tr>
        <td class="head">Компонент</td>
        <td class="even">
          <select size="1" name="component">
            {html_options options=$components_list}
          </select>
        </td>
      </tr>
      <tr>
        <td class="head">Объект</td>
        <td class="even">
          <input maxLength="255" size="70" name="pattern" value=".*">
        </td>
      </tr>
      <tr>
        <td class="head">Уровень доступа</td>
        <td class="even">
          <select size="1" name="level">
            {html_options options=$perms_level_list}
          </select>
        </td>
      </tr>
      <tr>
        <td class="head">Описание</td>
        <td class="even">
          <textarea name="description" rows="5" cols="70"></textarea>
        </td>
      </tr>
    </tbody>

  </table>
</form>

{/strip}