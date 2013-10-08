<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class Groups extends Model
  {
  var $table = '`group`';
  
  function group_list($full=false)
    {
    $result = array();
    $this->query("SELECT * FROM `group` ORDER BY group_displayname");
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
    
    $this->query("SELECT * FROM `group` WHERE id='$id'");
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

    $this->query("DELETE FROM `group` WHERE id='$id'");
    }
  }
?>
