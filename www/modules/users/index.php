<?php
class Index extends Controller
  {
  public $defaultAction = 'users_list';
  
  function users_list()
    {
    $this->getAccess(ACCESS_ADD);
    $this->usesModel('groups');
    
    $this->groups = $this->groups->group_list(false);
    $this->users = $this->users->user_list(true);
    $this->viewPage();
    //$this->viewJSON();
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
      $this->redirect('/sysUsers/users_list');
      }
    ////////////////////////////////////////////////////////////////////////////
     
    $user = $this->users->user($id);
    if($user)
      {
      $this->vars = $user;
      }
      
    $this->usesModel('groups');
    $this->groups = $this->groups->group_list();
    
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
        $this->showMessage('No Login');
        $this->redirect();
        }
      $this->showMessage('Login Success');
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
    $this->redirect();
    }
    
  function test()
    {
    $element = $this->users->getByIdOrderByuser_Displayname("'1', '3'");
    print_r($element);
    }
  }
?>
