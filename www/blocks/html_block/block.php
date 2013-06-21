<?php

function html_block_display(&$blockinfo)
  {
  //�������� ��� � ���� ������
  $sysObject = 'html_block::display::'.$blockinfo['id'];

  //�������� �� ������
  if (!sysSecAuthAction($sysObject, ACCESS_READ)) return true;

  $sysTpl = new sysTpl;
  $sysTpl->cache_lifetime = -1;
  $sysModTpl = sysTplWay ($sysObject);

  if($sysTpl->is_cached($sysModTpl, $sysObject))
    {
    //���������� ���������
    $result['block_content'] =& $sysTpl->fetch($sysModTpl,$sysObject);
    return $result;
    };

  //����������
  $content =& sysBlockGetVar ($blockinfo['id'], 'content');
  $sysTpl->assign('content', $content);

  //�������� �����
  $sysTpl->assign('block_displayname', $blockinfo['block_displayname']);

  $result['block_content'] =& $sysTpl->fetch($sysModTpl,$sysObject);
  return $result;
  }

?>