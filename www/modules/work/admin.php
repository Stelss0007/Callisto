<?php

function work_admin_main()
  {
  //Прелюдие как у всех модулей
  $sysObject = 'work_admin_main';
  $tpl = 'modules/work/themes/default/admin_main.tpl';

  //Проверка на доступ
  if (!getAccess($sysObject, ACCESS_ADMIN)) return;

  $smarty = new coreTpl();
  $smarty->caching = false;

  $db=DBConnector::getInstance();
  $ses_info=UserSession::getInstance();

  $db->query("SELECT * FROM work");
  $work_list = $db->fetch_array();

  $smarty->assign('work_list', $work_list);

  //BrowseIn
  $browsein = array();
  $browsein[] = array ('url'=>'/work/',
                       'displayname'=>'Группы');

  //Возвращаем результат
  $result['object'] = $sysObject;
  $result['content'] = $smarty->fetch($tpl);
  $result['browsein'] = $browsein;
  return $result;
  }


function work_admin_create()
  {
  $sysObject = 'work>admin>create';
  //Проверка на доступ
  if (!getAccess($sysObject, ACCESS_ADMIN)) return;

  //Забираем переменные со входа
  list($group_displayname, $group_description) = appCleanFromInput('group_displayname', 'group_description');
  //Проверки
  if (empty($group_displayname))
    appShowMessage($_SERVER['HTTP_REFERER'], 'Неуказанно имя группы');

  $db=DBConnector::getInstance();
  $ses_info=UserSession::getInstance();

  $db->query("INSERT INTO work (group_displayname, group_description) VALUES ('%s', '%s')", $group_displayname, $group_description);

  appShowMessage($_SERVER['HTTP_REFERER'], 'Группа создана');
  }

function work_admin_modify()
  {
  //Забираем переменные
  $id = appCleanFromInput('id');
  if (!is_numeric ($id)) appShowMessage($_SERVER['HTTP_REFERER'], 'Id not numeric');

  //Прелюдие как у всех модулей
  $sysObject = 'work>admin>modify>'.$id;
  $tpl = 'modules/work/themes/default/admin_modify.tpl';

  //Проверка на доступ
  if (!getAccess($sysObject, ACCESS_ADMIN)) return;

  //Инициализация системы шаблонов +проверка в кеше
  $smarty = new coreTpl();
  $smarty->caching = false;

  $db=DBConnector::getInstance();
  $ses_info=UserSession::getInstance();

  $db->query("SELECT * FROM work WHERE id = '%d'", $id);
  $work_list = $db->fetch_array();
  $dbdata = $work_list[0];

  $group_perms_list = groupPermsGetList($id);
  $perms_level_list = permsLevelGetList();
  
  $smarty->assign($dbdata);
  $smarty->assign('group_perms_list', $group_perms_list);
  $smarty->assign('perms_level_list', $perms_level_list);
  $smarty->assign('ref',$_SERVER['HTTP_REFERER']);

  //BrowseIn
  $browsein[]=array ('url'=>'/index.php?module=work&type=admin',
                     'displayname'=>"Группы");
  $browsein[]=array ('url'=>'/index.php?module=work&type=admin',
                     'displayname'=>"Редактирование группы \"$dbdata[group_displayname]\"");
  $smarty->assign('browsein', $browsein);

  //Возвращаем результат
  $result['object'] = $sysObject;
  $result['browsein'] = $browsein;
  $result['content'] = $smarty->fetch($tpl, $sysObject);
  return $result;
  }

function work_admin_update()
  {
  list($group_displayname, $group_description, $id, $ref) = appCleanFromInput('group_displayname', 'group_description', 'id', 'ref');

  if(empty($ref))
    $ref = $_SERVER['HTTP_REFERER'];

  if (!is_numeric ($id)) appShowMessage($_SERVER['HTTP_REFERER'], 'Id not numeric');

  $sysObject = 'work>admin>update>'.$id;
  //Проверка на доступ
  if (!getAccess($sysObject, ACCESS_ADMIN)) return;

  $db=DBConnector::getInstance();
  $ses_info=UserSession::getInstance();

  $db->query("UPDATE work SET group_displayname = '%s', group_description = '%s' WHERE id = '%d'",$group_displayname, $group_description, $id);

  appShowMessage($ref, 'Изменения сохранены');
  }


