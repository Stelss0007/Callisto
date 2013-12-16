<?php
class Index extends Controller
  {
  public $defaultAction = 'menu_list';
  
  function menu_list($parent_id = 0)
    {
//    error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);
//    
//    $array[1] = 1000000;
//    echo $array['1'];
//    
//    $array[name] = ' hello ';
//    echo $array['name'];
//    
//    $array['second_name'] = ' world ';
//    echo $array[second_name];
//
//    exit;
    
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
    $this->setReferer();
    
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
    $this->setReferer();
  
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
      $data['menu_content'] = $data["menu_content{$data['menu_item_type']}"];
      if($id)
        {
        $this->menu->menuUpdate($data, $id);
        $this->showMessage('Ёлемент меню успешно изменен!');
        }
      else
        {
        $this->menu->menuCreate($data);
        $this->showMessage('Ёлемент меню успешно добавлен!');
        }
      }
    $this->redirect($this->getReferer('/menu/menu_list'));
    }
    
  function delete($id=0)
    {
    if(empty($id))
      $this->errors->setError("ID of menu is missing!");
    
    if($this->menu->hasSubitemById($id))
      {
      $this->showMessage('Ёлемент меню не может быть удален! ≈сть дочерние элементы.');
      }
    
    $this->menu->menu_delete($id);
    $this->showMessage('Ёлемент меню успешно удален!');
    $this->redirect();
    }
   
   function weight_up($weight, $menu_parent_id)
    {
    $this->getAccess(ACCESS_ADMIN);
    $this->menu->weightUp($weight, "menu_parent_id = '$menu_parent_id'");
    $this->redirect();
    }
    
  function weight_down($weight, $menu_parent_id)
    {
    $this->getAccess(ACCESS_ADMIN);
    $this->menu->weightDown($weight, "menu_parent_id = '$menu_parent_id'");
    $this->redirect();
    }
    
  function active($id)
    {
    $this->getAccess(ACCESS_ADMIN);
    $this->menu->block_active = '1';
    $this->menu->save($id);
    $this->redirect();
    }
    
  function deactive($id)
    {
    $this->getAccess(ACCESS_ADMIN);
    $this->menu->block_active = '0';
    $this->menu->save($id);
    $this->redirect();
    }
  }
?>
