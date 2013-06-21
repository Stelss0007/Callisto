<?php

function menu_block_add($blockinfo)
  {
  //��������� ������, ���� ���� ���
  sysModClassLoad ('SYS_themes');
  $SYS_themes = new SYS_themes;  
  
  $sysObject = 'menu_block::display';
  $sysModTpl = sysTplWay ($sysObject);
  if (empty ($sysModTpl))
    {
    $SYS_themes->tpl_add (array('tpl_compname'=>'menu_block',
                                'tpl_name'=>'block_display.tpl',
                                'tpl_pattern'=>$sysObject,
                                'tpl_description'=>'����� ���������� �����'));
    };
    
  $sysObject = 'menu_block::modify';
  $sysModTpl = sysTplWay ($sysObject);
  if (empty ($sysModTpl))
    {
    $SYS_themes->tpl_add (array('tpl_compname'=>'menu_block',
                                'tpl_name'=>'block_modify.tpl',
                                'tpl_pattern'=>$sysObject,
                                'tpl_description'=>'�������������� �����'));
    };
    
  return true;
  }

function menu_block_delete($blockinfo)
  {
  $sysTpl = new sysTpl;
  $sysTpl->clear_cache(null, "menu_block::display::$blockinfo[id]");
  return true;
  }

function menu_block_activate($blockinfo)
  {
  return true;
  }

function menu_block_deactivate($blockinfo)
  {
  $sysTpl = new sysTpl;
  $sysTpl->clear_cache(null, "menu_block::display::$blockinfo[id]");
  return true;
  }

function menu_block_modify($blockinfo)
  {
  //�������� ��� � ���� �������
  $sysObject = 'menu_block::modify';
  $sysModTpl = sysTplWay ($sysObject);
  $sysTpl = new sysTpl;
  $sysTpl->caching = false;

  //��� ����
  $menu_type = sysBlockGetVar ($blockinfo['id'], 'menu_type');
  $sysTpl->assign('menu_type', $menu_type);

  //���� ����
  $menutypes_list = array (1=>'������ ����������',2=>'�����������������');
  $sysTpl->assign('menutypes_list', $menutypes_list);

  //��������� ������ ��������
  sysModClassLoad ('menu','user');
  $menu = new menu;
  $items_list = $menu->ItemsTreeBuild (0, 0);
  $sysTpl->assign('items_list', $items_list);

  //������� �������
  $parent_id = sysBlockGetVar ($blockinfo['id'], 'parent_id');
  $sysTpl->assign('parent_id', $parent_id);

  $result=$sysTpl->fetch($sysModTpl,$sysObject);
  return $result;
  }

function menu_block_update($blockinfo)
  {
  //�������� ���������� �������
  $parent_id = sysVarCleanFromInput('parent_id');
  $menu_type = sysVarCleanFromInput('menu_type');
  sysBlockSetVar ($blockinfo['id'], 'parent_id', $parent_id);
  sysBlockSetVar ($blockinfo['id'], 'menu_type', $menu_type);
  //������ ���
  $sysTpl = new sysTpl;
  $sysTpl->clear_cache(null, "menu_block::display::$blockinfo[id]");
  }

?>