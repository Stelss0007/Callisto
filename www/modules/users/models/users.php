<?php
/** 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 * @Table('111') 
 */
class users extends Model
  {
  /**
   *
   * @Column(type='string', default='1', primaryKey = true) 
   * @Index(type='integer')
   */
  var $table = 'user';
  
  /**
   * @id
   * @param type $full
   * @return type 
   */
  function user_list($full=false)
    {
    $result = array();
    $this->query("SELECT * FROM user ORDER BY login");
    $users = $this->fetchArray();
    if($full)
      return $users;
    
    foreach ($users as $user)
      {
      $result[$user['id']] = $user['login'];
      }
    return $result;
    }
    
  /**
   *
   * @Column(type='string', length=10) 
   * @Index(type='integer')
   */  
  function user($id)
    {
    if(!is_numeric($id))
      return false;
    
    $this->query("SELECT * FROM user WHERE id='$id'");
    $user =  $this->fetchArray();
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
    
  function user_group_active($ids)
    {
    if(empty($ids))
      return false;
    $ids = implode("','", $ids);
    $this->query("UPDATE user SET active = '1' WHERE id in ('$ids')");
    }
    
  function user_group_deactive($ids)
    {
    if(empty($ids))
      return false;
    $ids = implode("','", $ids);
    $this->query("UPDATE user SET active = '0' WHERE id in ('$ids')");
    }
    
  function logIn($login, $pass)
    {
    $pass = md5($pass);
    $this->query("SELECT * FROM user WHERE login='%s' AND pass='%s' AND active = '1'", $login, $pass);
    $user =  $this->fetchArray();
    
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
