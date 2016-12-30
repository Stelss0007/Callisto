<?php
/*
 * Smarty plugin
 * $modname
 * $comm_key_a
 * $comm_key_b
 * $sort
 * $asc
 * $page
 * -------------------------------------------------------------
 * {comment_list modname='zozo' comm_key_a='12' comm_key_b='18' sort='time' asc='true'}
 */
function smarty_function_comment_list($params, &$smarty)
	{
  //�������� ����������� �����������
  if (!sysModGetVar('comment', 'comment_enabled')) return'';

  // �������� ������� ������
  if (!sysModAvailable ('comment')) return '';

  //��������� ������
  sysModLoad('comment', 'ajax');

	//�������� �������
	$mod_param = array('comm_module'     =>  $params['modname'],
	                   'comm_key_a'      =>  $params['comm_key_a'],
	                   'comm_key_b'      =>  $params['comm_key_b'],
	                   'page'            =>  $params['page'],
	                   'comment_perpage' =>  $params['comment_perpage'],
	                   'th'              =>  $params['th']);

	$modresult =& sysModFunc('comment', 'ajax', 'list', $mod_param);

  return $modresult['content'];
  }

?>