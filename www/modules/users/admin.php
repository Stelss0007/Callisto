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
  function index()
    {
    $this->redirect('/admin/users/users_list');
    }
  function users_list()
    {
    $this->getAccess(ACCESS_ADD);
    $this->usesModel('groups');
 
    $this->groups_list = $this->groups->group_list(false);
    $this->users_list = $this->users->user_list(true);
    
    $browsein[] =array('url'=>"/admin/main", 'displayname'=>'Dashboard');
    $browsein[] =array('url'=>'', 'displayname'=>'Users');
    
    $this->assign('module_browsein', $browsein);
    
    $this->viewPage();
    }
    
  function manage($id=0)
    {
    $data = $this->input_vars;
    
    if($data['submit'])
      {
      if($id)
        {
        if(empty($data['pass']))
          unset($data['pass']);

        $this->users->user_update($data, $id);
        }
      else
        {
        $this->users->user_create($data);
        }
   
      $this->redirect('/users/users_list');
      }
    ////////////////////////////////////////////////////////////////////////////
    
    $browsein[] =array('url'=>"/admin/main", 'displayname'=>'Dashboard');
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
    
  function delete($id=0)
    {
    if(empty($id))
      $this->errors->setError("ID of user is missing!");
    
    $this->users->user_delete($id);
    $this->redirect();
    }
    
  function activation($id=0)
    {
    if(empty($id))
      $this->errors->setError("ID of user is missing!");
    
    $this->users->user_activation($id);
    $this->redirect();
    }
    
    
  function login()
    {

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
    
  function logout()
    {
    $this->users->logOut();
    $this->showMessage($this->t('login_success'));
    $this->redirect();
    }
    
  function test()
    {
    $element = $this->users->getByIdOrderByuser_Displayname("'1', '3'");
    print_r($element);
    }
  }

?>
