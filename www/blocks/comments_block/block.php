<?php
class comments_block extends Block
  {
  function display(&$blockinfo)
    {
    //$this->viewCached();
    $config = unserialize(stripcslashes($blockinfo->content));
    $this->usesModel('comments');
    
    $this->module_object = $blockinfo->module_object;
    $this->module_name = $blockinfo->module_name;
    
    $this->comment_list = $this->comments->getList(array(
                                                        'fields'    => array('t.*', 'u.login'),
                                                        'condition' => array('comment_module_object'=>$blockinfo->module_object),
                                                        'join'      => 'LEFT JOIN user u ON (u.id = t.comment_user_id)',
                                                        'order'     => 'comment_addtime ASC'
                                                        )
                                                  );
    return $this->view();
    }
    
  function modify(&$blockinfo)
    {
    $this->usesModel('comments');
    //$this->assign('toolbar', $this->getBlockContent('toolbar', array()));
    //$this->menutypes_list = array (1=>'Всегда развернуто',2=>'Разварачиваюшееся');
    return $this->view();
    }
    
  function update(&$blockinfo)
    {
    //echo $blockinfo['id'].' ';print_r($_REQUEST);exit;
    //echo $this->toolbar;exit;
    $this->setBlockContent('toolbar', $this->input_vars['toolbar']);
    $this->save($blockinfo['id']);
    }
  }