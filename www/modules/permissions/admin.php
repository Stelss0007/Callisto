<?php
use app\modules\permissions\models\Permissions;
class AdminController extends Controller
  {
  var $defaultAction = 'permissions_list';
  
  function actionPermissionsList()
    {
    $this->getAccess(ACCESS_ADMIN);
    
    $this->assign('group_permission', Permissions::groupPermissionsList());
    $this->assign('levels', Permissions::permissionLevel());
    $this->assign('group', app\modules\groups\models\Groups::groupList());
    
    $browsein[] =array('url'=>"/admin/main", 'displayname'=>$this->t('dashboard'));
    $browsein[] =array('url'=>'', 'displayname'=>'Permissions');
    $this->assign('module_browsein', $browsein);
    
    $this->viewPage();
    }
    
  function actionManage($id=0)
    {
    $this->getAccess(ACCESS_ADMIN);
    
    $data = $this->inputVars;
    //print_r($data);exit;
    if($data['submit'])
      {
      if($id)
        {
         $permission = Permissions::find($id);
        }
      else
        {
        $permission = new Permissions;
        }
        
      $permission->setAttributesByArray($data);
      $permission->save();
      
      $this->redirect('/admin/permissions/permissions_list');
      }
    ////////////////////////////////////////////////////////////////////////////

    $this->assign('groups', \app\modules\groups\models\Groups::groupList());
    
    $browsein[] =array('url'=>"/admin/main", 'displayname'=>$this->t('dashboard'));
    $browsein[] =array('url'=>'/admin/permissions', 'displayname'=>'Permissions');  
  
    $this->assign('levels', Permissions::permissionLevel());
    $permission = Permissions::groupPermission($id);
    
    if($permission)
      {
      $this->assign('permission', $permission);
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
    
    $permission = Permissions::find($id);
    $permission->delete();
    
    $this->redirect();
    }
      
  function actionWeightUp($id)
    {  
    $this->getAccess(ACCESS_ADMIN);
    
    $permission = Permissions::find($id);
    $permission->weightUp();
    
    $this->redirect();
    }
    
  function actionWeightDown($id)
    { 
    $this->getAccess(ACCESS_ADMIN);
    
    $permission = Permissions::find($id);
    $permission->weightDown();
    
    $this->redirect();
    }
  }

