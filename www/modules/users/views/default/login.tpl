{strip}
{if $isLogin}
  <h1>����� ���������� �� ��� ����! </h1>
  ������ �� ���������� �� �������� ������ �� �������. ��� ���� ����� ����� ������� ������ �����
   <form method="post" action="/users/logout" class="login" name="loginform">
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
  <form method="post" action="" class="login" name="loginform">
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
      <input class="button-green" type="submit" name="submit" value="�����" />
      <br>
      <font size="1">
        ���� �� ��� �� ����������������, &nbsp;
        <a href='/users/register'>����������������� � �������</a>.
      </font>
    </center>
  </form>
{/if}
{$sysMessage}
{/strip}


