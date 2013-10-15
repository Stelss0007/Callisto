<?php
class Index extends Controller
  {
  public $defaultAction = 'groups_list';
  
  function groups_list()
    {
    $this->groups_list = $this->groups->group_list(true);
    $this->viewPage();
    }
    
  function manage($id=0)
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
 
    $group = $this->groups->group($id);
    if($group)
      {
      $this->id = $group['id'];
      $this->group_displayname = $group['group_displayname'];
      $this->group_description = $group['group_description'];
      }
       
    $this->viewPage();
    }
    
  function delete($id=0)
    {
    if(empty($id))
      $this->errors->setError("ID of Group is missing!");
    
    $this->groups->group_delete($id);
    $this->redirect();
    }
  function test()
    {
    $element = $this->groups->getByIdOrderByGroup_Displayname("'1', '3'");
    print_r($element);
    }
  }
?>