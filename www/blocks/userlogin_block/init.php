<?php

function userlogin_block_add($blockinfo)
  {
  //��������� ������, ���� ���� ���
  $sysObject = 'userlogin_block::display';
  $sysModTpl = sysTplWay ($sysObject);
  if (empty ($sysModTpl))
    {
    sysModClassLoad ('SYS_themes');
    $SYS_themes = new SYS_themes;
    $SYS_themes->tpl_add (array('tpl_compname'=>'userlogin_block',
                                'tpl_name'=>'block_display.tpl',
                                'tpl_pattern'=>$sysObject,
                                'tpl_description'=>'����� ���������� �����'));
    };

  return true;
  }

function userlogin_block_delete($blockinfo)
  {
  return true;
  }

function userlogin_block_activate($blockinfo)
  {
  return true;
  }

function userlogin_block_deactivate($blockinfo)
  {
  return true;
  }

?>