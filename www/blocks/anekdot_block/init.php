<?php

function anekdot_block_add($blockinfo)
  {
  //��������� ������, ���� ���� ���
  sysModClassLoad ('SYS_themes');
  $SYS_themes = new SYS_themes;

  $sysObject = 'anekdot_block::display';
  $sysModTpl = sysTplWay ($sysObject);

  if (empty ($sysModTpl))
    {
    $SYS_themes->tpl_add (array('tpl_compname'=>'anekdot_block',
                                'tpl_name'=>'block_display.tpl',
                                'tpl_pattern'=>$sysObject,
                                'tpl_description'=>'����� ���������� �����'));
    };

  //��������� ������, ���� ���� ���
  $sysObject = 'anekdot_block::modify';
  $sysModTpl = sysTplWay ($sysObject);
  if (empty ($sysModTpl))
    {
    $SYS_themes->tpl_add (array('tpl_compname'=>'anekdot_block',
                                'tpl_name'=>'block_modify.tpl',
                                'tpl_pattern'=>$sysObject,
                                'tpl_description'=>'�������������� �����'));
    };

  return true;
  }

function anekdot_block_delete($blockinfo)
  {
  return true;
  }

function anekdot_block_activate($blockinfo)
  {
  return true;
  }

function anekdot_block_deactivate($blockinfo)
  {
  return true;
  }

function anekdot_block_modify($blockinfo)
  {
  //�������� ��� � ���� �������
  /*
  $sysObject = 'anekdot_block::modify::'.$blockinfo[id];
  $sysModTpl=sysTplWay ($sysObject);
  $sysTpl = new sysTpl;
  $sysTpl->caching = false;

  //����������
  $content = sysBlockGetVar ($blockinfo['id'], 'content');
  $sysTpl->assign('content', $content);

  $result = $sysTpl->fetch($sysModTpl,$sysObject);
  return $result;
  */
  }

function anekdot_block_update($blockinfo)
  {
  /*
  //�������� ���������� �������
  //���������� �� ���������, ����� ��������� JAVA !!!!
  $content = sysVarGetFromInput('content'); //������ �� ������� ���
  sysBlockSetVar ($blockinfo['id'], 'content', $content);
  //������� ��� ��������
  $sysTpl = new sysTpl;
  $sysTpl->clear_cache(null, 'anekdot_block::display');
  return true;
  */
  }

?>