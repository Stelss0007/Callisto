<?php
class menu_block extends Block
  {
  function display(&$blockinfo)
    {
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