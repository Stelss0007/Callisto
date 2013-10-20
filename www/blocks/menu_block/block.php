<?php
class menu_block extends Block
  {
  function display(&$blockinfo)
    {
    //print_r($blockinfo);
    $this->usesModel('menu');
    $this->menu_list = $this->menu->getList(array('condition'=>$blockinfo['id']));
    return $this->view();
    }
    
  function modify(&$blockinfo)
    {
    //���� ����
    $this->menutypes_list = array (1=>'������ ����������',2=>'�����������������');
    return $this->view();
    }
    
  function update(&$blockinfo)
    {
    $this->menu_type = $this->input_vars['menu_type'];
    $this->save($blockinfo['id']);
    }
  }