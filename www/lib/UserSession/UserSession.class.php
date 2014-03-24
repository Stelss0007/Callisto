<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

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
  static $instance;
  var $prefix = '';
  
  /**
   * current user name
   * @var string 
   */
  var $user_name = '';
  /**
   * current user id
   * @var integer 
   */
  var $user_id = -1;
  var $user_gid = null;

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
  function __construct()
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
  function setPath($path = false)
    {
    session_save_path($path);
    ini_set('session.gc_probability', 1);
    return true;
    }
  
    
  /**
   * User is Logedin?
   * @return boolean 
   */  
  function isLogin()
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
    * @param array $array array('login(user_name)', 'id(user_id)', 'gid(user group id)')
    * @return boolean 
    */ 
   function userLogin($array)
    {
    $this->user_name = $_SESSION['user'] = $array['login'];
    $this->user_id = $_SESSION['user_id'] = $array['id'];
    $this->user_gid = $_SESSION['user_gid'] = $array['gid'];
    return true;
    }

  /**
   * User logoun / destroy session
   * @return boolean 
   */
  function userLogOut()
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
  function setVar($var, $value)
    {
    $_SESSION[$var] = $value;
    return true;
    }

  /**
   * Get var from session
   * @param string $var varname
   * @param mixed $default var value
   * @return type 
   */
  function getVar($var, $default = false)
    {
    return isset($_SESSION[$var]) ? $_SESSION[$var] : $default;
    }

  /**
   * Delele variable from session
   * @param string $var
   * @return boolean 
   */
  function delVar($var)
    {
    unset($_SESSION[$var]);
    return true;
    }

  /**
   * Get curent user ID
   * @return integer 
   */
  function userId()
    {
    if($_SESSION['user_id'])
      return $_SESSION['user_id'];
    return -1;
    }

  /**
   * Get curent user group ID (if user non authorized then return -1)
   * @return integer 
   */
  function userGid()
    {
    if($_SESSION['user_gid'])
      return $_SESSION['user_gid'];
    return -1;
    }
}
?>
