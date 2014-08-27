<?php
class AdminController extends Controller
  {
  var $defaultAction = 'permissions_list';
  
  function actionPermissionsList()
    {
    $this->getAccess(ACCESS_ADMIN);
    
    $this->usesModel('groups');
    
    $this->group_permission = $this->permissions->groupPermissionsList();
    $this->levels = $this->permissions->permissionLevel();
   
    $this->assign('group', $this->groups->group_list());
    
    $browsein[] =array('url'=>"/admin/main", 'displayname'=>$this->t('dashboard'));
    $browsein[] =array('url'=>'', 'displayname'=>'Permissions');
    $this->assign('module_browsein', $browsein);
    
    $this->viewPage();
    }
    
  function actionManage($id=0)
    {
    $this->getAccess(ACCESS_ADMIN);
    
    $data = $this->input_vars;
    //print_r($data);exit;
    if($data['submit'])
      {
      if($id)
        {
        $this->permissions->groupPermissionsUpdate($data, $id);
        }
      else
        {
        $this->permissions->groupPermissionsCreate($data);
        }
      $this->redirect('/admin/permissions/permissions_list');
      }
    ////////////////////////////////////////////////////////////////////////////
    
    $this->usesModel('groups');
    $this->assign('groups', $this->groups->group_list());
    
    $browsein[] =array('url'=>"/admin/main", 'displayname'=>$this->t('dashboard'));
    $browsein[] =array('url'=>'/admin/permissions', 'displayname'=>'Permissions');  
  
    $this->levels = $this->permissions->permissionLevel();
    $permission = $this->permissions->groupPermission($id);
    
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
    
  function actionDelete($id=0)
    {
    $this->getAccess(ACCESS_ADMIN);
    
    if(empty($id))
      $this->errors->setError("ID of Permission is missing!");
    
    $this->permissions->groupPermissionDelete($id);
    $this->redirect();
    }
      
  function actionWeightUp($weight)
    {  
    $this->getAccess(ACCESS_ADMIN);
    
    $this->permissions->weightUp($weight);
    $this->redirect();
    }
    
  function actionWeightDown($weight)
    { 
    $this->getAccess(ACCESS_ADMIN);
    
    $this->permissions->weightDown($weight);
    $this->redirect();
    }
  }

