<?php
class Index extends Controller
  {
  public $defaultAction = 'menu_list';
  
  function menu_list($parent_id = 0)
    {
    $menu = $this->menu->getById($parent_id);
    $browsein = $this->menu->parent_browsein($menu['menu_path']);
    if($parent_id > 0)
      {
      $browsein[] =array('url'=>'', 'displayname'=>$menu['menu_title']);
      }
 
    $this->assign('parent_id', $parent_id);
    $this->assign('menus', $this->menu->menu_list($parent_id));
    $this->assign('module_browsein', $browsein);
    
    $this->viewPage();
    }
    
  function menu_tree()
    {
    $this->assign('parent_id', 0);
    $this->assign('menus', $this->menu->tree_items(0));
    $this->assign('module_browsein', $browsein);
    
    $this->viewPage();
    }
    
  function modify($id=0)
    {
    $menu = $this->menu->getById($id);
    $browsein = $this->menu->parent_browsein($menu['menu_path']);
    $browsein[] =array('url'=>"/menu/menu_list/{$menu['id']}", 'displayname'=>$menu['menu_title']);
    $browsein[] =array('url'=>'', 'displayname'=>'Edit');
 
    $this->assign('items_list', $this->menu->tree_items(0));
    $this->assign('menu_parent_id', $id);
    $this->assign('module_browsein', $browsein);

    $this->assign($menu);
       
    $this->viewPage();
    }
    
  function create($id=0)
    {
    $menu = $this->menu->getById($id);
    $browsein = $this->menu->parent_browsein($menu['menu_path']);
    if($id > 0)
      {
      $browsein[] =array('url'=>"/menu/menu_list/{$menu['id']}", 'displayname'=>$menu['menu_title']);
      }
      
    $browsein[] =array('url'=>'', 'displayname'=>'Add');
 
    $this->assign('items_list', $this->menu->tree_items(0));
    $this->assign('menu_parent_id', $id);
    $this->assign('module_browsein', $browsein);
    
    $this->viewPage();
    }
    
  function manage($id=0)
    {
    $data = $this->input_vars;

    if($data['submit'])
      {
      if($id)
        {
        $this->menu->menuUpdate($data, $id);
        }
      else
        {
        $data['menu_content'] = $data["menu_content{$data['menu_item_type']}"];
        $this->menu->menuCreate($data);
        }
      }
    $this->redirect('/menu/menu_list');
    }
    
  function delete($id=0)
    {
    if(empty($id))
      $this->errors->setError("ID of menu is missing!");
    
    if($this->menu->hasSubitemById($id))
      {
      $this->showMessage('Menu has subitems! Can not delete');
      }
    
    $this->menu->menu_delete($id);
    $this->redirect();
    }
   
  //////////////////////////////////////////////////////////////////////////////  
  function test()
    {
    $element = $this->menu->getByIdOrderByGroup_Displayname("'1', '3'");
    print_r($element);
    }
    
  function tree()
    {
    $element = $this->menu->tree_items();
    print_r($element);
    }
  }
?>
