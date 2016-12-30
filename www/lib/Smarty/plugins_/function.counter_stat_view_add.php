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
function smarty_function_counter_stat_view_add($params, &$smarty)
	{
  
  // Проверка наличия модуля
  if (!sysModAvailable ('counter')) return '';

  //Загружаем модуль
  sysModLoad('counter', 'ajax');

	//Вызываем функцию
	$mod_param = array('comm_module'     =>  $params['modname'],
	                   'comm_key_a'      =>  $params['comm_key_a'],
	                   'comm_key_b'      =>  $params['comm_key_b']
	                  );

	$modresult = & sysModFunc('counter', 'ajax', 'list_add', $mod_param);

  return $modresult['content'];
  }

?>