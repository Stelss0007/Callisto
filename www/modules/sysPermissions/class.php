<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class SysPermissions extends Model
  {
  var $table = 'sys_user_group_permission';
  
  function group_permissions_list()
    {
    $this->query("SELECT * FROM sys_user_group_permission ORDER BY weight");
    return $this->fetch_array();
    }
    
  function group_permission($id)
    {
    if(!is_numeric($id))
      return false;
    
    $this->query("SELECT * FROM sys_user_group_permission WHERE id='$id'");
    $permission =  $this->fetch_array();
    return $permission[0];
    }
  
  function permission_level($level=false)
    {
    $levels = array();
    $levels[ACCESS_INVALID] = 'ACCESS INVALID';
    $levels[ACCESS_NONE] = 'ACCESS NONE';
    $levels[ACCESS_OVERVIEW] = 'ACCESS OVERVIEW';
    $levels[ACCESS_READ] = 'ACCESS READ';
    $levels[ACCESS_COMMENT] = 'ACCESS COMMENT';
    $levels[ACCESS_ADD] = 'ACCESS ADD';
    $levels[ACCESS_EDIT] = 'ACCESS EDIT';
    $levels[ACCESS_DELETE] = 'ACCESS DELETE';
    $levels[ACCESS_ADMIN] = 'ACCESS ADMIN';
    
    if($level !==false && $levels[$level])
      return $levels[$level];
    
    return $levels;
    }
  function group_permissions_create($data)
    {
    $data['weight'] = $this->weightMax()+1;
    $this->insert($this->table, $data);
    }
    
  function group_permissions_update($data, $id)
    {
    if(!is_numeric($id))
      return false;
    
    $this->update($this->table, $data, "id = '$id'");
    }
    
  function group_permission_delete($id)
    {
    if(!is_numeric($id))
      return false;
    $group_permision = $this->group_permission($id);
    $this->weightDelete($group_permision['weight'], $where);
    $this->query("DELETE FROM sys_user_group_permission WHERE id='$id'");
    }
  }
?>
