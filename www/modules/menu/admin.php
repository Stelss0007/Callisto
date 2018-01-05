<?php
use app\modules\menu\models\Menu;

class AdminController extends Controller
  {
  public $defaultAction = 'menu_list';
  
  function actionMenuList($parent_id = 0)
    {
    $this->getAccess(ACCESS_ADMIN);
    
    $menu = Menu::find($parent_id); //$this->menu->getById($parent_id);
    
    if(empty($menu->menu_path)) {
        $menu->menu_path = 0;
    }
    
    $browsein[] = ['url'=>"/admin/main", 'displayname'=>$this->t('dashboard')];
    $browsein[] = ['url'=>"/admin/menu", 'displayname'=>$this->t('menu_header')];
    $browsein = array_merge($browsein, Menu::parentBrowsein($menu->menu_path));
    if($parent_id > 0)
      {
      $browsein[] =['url'=>'', 'displayname'=>$menu->menu_title];
      }
 
    $this->assign('parent_id', $parent_id);
    $this->assign('menus',  Menu::menuList($parent_id));
    $this->assign('module_browsein', $browsein);
    
    $this->viewPage();
    }
    
  function actionMenuTree()
    {
    $this->getAccess(ACCESS_ADMIN);
    
    $this->assign('parent_id', 0);
    $this->assign('menus', Menu::treeItems(0));
    $this->assign('module_browsein', $browsein);
    
    $this->viewPage();
    }
    
  function actionModify($id=0)
    {
    $this->getAccess(ACCESS_ADMIN);
    
    $this->setRefferer();
    
    $menu = Menu::find($id);
    $browsein[] =array('url'=>"/admin/main", 'displayname'=>$this->t('dashboard'));
    $browsein = array_merge($browsein, Menu::parentBrowsein($menu->menu_path));
    $browsein[] =array('url'=>"/admin/menu/menu_list/{$menu->id}", 'displayname'=>$menu->menu_title);
    $browsein[] =array('url'=>'', 'displayname'=>'Edit');
 
    $this->assign('items_list', Menu::treeItems(0));
    $this->assign('menu_parent_id', $id);
    $this->assign('module_browsein', $browsein);

    $this->assign('menu', $menu);
       
    $this->viewPage();
    }
    
  function actionCreate($id=0)
    {
    $this->getAccess(ACCESS_ADMIN);
    
    $this->setRefferer();
  
    $menu = Menu::find($id);
    $browsein[] =array('url'=>"/admin/main", 'displayname'=>$this->t('dashboard'));
    $browsein = array_merge($browsein, Menu::parentBrowsein($menu['menu_path']));
    if($id > 0)
      {
      $browsein[] =array('url'=>"/admin/menu/menu_list/{$menu['id']}", 'displayname'=>$menu['menu_title']);
      }
      
    $browsein[] =array('url'=>'', 'displayname'=>'Add');
 
    $this->assign('items_list', Menu::treeItems(0));
    $this->assign('menu_parent_id', $id);
    $this->assign('module_browsein', $browsein);
    
    $this->viewPage();
    }
    
  function actionManage($id=0)
    {
    $this->getAccess(ACCESS_ADMIN);
    
    $data = $this->inputVars;

    if($data['submit'])
      {
      $data['menu_content'] = $data["menu_content{$data['menu_item_type']}"];
      if($id)
        {
        Menu::menuUpdate($data, $id);
        $this->showMessage('Элемент меню успешно изменен!');
        }
      else
        {
        Menu::menuCreate($data);
        $this->showMessage('Элемент меню успешно добавлен!');
        }
      }
    $this->redirect($this->getRefferer('/admin/menu/menu_list'));
    }
    
  function actionDelete($id=0)
    {
    $this->getAccess(ACCESS_ADMIN);
    
    if(empty($id))
      $this->errors->setError("ID of menu is missing!");
    
    if(Menu::hasSubitemById($id))
      {
      $this->showMessage('Элемент меню не может быть удален! Есть дочерние элементы.');
      }
    
    Menu::menuDelete($id);
    $this->showMessage('Элемент меню успешно удален!');
    $this->redirect();
    }
   
   function actionWeightUp($id, $menu_parent_id)
    {
    $this->getAccess(ACCESS_ADMIN);
    $menu = Menu::find($id);
    $menu->weightUp(['menu_parent_id' => $menu_parent_id]);
    $this->redirect();
    }
    
  function actionWeightDown($id, $menu_parent_id)
    {
    $this->getAccess(ACCESS_ADMIN);
    $menu = Menu::find($id);
    $menu->weightDown(['menu_parent_id' => $menu_parent_id]);
    $this->redirect();
    }
    
  function actionActive($id)
    {
    $this->getAccess(ACCESS_ADMIN);
    $menu = Menu::find($id);
    $menu->menu_active = '1';
    $menu->save();
    $this->redirect();
    }
    
  function actionDeactive($id)
    {
    $this->getAccess(ACCESS_ADMIN);
    $menu = Menu::find($id);
    $menu->menu_active = '0';
    $menu->save();
    $this->redirect();
    }
  }

