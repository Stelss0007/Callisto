<?php
class Index extends Controller
  {
  var $defaultAction = 'permissions_list';
  
  function permissions_list()
    {
    $this->usesModel('groups');
    
    $this->group_permission = $this->permissions->group_permissions_list();
    $this->levels = $this->permissions->permission_level();
    
    $this->group = $this->groups->group_list();
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
        $this->permissions->group_permissions_update($data, $id);
        }
      else
        {
        $this->permissions->group_permissions_create($data);
        }
      $this->redirect('/permissions/permissions_list');
      }
    ////////////////////////////////////////////////////////////////////////////
    
    $this->usesModel('groups');
    $this->groups = $this->groups->group_list();
    
    
  
    $this->levels = $this->permissions->permission_level();
    $permission = $this->permissions->group_permission($id);
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
    
    $this->permissions->group_permission_delete($id);
    $this->redirect();
    }
    
  function permission_weight_up($weight)
    {  
    $this->permissions->weightUp($weight);
    $this->redirect();
    }
    
  function permission_weight_down($weight)
    {  
    $this->permissions->weightDown($weight);
    $this->redirect();
    }
  }
?>
