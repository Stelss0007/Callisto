<?php
namespace app\modules\users\models;
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
  public static function getList($full=false)
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

    $user =  self::find($id);
    return $user;
    }
     
  public static function logIn($login, $pass)
    {
    $pass = md5($pass);
   
    $user = self::findOne(['login'=>$login, 'pass'=>$pass, 'active'=>1]);
    
    if(empty($user))
      return false;
    $userSession = \app\lib\UserSession\UserSession::getInstance();
    $userSession->userLogin($user);
    return true;
    }
    
  public static function logOut()
    {
    $userSession = \app\lib\UserSession\UserSession::getInstance();
    $userSession->userLogOut();
    }
    
  public static function isLogin()
    {
    $userSession = \app\lib\UserSession\UserSession::getInstance();
    return $userSession->isLogin();
    }
    
  public static function userId()
    {
    $userSession = \app\lib\UserSession\UserSession::getInstance();
    return $userSession->userId();
    }
  public static function userGid()
    {
    $userSession = \app\lib\UserSession\UserSession::getInstance();  
    return $userSession->userGid();
    }
  }
?>
