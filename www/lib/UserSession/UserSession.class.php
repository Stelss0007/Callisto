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

  static $instance;
  
  var $user_name = '';
  var $user_id = null;
  var $user_gid = null;

  public static function getInstance()
   {
     if (empty(self::$instance))
      {
      self::$instance = new self;
      }
     return self::$instance;
   }
   
  function __construct()
    {
    if(!isset($_SESSION))
      {
      session_start();
      }
    }
  
  function setPath($path = false)
    {
    session_save_path($path);
    ini_set('session.gc_probability', 1);
    }
    
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

   function userLogin($array)
    {
    $this->user_name = $_SESSION['user']=$array['login'];
    $this->user_id = $_SESSION['user_id']=$array['id'];
    $this->user_gid = $_SESSION['user_gid']=$array['gid'];
    return true;
    }

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

  function setVar($var, $value)
    {
    $_SESSION[$var] = $value;
    return true;
    }

  function getVar($var, $default = false)
    {
    return isset($_SESSION[$var]) ? $_SESSION[$var] : $default;
    }

  function delVar($var)
    {
    unset($_SESSION[$var]);
    return true;
    }


  function userId()
    {
    return $_SESSION['user_id'];
    }

  function userGid()
    {
    if($_SESSION['user_gid'])
      return $_SESSION['user_gid'];
    return -1;
    }
}
?>
