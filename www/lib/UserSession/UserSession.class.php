<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
namespace app\lib\UserSession;
/**
 * Description of UserSession
 *
 * @author Your Name <your.name at your.org>
 */
class UserSession 
  {
  /**
   * object
   * @var object 
   */
  private static $instance;
  private $prefix = '';
  
  /**
   * current user name
   * @var string 
   */
  private $user_name = '';
  /**
   * current user id
   * @var integer 
   */
  private $user_id = -1;
  private $user_gid = null;

  /**
   * Redeclsrated object
   * @return object 
   */
  public static function getInstance()
   {
     if (empty(self::$instance))
      {
      self::$instance = new self;
      }
     return self::$instance;
   }
   
  /**
   * Constructor 
   */ 
  public function __construct()
    {
    if(!isset($_SESSION))
      {
      session_start();
      }
    }
  
  /**
   * Set session directory
   * @param string $path src to session path
   * @return boolean
   */  
  public function setPath($path = false)
    {
    session_save_path($path);
    ini_set('session.gc_probability', 1);
    return true;
    }
  
    
  /**
   * User is Logedin?
   * @return boolean 
   */  
  public function isLogin()
    {
    if (isset($_SESSION['user']))
      {
      return true;
      }
    else
      {
      return false;
      }
    }

   /**
    * Create session / Authorize user 
    * @param array $user array('login(user_name)', 'id(user_id)', 'gid(user group id)')
    * @return boolean 
    */ 
   public function userLogin($user)
    {
    $this->user_name =  $user->login;
    $this->user_id = $user->id;
    $this->user_gid = $user->gid;
    
    $this->setVar('user_name', $this->user_name);
    $this->setVar('user_id', $this->user_id);
    $this->setVar('user_gid', $this->user_gid);
    return true;
    }

  /**
   * User logoun / destroy session
   * @return boolean 
   */
  public function userLogOut()
    {
    unset ($_SESSION['user']);
    unset ($_SESSION['user_id']);
    unset ($_SESSION['user_gid']);
    
    $this->user_name = null;
    $this->user_id = null;
    $this->user_gid = null;
    
    session_destroy();
    
    return true;
    }

  /**
   * Set var to session
   * @param string $var
   * @param mixed $value
   * @return boolean 
   */
  public function setVar($var, $value)
    {
    $_SESSION[$var] = json_encode($value);
    return true;
    }

  /**
   * Get var from session
   * @param string $var varname
   * @param mixed $default var value
   * @return type 
   */
  public function getVar($var, $default = false)
    {
    if(isset($_SESSION[$var]))
        {
        $data = json_decode($_SESSION[$var]);
        if(is_object($data) && isset($data->attributes))
            {
            $data = $data->attributes;
            }
        return  $data;
        }
    return $default;
    }

  /**
   * Delele variable from session
   * @param string $var
   * @return boolean 
   */
  public function delVar($var)
    {
    unset($_SESSION[$var]);
    return true;
    }

  /**
   * Get curent user ID
   * @return integer 
   */
  public function userId()
    {
    if(!empty($_SESSION['user_id']))
      return $this->getVar('user_id');
    return -1;
    }
    
  /**
   * Get curent user Name (login)
   * @return integer 
   */
  public function userName()
    {
    if(!empty($_SESSION['user']))
      return $this->getVar('user');
    return 'Unknown';
    }

  /**
   * Get curent user group ID (if user non authorized then return -1)
   * @return integer 
   */
  public function userGid()
    {
    if(!empty($_SESSION['user_gid']))
      return (int) $this->getVar('user_gid');
    return -1;
    }
}
