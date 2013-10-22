<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class Permissions extends Model
  {
  var $table = 'group_permission';
  
  function group_permissions_list()
    {
    $this->query("SELECT * FROM {$this->table} ORDER BY {$this->table}_weight");
    return $this->fetch_array();
    }
    
  function group_permission($id)
    {
    if(!is_numeric($id))
      return false;
    
    $this->query("SELECT * FROM {$this->table} WHERE id='$id'");
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
    $data["{$this->table}_weight"] = $this->weightMax()+1;
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
    $this->weightDelete($group_permision["{$this->table}_weight"], $where);
    $this->query("DELETE FROM {$this->table} WHERE id='$id'");
    }
    
    
  function getAccess($obj_name, $level)
    {
    $ses_info=UserSession::getInstance();
    $gid = $ses_info->userGid();
    $perms_list = $this->groupPermsGetList($gid);

    if(empty($perms_list))
      return false;

    foreach($perms_list as $key=>$permission)
      {
      $this_pattern = $permission["{$this->table}_pattern"];
      $pattern = "/$this_pattern/Ui";
      if(preg_match($pattern, $obj_name))
        {
        if($level<=$permission["{$this->table}_level"])
          {
          print_r($perms_list[$key]);
          return true;
          }
        return false;
        }
      }
    return false;
    }
   
  function groupPermsGetList($gid=null)
    {
    $params = array(
                    'condition' => array("{$this->table}_gid" => $gid),
                    'order' => "{$this->table}_weight"
                    );
    
    return $this->getList($params);
    }
  }
?>
