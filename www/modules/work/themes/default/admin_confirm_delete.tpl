{strip}
<form name="groupform" action="{mod_url type='admin' modname='SYS_groups' func='delete'}" method="post">
  <input name="id" type="hidden" value="{$id}">

    <table class="outer" cellSpacing="1" cellPadding="4" width="100%">
      <thead>
        <tr>
          <th>�������� ������</th>
        </tr>
      </thead>

      <tfoot>
        <tr>
          <td class="foot" align="center">
            <input type="submit" value="�������" name="group_submit">
          </td>
        </tr>
      </tfoot>

      <tbody>
        <tr vAlign="top" align="center">
          <td class="even">������� ������ {$group_displayname|escape} ({$group_description|escape}) ?</td>
        </tr>
      </tbody>

    </table>

</form>

{/strip}