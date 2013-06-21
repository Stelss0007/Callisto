<?php

function online_block_display($blockinfo)
  {
  //�������� ��� � ����
  $sysObject = 'online_block::display::'.$blockinfo['id'];
  $sysModTpl = sysTplWay ($sysObject);

  //�������� �� ������
  if (!sysSecAuthAction($sysObject, ACCESS_READ)) return true;

  $sysTpl = new sysTpl;
  $sysTpl->cache_lifetime = 900; //����� ���������� 5 ���

  //�������� ���� ���� � $uid
  $uid = sysSessionGetVar ('user_id');

  if($sysTpl->is_cached($sysModTpl,$sysObject.'::'.$uid))
    {
    //����������
    $result['block_content'] =& $sysTpl->fetch($sysModTpl,$sysObject.'::'.$uid);
    return $result;
    };

  $activetime = time() - (sysModGetVar('SYS_config','sesinactivemins') * 60);
  $cur_session_id = session_id ();
  $num_guests=0;
  $num_users=0;

  //��������� ������ ������ � ����� ��� ���� ������ $activetime
  $session_table = sysDBGetTable('session');
  $session_column = sysDBGetColumns($session_table);

  //�����
  $sql = "SELECT COUNT(*) AS num_guests
            FROM $session_table
            WHERE $session_column[lastused] > '$activetime' AND
            			$session_column[user_gid] < '1'";
  //�������� �������
  global $dbg_sql_queries;
  $dbg_sql_queries[] = array('sql_query'=>$sql);
	$mysql_result = sysDBQuery($sql);
  if (mysql_errno()!=0) sysException ('online_block_display', DATABASE_ERROR, mysql_error()."<br> $sql");
  $sess_dbdate = mysql_fetch_assoc($mysql_result);
  mysql_free_result($mysql_result);
  $num_guests=$sess_dbdate['num_guests'];

  //������������
  $sql = "SELECT COUNT(*) AS num_users
            FROM $session_table
            WHERE $session_column[lastused] > '$activetime' AND
            			$session_column[user_gid] > '0'";
  //�������� �������
  global $dbg_sql_queries;
  $dbg_sql_queries[] = array('sql_query'=>$sql);
	$mysql_result = sysDBQuery($sql);
  if (mysql_errno()!=0) sysException ('online_block_display', DATABASE_ERROR, mysql_error()."<br> $sql");
  $sess_dbdate = mysql_fetch_assoc($mysql_result);
  mysql_free_result($mysql_result);
  $num_users=$sess_dbdate['num_users'];

  //�������� ���� ��� � 0 �� ..
  if (($num_users==0) and ($num_guests==0))
    {
    if (sysUserIsLoggedIn())
      {
      $num_users=1;
      }
      else
        {
        $num_guests=1;
        };
    };

  $sysTpl->assign('num_users', $num_users);
  $sysTpl->assign('num_guests', $num_guests);

  //���������� ������������
  $user_vars = sysUserGetVars();
  $sysTpl->assign('user_vars', $user_vars);

  $result['block_content'] =& $sysTpl->fetch($sysModTpl,$sysObject.'::'.$uid);
  return $result;
  }


?>