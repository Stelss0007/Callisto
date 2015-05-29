<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class Permissions extends Model
  {
  var $table = 'group_permission';
  
  function groupPermissionsList()
    {
    $this->query("SELECT * FROM {$this->table} ORDER BY {$this->table}_weight");
    return $this->fetchArray();
    }
    
  function groupPermission($id)
    {
    if(!is_numeric($id))
      return false;
    
    $this->query("SELECT * FROM {$this->table} WHERE id='$id'");
    $permission =  $this->fetchArray();
    return $permission[0];
    }
  
  function permissionLevel($level=false)
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
  function groupPermissionsCreate($data)
    {
    $data["{$this->table}_weight"] = $this->weightMax()+1;
    $this->insert($this->table, $data);
    }
    
  function groupPermissionsUpdate($data, $id)
    {
    if(!is_numeric($id))
      return false;
    
    $this->update($this->table, $data, "id = '$id'");
    }
    
  function groupPermissionDelete($id)
    {
    if(!is_numeric($id))
      return false;
    $group_permision = $this->groupPermission($id);
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
          //print_r($perms_list[$key]);
          return true;
          }
        return false;
        }
      }
    return false;
    }
   
    
/**
 * @desc Считаем уровень доступа текушего пользователя к тестируемому обьекту
 * @return integer
 * @param testobject string
 * @param ownerid int
 */
function objectGetPermsLevel ($object, $ownerid=-1)
  {
  if (!$object) 
    {
    die('$object is empty');
    }

  static $loaded = array();
  if (!empty($loaded["$object, $ownerid"]))
    return $loaded["$object, $ownerid"];

  $level = ACCESS_INVALID;

  $ses_info=UserSession::getInstance();
  $gid = $ses_info->userGid();
  
  
	if (!isset($groups_perms_list))
		{
    $groups_perms_list = $this->groupPermsGetList($gid);
		appVarSetCached('core', 'groups_perms_list', $groups_perms_list);
		}

  if ($groups_perms_list)
    {
    foreach ($groups_perms_list as $permission)
      {
      if (($permission['group_permission_gid']!=$gid) && ($permission['group_permission_gid']!=-1))
        continue;

      if (isset($permission['component']) && $permission['component']) 
        $pattern="/^$permission[component]::$permission[group_permission_pattern]/Ui";
      else 
            $pattern="/^.*::$permission[group_permission_pattern]/Ui";
      if (preg_match ($pattern, $object))
        {
        if ($permission['group_permission_level'] > $level) 
          $level = $permission['group_permission_level'];
        break;
        }
      }
    }


  //Права владельцев
  if (($ownerid>-1) && ($ownerid==$uid))
    {
    $level = ACCESS_DELETE;
    }

  $loaded["$object, $ownerid"] = $level;
 
  return $level;
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
