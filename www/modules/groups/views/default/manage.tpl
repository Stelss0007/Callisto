<form action="" method="post">
  <input type="hidden" name='id' value="{$id}">
  <table class="outer" width='100%' style="width: 100%;" cellspacing="1" cellpadding="4">
    <colgroup>
      <col width="25%">
      <col width="75%">
    </colgroup>
    <thead>
      <tr>
        <th colspan="2">
          {#groups_edit#}
        </th>
      </tr>
    </thead>
    <tfoot>
      <td colspan="2">
        <input type="submit" name='submit' value="{#groups_save#}">
      </td>
    </tfoot>
    <tbody>
      <tr>
        <td class='head'>
          {#groups_title#}
        </td>
        <td  class='even'>
          <input type="text" name='group_displayname' value='{$group_displayname}' style="width: 98%;">
        </td>
      </tr>

      <tr>
        <td class='head'>
          {#groups_description#}
        </td>
        <td  class='even'>
          <textarea name='group_description' style="width: 98%;">{$group_description}</textarea>
        </td>
      </tr>
    </tbody>
  </table>
    
</form>