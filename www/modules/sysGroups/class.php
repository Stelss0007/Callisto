<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class SysGroups extends Model
  {
  var $table = 'sys_group';
  
  function group_list($full=false)
    {
    $result = array();
    $this->query("SELECT * FROM sys_group ORDER BY group_displayname");
    $groups = $this->fetch_array();
    if($full)
      return $groups;
    
    foreach ($groups as $group)
      {
      $result[$group['id']] = $group['group_displayname'];
      }
    return $result;
    }
    
  function group($id)
    {
    if(!is_numeric($id))
      return false;
    
    $this->query("SELECT * FROM sys_group WHERE id='$id'");
    $group =  $this->fetch_array();
    return $group[0];
    }
    
  function group_create($data)
    {
    $this->insert($this->table, $data);
    }
    
  function group_update($data, $id)
    {
    if(!is_numeric($id))
      return false;
    
    $this->update($this->table, $data, "id = '$id'");
    }
    
  function group_delete($id)
    {
    if(!is_numeric($id))
      return false;

    $this->query("DELETE FROM sys_group WHERE id='$id'");
    }
  }
?>
