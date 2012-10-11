<?php
function work_user_task_new()
  {
  $tpl = tplInfo(__FUNCTION__, __FILE__);

  //Проверка на доступ
  if (!getAccess($tpl['object'], ACCESS_READ)) return;

  $smarty = new coreTpl();
  $smarty->caching = false;

  $db=DBConnector::getInstance();
  $ses_info=UserSession::getInstance();


 
  $smarty->assign('blocks_list_all', $block_list_all);
  $smarty->assign('position', $input_position);
  //BrowseIn
  $browsein = array();
  $browsein[] = array ('url'=>'/index.php?module=work&type=user&func=task_list',
                       'displayname'=>'Задания');
  $browsein[] = array ('url'=>'/index.php?module=work&type=user&func=task_new',
                       'displayname'=>'Добавление задания');

  //Возвращаем результат
  $result['object'] = $tpl['object'];
  $result['content'] = $smarty->fetch($tpl['src'],$tpl['object']);
  $result['browsein'] = $browsein;
  return $result;
  }

function work_user_task_create()
  {
  $tpl = tplInfo(__FUNCTION__, __FILE__);

  if(!$ref)
    $ref = $_SERVER['HTTP_REFERER'];

  //Проверка на доступ
  if (!getAccess($tpl['object'], ACCESS_READ)) return;

  $input_array = array();

  list($input_array['displayname'], $input_array['description'], $input_array['currency'], $input_array['category_id'], $input_array['addinfo']) =
          coreCleanFromInput('displayname','description', 'currency','category_id', 'addinfo');

  $db=DBConnector::getInstance();
  $ses_info=UserSession::getInstance();

  $input_array['user_id'] = $ses_info->userId();
  $input_array['addtime'] = time();

  $db->insert('work_task', $input_array);

  showMessage($ref, 'Элемент добавлен');
  }

function work_user_task_list()
  {
  $tpl = tplInfo(__FUNCTION__, __FILE__);

  //Проверка на доступ
  if (!getAccess($tpl['object'], ACCESS_READ)) return;

  $smarty = new coreTpl();
  $smarty->caching = false;

  $db=DBConnector::getInstance();
  $ses_info=UserSession::getInstance();

  $db->query("SELECT * FROM work_task");
  $task_list = $db->fetch_array();
 

  $smarty->assign('task_list', $task_list);
  $smarty->assign('position', $input_position);
  //BrowseIn
  $browsein = array();
  $browsein[] = array ('url'=>'/index.php?module=work&type=user&func=task_list',
                       'displayname'=>'Задания');
  

  //Возвращаем результат
  $result['object'] = $tpl['object'];
  $result['content'] = $smarty->fetch($tpl['src'],$tpl['object']);
  $result['browsein'] = $browsein;
  return $result;
  }

function work_user_task_view()
  {
  $tpl = tplInfo(__FUNCTION__, __FILE__);

  //Проверка на доступ
  if (!getAccess($tpl['object'], ACCESS_READ)) return;

  $id = coreCleanFromInput('id');
  
  if(!is_numeric($id)) die('ID NOT NUMERIC');

  $smarty = new coreTpl();
  $smarty->caching = false;

  $db=DBConnector::getInstance();
  $ses_info=UserSession::getInstance();

  $db->query("SELECT * FROM work_task WHERE id='%d'", $id);
  $task = $db->fetch_array();


  $smarty->assign('task', $task[0]);
  $smarty->assign('position', $input_position);
  //BrowseIn
  $browsein = array();
  $browsein[] = array ('url'=>'/index.php?module=work&type=user&func=task_list',
                       'displayname'=>'Задания');
  $browsein[] = array ('url'=>'/index.php?module=work&type=user&func=task_list',
                       'displayname'=>'Просмотр задания');


  //Возвращаем результат
  $result['object'] = $tpl['object'];
  $result['content'] = $smarty->fetch($tpl['src'],$tpl['object']);
  $result['browsein'] = $browsein;
  return $result;
  }

 function work_user_task_modify()
  {
  $tpl = tplInfo(__FUNCTION__, __FILE__);

  //Проверка на доступ
  if (!getAccess($tpl['object'], ACCESS_READ)) return;

  $id = coreCleanFromInput('id');

  if(!is_numeric($id)) die('ID NOT NUMERIC');

  $smarty = new coreTpl();
  $smarty->caching = false;

  $db=DBConnector::getInstance();
  $ses_info=UserSession::getInstance();

  $db->query("SELECT * FROM work_task WHERE id='%d'", $id);
  $task = $db->fetch_array();


  $smarty->assign('task', $task[0]);
  $smarty->assign('position', $input_position);
  //BrowseIn
  $browsein = array();
  $browsein[] = array ('url'=>'/index.php?module=work&type=user&func=task_list',
                       'displayname'=>'Задания');
  $browsein[] = array ('url'=>'/index.php?module=work&type=user&func=task_list',
                       'displayname'=>'Редактирование задания');


  //Возвращаем результат
  $result['object'] = $tpl['object'];
  $result['content'] = $smarty->fetch($tpl['src'],$tpl['object']);
  $result['browsein'] = $browsein;
  return $result;
  }


function work_user_task_update()
  {
  $tpl = tplInfo(__FUNCTION__, __FILE__);

  if(!$ref)
    $ref = $_SERVER['HTTP_REFERER'];

  //Проверка на доступ
  if (!getAccess($tpl['object'], ACCESS_READ)) return;

  $input_array = array();

  list($id, $input_array['displayname'], $input_array['description'], $input_array['currency'], $input_array['category_id'], $input_array['addinfo']) =
          coreCleanFromInput('id', 'displayname','description', 'currency','category_id', 'addinfo');

  if(!is_numeric($id))
    die("ID NOT NUMERIC");

  $db=DBConnector::getInstance();
  $ses_info=UserSession::getInstance();

  //$input_array['user_id'] = $ses_info->userId();
  $input_array['modtime'] = time();

  $db->update('work_task', $input_array, "Where id = '$id'");

  showMessage($ref, 'Элемент добавлен');
  }

?>