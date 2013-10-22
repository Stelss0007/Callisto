<form action="" method="post">
  <input type="hidden" name='id' value="{$id}">
  <table class="outer" cellSpacing="1" cellPadding="4" width="100%">
    <colgroup>
      <col width="25%">
      <col width="75%">
    </colgroup>
    <thead>
      <th colspan="2">
        Редактирование прав доступа
      </th>
    </thead>
    <tbody>
    <tr>
      <td class="head">
        Группа
      </td>
      <td class="even">
        {html_options name=gid options=$groups selected=$group_permission_gid}
      </td>
    </tr>
    <tr>
      <td class="head">
        Объект
      </td>
      <td class="even">
        <input type="text" name='pattern' value='{$group_permission_pattern}'  style="width: 98%;">
      </td>
    </tr>
    <tr>
      <td class="head">
        Уровень доступа
      </td>
      <td class="even">
        {html_options name=level options=$levels selected=$group_permission_level}
      </td>
    </tr>
    <tr>
      <td class="head">
        Описание
      </td>
      <td class="even">
        <textarea name='description' style="width: 98%;">{$group_permission_description}</textarea>
      </td>
    </tr>
    </tbody>  
  </table>
  <input type="submit" name='submit' value="Save">
</form>