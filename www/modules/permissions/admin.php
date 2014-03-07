<?php
class AdminController extends Controller
  {
  var $defaultAction = 'permissions_list';
  
  function permissionsList()
    {
    $this->usesModel('groups');
    
    $this->group_permission = $this->permissions->group_permissions_list();
    $this->levels = $this->permissions->permission_level();
   
    $this->assign('group', $this->groups->group_list());
    
    $browsein[] =array('url'=>"/admin/main", 'displayname'=>'Dashboard');
    $browsein[] =array('url'=>'', 'displayname'=>'Permissions');
    $this->assign('module_browsein', $browsein);
    
    $this->viewPage();
    }
    
  function manage($id=0)
    {
    $data = $this->input_vars;
    //print_r($data);exit;
    if($data['submit'])
      {
      if($id)
        {
        $this->permissions->group_permissions_update($data, $id);
        }
      else
        {
        $this->permissions->group_permissions_create($data);
        }
      $this->redirect('/admin/permissions/permissions_list');
      }
    ////////////////////////////////////////////////////////////////////////////
    
    $this->usesModel('groups');
    $this->assign('groups', $this->groups->group_list());
    
    $browsein[] =array('url'=>"/admin/main", 'displayname'=>'Dashboard');
    $browsein[] =array('url'=>'/admin/permissions', 'displayname'=>'Permissions');  
  
    $this->levels = $this->permissions->permission_level();
    $permission = $this->permissions->group_permission($id);
    
    if($permission)
      {
      $this->assign($permission);
      $browsein[] =array('url'=>'', 'displayname'=>'Edit');
      }
    else
      {
      $browsein[] =array('url'=>'', 'displayname'=>'Add');
      }
    
    $this->assign('module_browsein', $browsein);
    
    $this->viewPage();
    }
    
  function delete($id=0)
    {
    if(empty($id))
      $this->errors->setError("ID of Permission is missing!");
    
    $this->permissions->group_permission_delete($id);
    $this->redirect();
    }
      
  function permissionWeightUp($weight)
    {  
    $this->permissions->weightUp($weight);
    $this->redirect();
    }
    
  function permissionWeightDown($weight)
    {  
    $this->permissions->weightDown($weight);
    $this->redirect();
    }
  }
?>
