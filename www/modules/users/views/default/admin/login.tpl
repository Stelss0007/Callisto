{strip}
{if $isLogin}
  <div class="wrapper">
    <form class="form-signin" action="/admin/users/logout" name="loginform">  
      <a href='/admin/main' class="glyphicon glyphicon-home"></a>
      <h2 class="form-signin-heading">{#sys_deauthorization#}</h2>
      {#sys_deauthorization_text#}   
      &nbsp;
      <button class="btn btn-lg btn-primary btn-block" type="submit"  name="submit" value="1">{#sys_logout#}</button>   
    </form>
  </div>
{else}
   <div class="wrapper">
     <form class="form-signin" action="" method="post" name="loginform"> 
      <a href='/' class="glyphicon glyphicon-home"></a>
      <h2 class="form-signin-heading">{#sys_authorization#}</h2>
      <div class="input-group">
        <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
        <input type="text" class="form-control" name="login" placeholder="{#sys_placeholder_login#}" required="" autofocus="" />
      </div>
      
      <div class="input-group">
        <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
        <input type="password" class="form-control" name="pass" placeholder="{#sys_placeholder_password#}" required=""/> 
      </div>
      <label class="checkbox">
        <input type="checkbox" value="remember-me" id="rememberMe" name="rememberMe"> {#sys_remember_me#}
      </label>
      <button class="btn btn-lg btn-primary btn-block" type="submit" name="submit" style="width: 100%;" value="1">{#sys_login#}</button>   
    </form>
  </div>
{/if}
{$sysMessage}
{/strip}


