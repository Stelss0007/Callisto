{strip}
      <form action="{mod_url type='user' modname='SYS_users' func='login'}" method="post" style="margin: 0;">
        <table cellSpacing="0" cellPadding="1" width="100%" border="0">
            <tr>
              <td>&nbsp;��� ������������</td>
            </tr>
            <tr>
              <td><input maxLength="25" size="14" name="user_name"></td>
            </tr>
            <tr>
              <td>&nbsp;������</td>
            </tr>
            <tr>
              <td><input type="password" maxLength="20" size="14" name="user_pass"></td>
            </tr>
            <tr>
              <td><input type="checkbox" value="1" name="user_rememberme">&nbsp;��������� ����</td>
            </tr>
            <tr>
              <td><br>
                <input type="submit" value="����">
              </td>
            </tr>
            <tr>
              <td><br>
                ��� ��� �� <a href="{mod_url type='user' modname='SYS_users' func='registerscreen'}">������������������</a>? ����������� ������� ����������� ���� ��������� ����� �����, ����������� ������ �� ������ �������������� �������� � ����������, ������� ��� ���������� ������������ ����������.
              </td>
            </tr>
        </table>
      </form>
{/strip}