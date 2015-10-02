<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of admin
 *
 * @author Your Name <your.name at your.org>
 */
class AdminController extends Controller
  {
  function actionIndex()
    {
    $this->getAccess(ACCESS_ADMIN);
    
    $this->redirect('/admin/users/users_list');
    }
  function actionUsersList()
    {
    $this->getAccess(ACCESS_ADMIN);
    
    $this->usesModel('groups');
    //print_r(app\modules\users\models\users::findAll()); exit;
    $this->groups_list = $this->groups->group_list(false);
    $this->users_list = $this->users->userList(true);
    
    $browsein[] =array('url'=>"/admin/main", 'displayname'=>$this->t('dashboard'));
    $browsein[] =array('url'=>'', 'displayname'=>'Users');
    
    $this->assign('module_browsein', $browsein);
    
    $this->viewPage();
    }
    
  function actionManage($id=0)
    {
    $this->getAccess(ACCESS_ADD);
    $data = $this->input_vars;
    
    if($data['submit'])
      {
      if($id)
        {
        if(empty($data['pass']))
          unset($data['pass']);

        $this->users->userUpdate($data, $id);
        }
      else
        {
        $this->users->userCreate($data);
        }
   
      $this->redirect('/admin/users/users_list');
      }
    ////////////////////////////////////////////////////////////////////////////
    
    $browsein[] =array('url'=>"/admin/main", 'displayname'=>$this->t('dashboard'));
    $browsein[] =array('url'=>'/admin/users', 'displayname'=>'Users');  
   
    
    $user = $this->users->user($id);
    if($user)
      {
      $this->vars = $user;
      $browsein[] =array('url'=>'', 'displayname'=>'Edit');  
      }
    else
      {
      $browsein[] =array('url'=>'', 'displayname'=>'Add');  
      }
      
    $this->usesModel('groups');
    $this->groups_list = $this->groups->group_list();
    
    $this->assign('module_browsein', $browsein);
     
    $this->viewPage();
    }
    
  function actionDelete($id=0)
    {
    $this->getAccess(ACCESS_DELETE);
    
    if(empty($id))
      $this->errors->setError("ID of user is missing!");
    
    $this->users->userDelete($id);
    $this->redirect();
    }
    
  function actionActivation($id=0)
    {
    $this->getAccess(ACCESS_ADMIN);
    
    if(empty($id))
      $this->errors->setError("ID of user is missing!");
    
    $this->users->userActivation($id);
    $this->redirect();
    }
    
    
  function actionLogin()
    {
    //$this->getAccess(ACCESS_READ);
    $data = $this->input_vars;
    if($data['submit'])
      {
      $login = $this->users->logIn($data['login'], $data['pass']);
     
      if(empty($login))
        {
        $this->showMessage($this->t('no_user_pass'), null, null, MESSAGE_ERROR);
        $this->redirect();
        }
      $this->showMessage($this->t('login_success'));
      $this->redirect('/admin/main');
      }
      
    if($this->users->isLogin())
      {
      $this->isLogin = true;
      }
    else
      {
      $this->isLogin = false;
      }  
    $this->viewPage('login-page');
    }
    
  function actionLogout()
    {
    $this->users->logOut();
    $this->showMessage($this->t('login_success'));
    $this->redirect();
    }
      
  function actionTest()
    {
    $element = $this->users->getByIdOrderByuser_Displayname("'1', '3'");
    print_r($element);
    }
  }

?>
