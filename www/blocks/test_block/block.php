<?php
class test_block extends Block
  {
  function display(&$blockinfo)
    {
    //�������� �� ������
    //if (!sysSecAuthAction($sysObject, ACCESS_READ)) return true;
    $this->usesModel('sysGroups');
    $this->sysGroups->group_list();
    $this->groups = $this->sysGroups->group_list();

    return $this->view();
    }
  }
?>