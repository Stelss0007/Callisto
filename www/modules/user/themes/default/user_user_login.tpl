{strip}
{if $user_id}
  <h1>����� ���������� �� ��� ����! </h1>
  ������ �� ���������� �� �������� ������ �� �������. ��� ���� ����� ����� ������� ������ �����
   <form method="post" action="index.php?module=user&type=user&func=user_logout" class="login" name="loginform">
    <center>
      <b>����� �� �������</b>
      <br><br><br>
      <input type="submit" class="button-green" value="�����">
    </center>
        
  </form>
{else}
  <h1>����� ���������� �� ��� ����!</h1>
  ��� ����� � ���� �������
  , ������� ��� ��������������� ����� � ������, ����� ������������ �� �������� � ���� �������.
  <form method="post" action="index.php?module=user&type=user&func=user_login" class="login" name="loginform">
    <center><b>���� � �������</b></center>
    <br>
    <div class="note">
      <span class="note-text">�����</span>
      <input type="text" style="width: 170px;" value="" maxlength="40" name="login">
    </div>
    <div class="note">
      <span class="note-text">������</span>
      <input type="password" style="width: 170px;" value="" maxlength="40" name="pass">
    </div>
    <br>
    <center>
      <input class="button-green" type="submit" name="ok" value="�����" />
      <br>
      <font size="1">
        ���� �� ��� �� ����������������, &nbsp;
        <a href='/index.php?module=user&type=user'>����������������� � �������</a>.
      </font>
    </center>
  </form>
{/if}
{/strip}

