<?php
class menu_block extends Block
  {
  function display(&$blockinfo)
    {
    $config = unserialize($blockinfo['block_content']);
    $this->usesModel('menu');
    $this->menu_list = $this->menu->getList(array(
                                                  'condition'=>array('menu_parent_id'=>$config['parent_id']),
                                                  'order'=>'menu_parent_id, menu_weight'
                                                 ));
    return $this->view();
    }
    
  function modify(&$blockinfo)
    {
    //Типы меню
    $this->usesModel('menu');
    $this->items_list =  $this->menu->tree_items(0);
    $this->menutypes_list = array (1=>'Всегда развернуто',2=>'Разварачиваюшееся');
    return $this->view();
    }
    
  function update(&$blockinfo)
    {
    $this->menu_type = $this->input_vars['menu_type'];
    $this->parent_id = $this->input_vars['parent_id'];
    $this->save($blockinfo['id']);
    }
  }