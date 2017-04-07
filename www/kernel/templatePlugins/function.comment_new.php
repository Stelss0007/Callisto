<?php
/*
 * Smarty plugin
 * $modname
 * $comm_key_a
 * $comm_key_b
 * -------------------------------------------------------------
 * {comment_new modname='zozo' comm_key_a='12' comm_key_b='18'}
 */
function smarty_function_comment_new($params, &$smarty)
	{
  //�������� ����������� �����������
  if (!sysModGetVar('comment', 'comment_enabled')) return'';

  // �������� ������� ������
  if (!sysModAvailable ('comment')) return '';

  //��������� ������
	sysModLoad('comment', 'ajax');

	//�������� �������
	$mod_param = array('comm_module' => $params['modname'],
	                   'comm_key_a' =>  $params['comm_key_a'],
	                   'comm_key_b' =>  $params['comm_key_b'],
	                   'comment_perpage' =>  $params['comment_perpage']
	                   );

	$modresult =& sysModFunc('comment', 'ajax', 'new', $mod_param);

  return $modresult['content'];
  }

?>