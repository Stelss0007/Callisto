<?php
class Index extends Controller
  {
 
  function groups_list()
    {
    $this->groups = $this->sysGroups->group_list(true);
    $this->viewPage();
    }
    
  function manage($id=0)
    {
    $data = $this->input_vars;

    if($data[submit])
      {
      if($id)
        {
        $this->sysGroups->group_update($data, $id);
        }
      else
        {
        $this->sysGroups->group_create($data);
        }
      $this->redirect('/sysGroups/groups_list');
      }
    ////////////////////////////////////////////////////////////////////////////
 
    $group = $this->sysGroups->group($id);
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
    
    $this->sysGroups->group_delete($id);
    $this->redirect();
    }
  
  }
?>
