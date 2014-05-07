<?php
class AdminController extends Controller
  {
  public $defaultAction = 'groups_list';
  
  function actionGroupsList()
    {
    $this->groups_list = $this->groups->group_list(true);
    
    $browsein[] =array('url'=>"/admin/main", 'displayname'=>'Dashboard');
    $browsein[] =array('url'=>'', 'displayname'=>'Groups');
    $this->assign('module_browsein', $browsein);
    
    $this->viewPage();
    }
    
  function actionManage($id=0)
    {
    $data = $this->input_vars;

    if($data['submit'])
      {
      if($id)
        {
        $this->groups->group_update($data, $id);
        }
      else
        {
        $this->groups->group_create($data);
        }
      $this->redirect('/admin/groups/groups_list');
      }
    ////////////////////////////////////////////////////////////////////////////
    $browsein[] =array('url'=>"/admin/main", 'displayname'=>'Dashboard');
    $browsein[] =array('url'=>'/admin/groups', 'displayname'=>'Groups');  
   
      
    $group = $this->groups->getById($id);
    if($group)
      {
      $this->assign($group);
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
    if(empty($id))
      $this->errors->setError("ID of Group is missing!");
    
    $this->groups->group_delete($id);
    $this->redirect();
    }
    
//  function groupOperation()
//    {
//    $data = $this->input_vars;
// 
//    switch($data['action_name'])
//      {
//      case 'delete':
//        foreach($data['entities'] as $id)
//          {
//          $this->groups->group_delete($id);
//          }
//        $this->showMessage("Элементы успешно удалены");
//        break;
//      case 'activate':
//          $this->groups->user_group_active($data['entities']);
//          $this->showMessage("Элементы успешно удалены");
//        break;
//
//      default:
//        break;
//      }
//    }
    
  function actionTest()
    {
    $element = $this->groups->getByIdOrderByGroup_Displayname("'1', '3'");
    print_r($element);
    }
  }

