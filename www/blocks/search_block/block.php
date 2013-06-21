<?php

function search_block_display($blockinfo)
  {
  //�������� ��� � ���� �������
  $sysObject = 'search_block::display'.$blockinfo['id'];

  //�������� �� ������
  if (!sysSecAuthAction($sysObject, ACCESS_READ))
    {
    return true;
    }

  $sysModTpl = sysTplWay ($sysObject);
  $sysTpl = new sysTpl;
  $sysTpl->caching = -1;

  //������� � ����
  if($sysTpl->is_cached($sysModTpl,$sysObject))
    {
    //���������� ���������
    $result['block_content'] =& $sysTpl->fetch($sysModTpl,$sysObject);
    return $result;
    };

  //���������
  $sysTpl->assign('blockinfo', $blockinfo);

  //������� ���������� �����
  $result['block_content'] =& $sysTpl->fetch($sysModTpl, $sysObject, $poll_stoped);
  return $result;
  }


?>