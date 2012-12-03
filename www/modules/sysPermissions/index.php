<?php
class Index extends Controller
  {
 
  function permissions_list()
    {
    $this->usesModel('sysGroups');
    
    $this->group_permission = $this->sysPermissions->group_permissions_list();
    $this->levels = $this->sysPermissions->permission_level();
    
    $this->group = $this->sysGroups->group_list();
    $this->viewPage();
    }
    
  function manage($id=0)
    {
    $data = $this->input_vars;
    //print_r($data);exit;
    if($data[submit])
      {
      if($id)
        {
        $this->sysPermissions->group_permissions_update($data, $id);
        }
      else
        {
        $this->sysPermissions->group_permissions_create($data);
        }
      $this->redirect('/sysPermissions/permissions_list');
      }
    ////////////////////////////////////////////////////////////////////////////
    
    $this->usesModel('sysGroups');
    $this->groups = $this->sysGroups->group_list();
    
    
  
    $this->levels = $this->sysPermissions->permission_level();
    $permission = $this->sysPermissions->group_permission($id);
    if($permission)
      {
      $this->id = $permission['id'];
      $this->gid = $permission['gid'];
      $this->level = $permission['level'];
      $this->pattern = $permission['pattern'];
      $this->description = $permission['description'];
      }
       
    $this->viewPage();
    }
    
  function delete($id=0)
    {
    if(empty($id))
      $this->errors->setError("ID of Permission is missing!");
    
    $this->sysPermissions->group_permission_delete($id);
    $this->redirect();
    }
    
  function permission_weight_up($weight)
    {  
    $this->sysPermissions->weightUp($weight);
    $this->redirect();
    }
    
  function permission_weight_down($weight)
    {  
    $this->sysPermissions->weightDown($weight);
    $this->redirect();
    }
  }
?>