function work_admin_delete()
  {
  $id = appCleanFromInput('id');
  if (!is_numeric ($id)) appShowMessage($_SERVER['HTTP_REFERER'], 'Id not numeric');

  $sysObject = 'work>admin>delete>'.$id;
  //Проверка на доступ
  if (!getAccess($sysObject, ACCESS_ADMIN)) return;

  $db=DBConnector::getInstance();
  $ses_info=UserSession::getInstance();

  $db->query("DELETE FROM work WHERE id = '%d'", $id);

  //Удаление
  appShowMessage($_SERVER['HTTP_REFERER'], 'Группа удалена');
  return true;
  }



function work_admin_perms_new()
  {
  //Забираем переменные
  $id = appCleanFromInput('id');
  if (!is_numeric ($id)) appShowMessage($_SERVER['HTTP_REFERER'], 'Id not numeric');

  //Прелюдие как у всех модулей
  $sysObject = 'work>admin>perms_new>'.$id;
  $tpl = 'modules/work/themes/default/admin_work_perms_new.tpl';

  //Проверка на доступ
  if (!getAccess($sysObject, ACCESS_ADMIN)) return;

  //Инициализация системы шаблонов +проверка в кеше
  $smarty = new coreTpl();
  $smarty->caching = false;

  $db=DBConnector::getInstance();
  $ses_info=UserSession::getInstance();

  $db->query("SELECT * FROM work WHERE id = '%d'", $id);
  $work_list = $db->fetch_array();
  $dbdata = $work_list[0];

  $group_perms_list = groupPermsGetList($id);
  $perms_level_list = permsLevelGetList();

  $smarty->assign($dbdata);
  $smarty->assign('group_perms_list', $group_perms_list);
  $smarty->assign('perms_level_list', $perms_level_list);
  $smarty->assign('ref',$_SERVER['HTTP_REFERER']);

  //BrowseIn
  $browsein[]=array ('url'=>'/index.php?module=work&type=admin',
                     'displayname'=>"Группы");
  $browsein[]=array ('url'=>'/index.php?module=work&type=admin&func=modify&id='.$id,
                     'displayname'=>"Редактирование группы \"$dbdata[group_displayname]\"");
  $browsein[]=array ('url'=>'/index.php?module=work&type=admin',
                     'displayname'=>"Права группы");


  $smarty->assign('browsein', $browsein);

  //Возвращаем результат
  $result['object'] = $sysObject;
  $result['browsein'] = $browsein;
  $result['content'] = $smarty->fetch($tpl, $sysObject);
  return $result;
  }

 function work_admin_perms_create()
  {
  $sysObject = 'work>admin>perms_create';
  //Проверка на доступ
  if (!getAccess($sysObject, ACCESS_ADMIN)) return;
  
  //Забираем переменные со входа
  list($gid, $level, $pattern, $description, $ref) = appCleanFromInput('gid', 'level', 'pattern', 'description', 'ref');
  //Проверки
  if(empty($ref))
    $ref = $_SERVER['HTTP_REFERER'];
  if (!is_numeric($gid))
    appShowMessage($ref, 'GID NOT NUMERIC');
  if (empty($pattern))
    appShowMessage($ref, 'Поле объект не может быть пустым!');

  $db=DBConnector::getInstance();
  $ses_info=UserSession::getInstance();

  $db->query("INSERT INTO user_group_permissions (gid, level, pattern, description) VALUES ('%d', '%d', '%s', '%s')", $gid, $level, $pattern, $description);

  appShowMessage($ref, 'Права группы созданы');
  }


