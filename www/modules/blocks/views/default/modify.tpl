{strip}
<form action="/blocks/update" method="post">
<input type="hidden" name="id" value="{$id}">
<input type="hidden" name="ref" value="{$ref}">

<table class="outer" cellSpacing="1" cellPadding="4" width="100%">
  <colgroup>
    <col width="35%">
    <col width="65%">
  </colgroup>

  <thead>
  <tr>
    <th width="100%" align="center" colspan="2">Редактирование блока "{$block_name}"</th>
  </tr>
  </thead>

  <tfoot>
  <tr>
    <td width="100%" align="center" class="foot" colspan="2">
      <input type="submit" value="Сохранить" name="submit">
    </th>
  </tr>
  </tfoot>

  <tbody>
  <tr>
    <td width="20%" align="left" class="head">Название :</td>
    <td width="80%" align="left" class="even">{$block_name}</td>
  </tr>
  <tr>
    <td width="20%" align="left" class="head">ID:</td>
    <td width="80%" align="left" class="even">{$id}</td>
  </tr>
  <tr>
    <td width="20%" align="left" class="head">Отображаемое название:</td>
    <td width="80%" align="left" class="even">
      <input type="text" name="block_displayname" size="50" value="{$block_displayname|escape}">
    </td>
  </tr>
  <tr>
    <td width="20%" align="left" class="head">Маска :</td>
    <td width="80%" align="left" class="even">
      <input type="text" name="block_pattern" size="50" value="{$block_pattern|escape}">
    </td>
  </tr>
  <tr>
    <td width="20%" align="left" class="head">Положение :</td>
    <td width="80%" align="left" class="even">
    <select name='block_position'>
      {html_options options=$positions selected=$block_position}</td>
    </select>
  </tr>
  <tr>
    <td width="20%" align="left" class="head">CSS класс :</td>
    <td width="80%" align="left" class="even">
      <input type="text" name="block_css_class" size="50" value="{$block_css_class|escape}">
    </td>
  </tr>
 
  {$block_config_result}
  </tbody>

</table>



</form>
{/strip}