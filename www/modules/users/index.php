<?php
class IndexController extends Controller
  {
  function actionIndex()
    {
    $this->redirect('/admin/users');
    }
  
  function actionLogin()
    {
    $data = $this->inputVars;
    if($data['submit'])
      {
      $login = $this->users->logIn($data['login'], $data['pass']);
      if(empty($login))
        {
        $this->showMessage($this->t('no_user_pass'), null, null, MESSAGE_ERROR);
        $this->redirect();
        }
      $this->showMessage($this->t('login_success'));
      $this->redirect();
      }
      
    if($this->users->isLogin())
      {
      $this->isLogin = true;
      }
    else
      {
      $this->isLogin = false;
      }  
    $this->viewPage();
    }
  }

