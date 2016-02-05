<?php
use app\modules\users\models\Users;
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
    
    //$this->usesModel('groups');
    //print_r(app\modules\users\models\users::findAll()); exit;
    $this->groups_list = app\modules\groups\models\Groups::groupList(false);
    $this->users_list = Users::getList(true);
 //print_r(app\modules\groups\models\Groups::groupList(false));exit;   
    $browsein[] =array('url'=>"/admin/main", 'displayname'=>$this->t('dashboard'));
    $browsein[] =array('url'=>'', 'displayname'=>'Users');
    
    $this->assign('module_browsein', $browsein);
    
    $this->viewPage();
    }
    
  function actionManage($id=0)
    {
    $this->getAccess(ACCESS_ADD);
    $data = $this->inputVars;
    
    if($data['submit'])
      {
      if($id)
        {
        $user = Users::find($id);
        if(empty($data['pass']))
            {
            unset($data['pass']);
            }
        else
            {
            $data['pass'] = md5($data['pass']);
            }
        
        }
      else
        {
        $data['pass'] = md5($data['pass']);
        
        $user = new Users();
        }
        
      $user->setAttributesByArray($data);
      $user->save();
        
      $this->redirect('/admin/users/users_list');
      }
    ////////////////////////////////////////////////////////////////////////////
    
    $browsein[] =array('url'=>"/admin/main", 'displayname'=>$this->t('dashboard'));
    $browsein[] =array('url'=>'/admin/users', 'displayname'=>'Users');  
   
    
    $user = Users::find($id);

    if($user)
      {
      $this->assign('user', $user);
      $browsein[] =array('url'=>'', 'displayname'=>'Edit');  
      }
    else
      {
      $browsein[] =array('url'=>'', 'displayname'=>'Add');  
      }

    $this->groups_list = app\modules\groups\models\Groups::groupList();
    
    $this->assign('module_browsein', $browsein);
     
    $this->viewPage();
    }
    
  function actionDelete($id=0)
    {
    $this->getAccess(ACCESS_DELETE);
    
    if(empty($id))
      $this->errors->setError("ID of user is missing!");
    
    $user = Users::find($id);
    $user->delete();
    
    $this->redirect();
    }
    
  function actionActivation($id=0)
    {
    $this->getAccess(ACCESS_ADMIN);
    
    if(empty($id))
      $this->errors->setError("ID of user is missing!");
    
    Users::activation($id);
    
    $this->redirect();
    }
    
    
  function actionLogin()
    {
    //$this->getAccess(ACCESS_READ);
    $data = $this->inputVars;
    if($data['submit'])
      {
      $user = new Users();  
      $login = $user->logIn($data['login'], $data['pass']);
     
      if(empty($login))
        {
        $this->showMessage($this->t('no_user_pass'), null, null, MESSAGE_ERROR);
        $this->redirect();
        }
      $this->showMessage($this->t('login_success'));
      $this->redirect('/admin/main');
      }
      
    if(Users::isLogin())
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
    Users::logOut();
    $this->showMessage($this->t('login_success'));
    $this->redirect();
    }
  }

?>
