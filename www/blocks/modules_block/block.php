<?php

function modules_block_display(&$blockinfo)
  {
  //�������� ��� � ���� �������
  $sysObject = 'modules_block::display::'.$blockinfo[id];
  $sysModTpl = sysTplWay ($sysObject);

  //�������� �� ������
  if (!sysSecAuthAction($sysObject, ACCESS_READ)) return true;

  $sysTpl = new sysTpl;
  $sysTpl->cache_lifetime = -1;

  if ($sysTpl->is_cached($sysModTpl, $sysObject))
    {
    //���������� ���������
    $result['block_content'] =& $sysTpl->fetch($sysModTpl,$sysObject);
    return $result;
    };

  //������ �������
  $modules_table = sysDBGetTable('modules');
  $modules_column = sysDBGetColumns($modules_table);

  $modules_list = sysDbSelect ($modules_table, $modules_column,
    "WHERE $modules_column[mod_state]='".MODULE_STATE_ACTIVE."' ORDER BY $modules_column[mod_displayname]", true);

  $sysTpl->assign('modules_list', $modules_list, false);

  //���������� ���������
  $result['block_content'] =& $sysTpl->fetch($sysModTpl,$sysObject);
  return $result;
  }


?>