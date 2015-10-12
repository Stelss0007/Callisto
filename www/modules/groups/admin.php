<?php
use app\modules\groups\models\Groups;

class AdminController extends Controller
  {
  public $defaultAction = 'groups_list';
  
  function actionGroupsList()
    {
    $this->getAccess(ACCESS_ADMIN);
    
    $this->groups_list = Groups::groupList(true);
    
    $browsein[] =array('url'=>"/admin/main", 'displayname'=>$this->t('dashboard'));
    $browsein[] =array('url'=>'', 'displayname'=>'Groups');
    $this->assign('module_browsein', $browsein);
    
    $this->viewPage();
    }
    
  function actionManage($id=0)
    {
    $this->getAccess(ACCESS_ADMIN);
    
    $data = $this->inputVars;

    if($data['submit'])
      {
      if($id)
        {
        $group = Groups::find($id);
        }
      else
        {
        $group = new Groups();
        }
        
      $group->setAttributesByArray($data);
      $group->save();
      
      $this->redirect('/admin/groups/groups_list');
      }
    ////////////////////////////////////////////////////////////////////////////
    $browsein[] =array('url'=>"/admin/main", 'displayname'=>$this->t('dashboard'));
    $browsein[] =array('url'=>'/admin/groups', 'displayname'=>'Groups');  
   
      
    $group = Groups::find($id);
    
    if($group)
      {
      $this->assign('group', $group);
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
      $this->errors->setError("ID of Group is missing!");
    
    $group = Groups::find($id);
    $group->delete();
    
    $this->redirect();
    }
  }

