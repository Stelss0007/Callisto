<?php
class Index extends Controller
  {
  public $defaultAction = 'menu_list';
  
  function menu_list($parent_id = 0)
    {
    
    $this->menus = $this->menu->menu_list($parent_id);
//    print_r($this->menu );exit;
    $this->viewPage();
    }
    
  function manage($id=0)
    {
    $data = $this->input_vars;

    if($data['submit'])
      {
      if($id)
        {
        $this->menu->menu_update($data, $id);
        }
      else
        {
        $this->menu->menu_create($data);
        }
      $this->redirect('/menu/menu_list');
      }
    ////////////////////////////////////////////////////////////////////////////
 
    $menu = $this->menu->menu_info($id);
    $this->items_list = $this->menu->tree_items(33);
    if($menu)
      {
      $this->id = $menu['id'];
      $this->menu_displayname = $menu['menu_displayname'];
      $this->menu_description = $menu['menu_description'];
      }
       
    $this->viewPage();
    }
    
  function delete($id=0)
    {
    if(empty($id))
      $this->errors->setError("ID of menu is missing!");
    
    $this->menu->menu_delete($id);
    $this->redirect();
    }
  function test()
    {
    $element = $this->menu->getByIdOrderByGroup_Displayname("'1', '3'");
    print_r($element);
    }
  }
?>
