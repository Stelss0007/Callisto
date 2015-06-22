<?php
class AdminController extends Controller
  {
  public $defaultAction = 'photoList';
  
  function actionPhotoList($parent_id = 0)
    {
    $this->getAccess(ACCESS_ADMIN);

    
    if(empty($menu['menu_path'])) {
        $menu['menu_path'] = [];
    }
    
    $browsein[] =array('url'=>"/admin/main", 'displayname'=>$this->t('dashboard'));
   
    if($parent_id > 0)
      {
      $browsein[] =array('url'=>'', 'displayname'=>$menu['menu_title']);
      }
 
    $this->assign('parent_id', $parent_id);
    $this->assign('module_browsein', $browsein);
    
    $this->viewPage();
    }
  
    
  function actionActive($id)
    {
    $this->getAccess(ACCESS_ADMIN);
    $this->menu->block_active = '1';
    $this->menu->save($id);
    $this->redirect();
    }
    
  function actionDeactive($id)
    {
    $this->getAccess(ACCESS_ADMIN);
    $this->menu->block_active = '0';
    $this->menu->save($id);
    $this->redirect();
    }
  }

