<?php
class IndexController extends Controller
  {
  public $defaultAction = 'groups_list';
  
  function actionGroupsList()
    {
    $this->groups_list = $this->groups->group_list(true);
    $this->viewPage();
    }
    
  function actionManage($id=0)
    {
    $data = $this->input_vars;

    if($data[submit])
      {
      if($id)
        {
        $this->groups->group_update($data, $id);
        }
      else
        {
        $this->groups->group_create($data);
        }
      $this->redirect('/groups/groups_list');
      }
    ////////////////////////////////////////////////////////////////////////////
 
    $group = $this->groups->getById($id);
    if($group)
      {
      $this->assign($group);
      }
       
    $this->viewPage();
    }
    
  function actionDelete($id=0)
    {
    if(empty($id))
      $this->errors->setError("ID of Group is missing!");
    
    $this->groups->group_delete($id);
    $this->redirect();
    }
  function actionTest()
    {
    $element = $this->groups->getByIdOrderByGroup_Displayname("'1', '3'");
    print_r($element);
    }
  }

