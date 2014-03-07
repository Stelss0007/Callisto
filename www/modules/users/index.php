<?php
class IndexController extends Controller
  {
  public $defaultAction = 'users_list';
  
  function usersList()
    {
//    $params = array(
//                    'fields' => '',
//                    'limit' => 4,
//                    'offset' => 0,
//                    'order' => 'id',
////                    'condition' => "id > :id1 and id < :id2", 
//                    'condition' => array('id'=>array('8', '4')), 
//                    'params' => array(':id1'=>5, ':id2'=>10)
//                    );
//    //appDebug($this->users->getFirst());exit;
//    //appDebug($this->users->getLast());exit;
//    appDebug($this->users->getCount($params));
//    appDebug($this->users->getList($params));exit;
    
    
//        $annotation = $this->usesLib('Annotations');
//        $annotation->setClass('users');
//        appDebug($annotation->fieldsAnnotations);
//        appDebug($annotation->methodsAnnotations);
//
//        exit;
    
    
    $this->getAccess(ACCESS_ADD);
    $this->usesModel('groups');
 
    $this->groups_list = $this->groups->group_list(false);
    //print_r($this->groups->group_list(false));exit;
    $this->users_list = $this->users->user_list(true);
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
      $this->redirect('/users/users_list');
      }
    ////////////////////////////////////////////////////////////////////////////
     
    $user = $this->users->user($id);
    if($user)
      {
      $this->vars = $user;
      }
      
    $this->usesModel('groups');
    $this->groups_list = $this->groups->group_list();
    
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
