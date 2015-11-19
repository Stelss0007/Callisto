<?php
use app\modules\menu\models\Menu;

class menu_block extends Block
  {
  function display(&$blockinfo)
    {
    //$this->viewCached();
    $config = unserialize(stripcslashes($blockinfo->content));
    $this->menu_list = Menu::find()
                       ->where(['menu_parent_id'=>$config['parent_id']])
                       ->orderBy('menu_parent_id, weight')
                       ->all()
                       ;
    return $this->view();
    }
    
  function modify(&$blockinfo)
    {
    //Типы меню
    $content = (unserialize($blockinfo->content));

    $this->assign('menu_type', $content['menu_type']);
    $this->assign('parent_id', $content['parent_id']);
    
    $this->usesModel('menu');
    $this->items_list =  $this->menu->treeItems(0);
    $this->menutypes_list = array (1=>'Всегда развернуто',2=>'Разварачиваюшееся');
    return $this->view();
    }
    
  function update(&$blockinfo)
    {
    
    $this->menu_type = $this->input_vars['menu_type'];
    $this->parent_id = $this->input_vars['parent_id'];
    $this->save($blockinfo->id);
    }
  }