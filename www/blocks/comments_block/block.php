<?php
class comments_block extends Block
  {
  function display(&$blockinfo)
    {
    //$this->viewCached();
    $config = unserialize(stripcslashes($blockinfo['block_content']));
    $this->usesModel('comments');
    
    $this->module_object = $blockinfo['module_object'];
    $this->module_name = $blockinfo['module_name'];
    
    $this->comment_list = $this->comments->getList(array(
                                                        'fields'    => array('t.*', 'u.login'),
                                                        'condition' => array('comment_module_object'=>$blockinfo['module_object']),
                                                        'join'      => 'LEFT JOIN user u ON (u.id = t.comment_user_id)',
                                                        'order'     => 'comment_addtime DESC'
                                                        )
                                                  );
    return $this->view();
    }
    
  function modify(&$blockinfo)
    {
    //Типы меню
    $this->usesModel('comments');
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