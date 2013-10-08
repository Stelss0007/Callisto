<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class users extends Model
  {
  var $table = 'user';
  
  function user_list($full=false)
    {
    $result = array();
    $this->query("SELECT * FROM user ORDER BY login");
    $users = $this->fetch_array();
    if($full)
      return $users;
    
    foreach ($users as $user)
      {
      $result[$user['id']] = $user['login'];
      }
    return $result;
    }
    
  function user($id)
    {
    if(!is_numeric($id))
      return false;
    
    $this->query("SELECT * FROM user WHERE id='$id'");
    $user =  $this->fetch_array();
    return $user[0];
    }
    
  function user_create($data)
    {
    if($data['pass'])
      $data['pass'] = md5($data['pass']);
    
    $this->insert($this->table, $data);
    }
    
  function user_update($data, $id)
    {
    if(!is_numeric($id))
      return false;
    if($data['pass'])
      $data['pass'] = md5($data['pass']);
    
    $this->update($this->table, $data, "id = '$id'");
    }
    
  function user_delete($id)
    {
    if(!is_numeric($id))
      return false;

    $this->query("DELETE FROM user WHERE id='$id'");
    }
    
  function user_activation($id)
    {
    if(!is_numeric($id))
      return false;

    $this->query("UPDATE user SET active = IF(active ='1','0','1') WHERE id='$id'");
    }
    
  function logIn($login, $pass)
    {
    $pass = md5($pass);
    $this->query("SELECT * FROM user WHERE login='%s' AND pass='%s' AND active = '1'", $login, $pass);
    $user =  $this->fetch_array();
    
    if(empty($user))
      return false;
    
    $this->session->userLogin($user[0]);
    return true;
    }
    
  function logOut()
    {
    $this->session->userLogOut();
    }
    
  function isLogin()
    {
    return $this->session->isLogin();
    }
    
  function userId()
    {
    return $this->session->userId();
    }
  function userGid()
    {
    return $this->session->userGid();
    }
  }
?>
