<?php
namespace app\modules\users\models;
/** 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 * @Table('111') 
 */
//class users extends Model
class Users extends \app\db\ActiveRecord\Model
  {
  /**
   *
   * @Column(type='string', default='1', primaryKey = true) 
   * @Index(type='integer')
   */
  public static $tableName = 'user';
  
  private $session = null;
  
  /**
   * @id
   * @param type $full
   * @return type 
   */
  public static function userList($full=false)
    {
    $users = self::findAll();
    
    if($full)
      return $users;
    
    $result = array();
    foreach ($users as $user)
      {
      $result[$user->id] = $user->login;
      }
 
    return $result;
    }
    
  /**
   *
   * @Column(type='string', length=10) 
   * @Index(type='integer')
   */  
  public static function userView($id)
    {
    if(!is_numeric($id))
      return false;

    $user =  $this->find($id);
    return $user;
    }
     
  function logIn($login, $pass)
    {
    $pass = md5($pass);
   
    $user = $this->findOne(['login'=>$login, 'pass'=>$pass, 'active'=>1]);
    
    if(empty($user))
      return false;
    $userSession = \app\lib\UserSession\UserSession::getInstance();
    $userSession->userLogin($user);
    return true;
    }
    
  function logOut()
    {
    $userSession = \app\lib\UserSession\UserSession::getInstance();
    $userSession->userLogOut();
    }
    
  function isLogin()
    {
    $userSession = \app\lib\UserSession\UserSession::getInstance();
    return $userSession->isLogin();
    }
    
  function userId()
    {
    $userSession = \app\lib\UserSession\UserSession::getInstance();
    return $userSession->userId();
    }
  function userGid()
    {
    $userSession = \app\lib\UserSession\UserSession::getInstance();  
    return $userSession->userGid();
    }
  }
?>
