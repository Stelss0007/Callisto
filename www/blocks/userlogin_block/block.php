<?php
function userlogin_block_display($blockinfo)
  {
  print_r($blockinfo);
  //�������� ��� � ���� ������
  $sysObject = 'userlogin_block::display'.$blockinfo['id'];

  //�������� �� ������
  //if (!coreSecAuthAction($sysObject, ACCESS_READ)) return true;


//  if (sysUserIsLoggedIn())
//    {//��� ���������
//    return true;
//    }
//    else
//      {
//      $sysModTpl = sysTplWay ($sysObject);
//      $sysTpl = new sysTpl;
//      $sysTpl->cache_lifetime = -1;
//
//      //������� � ����
//      if($sysTpl->is_cached($sysModTpl, $sysObject))
//        {
//        //���������� ���������
//        $result['block_content'] =& $sysTpl->fetch($sysModTpl, $sysObject);
//        return $result;
//        };
//
//      //������� ���������� �����
//      $result['block_content'] =& $sysTpl->fetch($sysModTpl, $sysObject);
//      return $result;
//      };
  return "aaaaa";
  } 
?>