function work_admin_perms_modify()
  {
  //Забираем переменные
  $id = appCleanFromInput('id');
  if (!is_numeric ($id)) appShowMessage($_SERVER['HTTP_REFERER'], 'Id not numeric');

  //Прелюдие как у всех модулей
  $sysObject = 'work>admin>perms_modify>'.$id;
  $tpl = 'modules/work/themes/default/admin_work_perms_modify.tpl';

  //Проверка на доступ
  if (!getAccess($sysObject, ACCESS_ADMIN)) return;

  //Инициализация системы шаблонов +проверка в кеше
  $smarty = new coreTpl();
  $smarty->caching = false;

  $db=DBConnector::getInstance();
  $ses_info=UserSession::getInstance();

  $db->query("SELECT * FROM user_group_permissions WHERE id = '%d'", $id);
  $perms_list = $db->fetch_array();
  $dbdata_perms = $perms_list[0];

  $db->query("SELECT * FROM work WHERE id = '%d'", $dbdata_perms[gid]);
  $work_list = $db->fetch_array();
  $dbdata = $work_list[0];

  unset($dbdata[id]);

  $group_perms_list = groupPermsGetList($id);
  $perms_level_list = permsLevelGetList();

  $smarty->assign($dbdata);
  $smarty->assign($dbdata_perms);
  $smarty->assign('group_perms_list', $group_perms_list);
  $smarty->assign('perms_level_list', $perms_level_list);
  $smarty->assign('ref',$_SERVER['HTTP_REFERER']);

  //BrowseIn
  $browsein[]=array ('url'=>'/index.php?module=work&type=admin',
                     'displayname'=>"Группы");
  $browsein[]=array ('url'=>'/index.php?module=work&type=admin&func=modify&id='.$dbdata_perms[gid],
                     'displayname'=>"Редактирование группы \"$dbdata[group_displayname]\"");
  $browsein[]=array ('url'=>'/index.php?module=work&type=admin',
                     'displayname'=>"Редактирование прав группы");

  $smarty->assign('browsein', $browsein);

  //Возвращаем результат
  $result['object'] = $sysObject;
  $result['browsein'] = $browsein;
  $result['content'] = $smarty->fetch($tpl, $sysObject);
  return $result;
  }


function work_admin_perms_update()
  {
  //Забираем переменные со входа
  list($gid, $level, $pattern, $description, $id, $ref) = appCleanFromInput('gid', 'level', 'pattern', 'description', 'id', 'ref');

  //Проверка на доступ
  $sysObject = 'work>admin>perms_update>'.$id;
  if (!sysSecAuthAction($sysObject, ACCESS_ADMIN)) return;

  //Проверки
  if(empty($ref))
    $ref = $_SERVER['HTTP_REFERER'];

  if (!is_numeric($gid) || !is_numeric($id))
    appShowMessage($ref, 'GID OR ID NOT NUMERIC');
  if (empty($pattern))
    appShowMessage($ref, 'Поле объект не может быть пустым!');

  $db=DBConnector::getInstance();
  $ses_info=UserSession::getInstance();

  $db->query("UPDATE user_group_permissions SET gid='%d', level='%d', pattern='%s', description='%s' WHERE id='%d'", $gid, $level, $pattern, $description, $id);

  appShowMessage($ref, 'Права группы сохранены');
  }


function work_admin_perms_delete()
  {
  $id = appCleanFromInput('id');
  if (!is_numeric ($id)) appShowMessage($_SERVER['HTTP_REFERER'], 'Id not numeric');

  $sysObject = 'work>admin>perms_delete>'.$id;
  //Проверка на доступ
  if (!getAccess($sysObject, ACCESS_ADMIN)) return;

  $db=DBConnector::getInstance();
  $ses_info=UserSession::getInstance();

  $db->query("DELETE FROM user_group_permissions WHERE id = '%d'", $id);

  //Удаление
  appShowMessage($_SERVER['HTTP_REFERER'], 'Права удалены');
  return true;
  }
?>