<?php
class test_block extends Block
  {
  function display(&$blockinfo)
    {
    //Проверка на доступ
    //if (!sysSecAuthAction($sysObject, ACCESS_READ)) return true;
    $this->usesModel('groups');
    $this->groups->group_list();
    $this->groups = $this->groups->group_list();

    return $this->view();
    }
  }
?>