{strip}
{if $isLogin}
  <h1>Добро пожаловать на наш сайт! </h1>
  Сейчас Вы находитесь на странице выхода из системы. Для того чтобы выйти нажмите кнопку выйти
   <form method="post" action="/users/logout" class="login" name="loginform">
    <center>
      <b>Выход из системы</b>
      <br><br><br>
      <input type="submit" class="button-green" value="Выйти">
    </center>
        
  </form>
{else}
 <h1>Добро пожаловать на наш сайт!</h1>
  Для входа в свой аккаунт
  , введите ваш регистрационный логин и пароль, после аунтификации Вы попадете в свой профиль.
  <form method="post" action="" class="login" name="loginform">
    <center><b>Вход в систему</b></center>
    <br>
    <div class="note">
      <span class="note-text">Логин</span>
      <input type="text" style="width: 170px;" value="" maxlength="40" name="login">
    </div>
    <div class="note">
      <span class="note-text">Пароль</span>
      <input type="password" style="width: 170px;" value="" maxlength="40" name="pass">
    </div>
    <br>
    <center>
      <input class="button-green" type="submit" name="submit" value="Войти" />
      <br>
      <font size="1">
        Если Вы еще не зарегистрированы, &nbsp;
        <a href='/users/register'>зарегистрируйтесь в системе</a>.
      </font>
    </center>
  </form>
{/if}
{$sysMessage}
{/strip}


