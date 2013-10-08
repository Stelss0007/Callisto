<?php

/*
 * Главная админская страница
 */

function user_admin_main()
  {
  sysRedirect(sysModURL('content', 'user', 'main'));
  }


////////////////////////////////////////////////////////////////////////////////
function user_admin_user_list()
  {
  $tpl = tplInfo(__FUNCTION__, __FILE__);
  $browsein = array();

  //Проверка на доступ
  if (!getAccess($tpl['object'], ACCESS_ADMIN)) return;

  $smarty = new coreTpl();
  $smarty->caching = false;

  $db=DBConnector::getInstance();
  $ses_info=UserSession::getInstance();

  $gid = appCleanFromInput('gid');

  appModClassLoad('groups');
  $groups = new groups();
  $group_list = $groups->get_list();

  if (is_numeric($gid))
    {
    $db->query("SELECT * FROM user WHERE gid = '%d'", $gid);
    $user_list = $db->fetch_array();

    $browsein[] = array ('url'=>'/index.php?module=groups&type=admin',
                       'displayname'=>'Группы');
    $browsein[] = array ('url'=>'/index.php?module=groups&type=admin',
                       'displayname'=>$group_list[$gid]);
    }
  else
    {
    $db->query("SELECT * FROM user");
    $user_list = $db->fetch_array();

    $browsein[] = array ('url'=>'/users/',
                       'displayname'=>'Пользователи');
    }

  
  $smarty->assign('user_list', $user_list);
  $smarty->assign('group_list', $group_list);

  //Возвращаем результат
  $result['object'] = $tpl['object'];
  $result['content'] = $smarty->fetch($tpl['src'],$tpl['object']);
  $result['browsein'] = $browsein;
  return $result;
  }


function user_admin_user_new()
  {
  $tpl = tplInfo(__FUNCTION__, __FILE__);
  //Проверка на доступ
  if (!getAccess($tpl['object'], ACCESS_ADMIN)) return;

  $smarty = new coreTpl();
  $smarty->caching = false;

  $db=DBConnector::getInstance();
  $ses_info=UserSession::getInstance();

  $gid = appCleanFromInput('gid');

  appModClassLoad('groups');
  $groups = new groups();
  $group_list = $groups->get_list();

 
  $smarty->assign('group_list', $group_list);

  $browsein = array();
  $browsein[] = array ('url'=>'/index.php?module=user&type=admin&func=user_list',
                       'displayname'=>'Пользователи');
  $browsein[] = array ('url'=>'/index.php?module=user&type=admin&func=user_list',
                       'displayname'=>'Добавление');

  //Возвращаем результат
  $result['object'] = $tpl['object'];
  $result['content'] = $smarty->fetch($tpl['src'],$tpl['object']);
  $result['browsein'] = $browsein;
  return $result;
  }
 
function user_admin_user_create()
  {
  $tpl = tplInfo(__FUNCTION__, __FILE__);
  //Проверка на доступ
  if (!getAccess($tpl['object'], ACCESS_ADMIN)) return;
  
  list($login, $pass, $mail, $active, $gid) = appCleanFromInput('login', 'pass', 'mail', 'active', 'gid');

  if ($login == '')
    {
    die("Поле 'Логин' не заполнено<br />\n");
    // Логин может состоять из букв, цифр и подчеркивания
    }
  elseif (!preg_match("/^\w{3,}$/", $login))
    {
    die("В поле 'Логин' введены недопустимые символы<br />\n");
    }
  if ($mail == '')
    {
    die("Поле 'E-mail' не заполнено<br />\n");
    // Проверяем e-mail на корректность
    }
  elseif (!preg_match("/^[a-zA-Z0-9_\.\-]+@([a-zA-Z0-9\-]+\.)+[a-zA-Z]{2,6}$/", $mail))
    {
    die("Указанный 'E-mail' имеет недопустимый формат<br />\n");
    }
  if ($pass == '')
    {
    die("Поле 'Пароль' не заполнено<br />\n");
    }
  elseif (!preg_match("/^\w{3,}$/", $pass))
    {
    die("В поле 'Пароль' введены недопустимые символы<br />\n");
    }

  $pass = md5($pass);
  $addtime = time();

  global $db;
  $db->query("INSERT INTO user (login, pass, mail, addtime, gid, active) VALUES ('%s', '%s','%s', '%s', '%d', '%d')", $login, $pass, $mail, $addtime, $gid, $active);

  appModClassLoad('user');
  $user = new user;

  $user->sendRegMail($login, $pass, $mail);
  // header ("location: ".$_SERVER['HTTP_REFERER']);
  }
  
function user_admin_user_modify()
  {
  $tpl = tplInfo(__FUNCTION__, __FILE__);
  //Проверка на доступ
  if (!getAccess($tpl['object'], ACCESS_ADMIN)) return;
  

  $id = appCleanFromInput('id');
  if(!is_numeric($id))
    appShowMessage($_SERVER['HTTP_REFERER'], 'Id not numeric');
  //Проверка на доступ
  //if (!sysSecAuthAction($sysObject, ACCESS_ADMIN)) return;

  $smarty = new coreTpl();
  $smarty->caching = false;

  $db=DBConnector::getInstance();
  $ses_info=UserSession::getInstance();

  $gid = appCleanFromInput('gid');

  appModClassLoad('groups');
  $groups = new groups();
  $group_list = $groups->get_list();

  $db->query("SELECT * FROM user WHERE id = '%d'", $id);
  $user_array = $db->fetch_array();
  $user_info = $user_array[0];

  $smarty->assign($user_info);
  $smarty->assign('group_list', $group_list);
  
  $browsein = array();
  $browsein[] = array ('url'=>'/index.php?module=user&type=admin&func=user_list',
                       'displayname'=>'Пользователи');
  $browsein[] = array ('url'=>'/index.php?module=user&type=admin&func=user_list',
                       'displayname'=>'Редактирование');

  //Возвращаем результат
  $result['object'] = $tpl['object'];
  $result['content'] = $smarty->fetch($tpl['src'],$tpl['object']);
  $result['browsein'] = $browsein;
  return $result;
  }



function user_admin_user_delete()
  {
  $tpl = tplInfo(__FUNCTION__, __FILE__);
  //Проверка на доступ
  if (!getAccess($tpl['object'], ACCESS_ADMIN)) return;
  
  $id = appCleanFromInput('id');

  $db=DBConnector::getInstance();
  $ses_info=UserSession::getInstance();

  if(!is_numeric($id))
    appShowMessage($_SERVER['HTTP_REFERER'], 'Id not numeric');
  $db->query("DELETE FROM user WHERE id = '%d'", $id);

  //$user->sendRegMail($login, $pass, $mail);
   appShowMessage($_SERVER['HTTP_REFERER'], 'Пользователь удален');
  }


function user_admin_user_update()
  {
  $tpl = tplInfo(__FUNCTION__, __FILE__);
  //Проверка на доступ
  if (!getAccess($tpl['object'], ACCESS_ADMIN)) return;
  
  list($login, $pass, $mail, $active, $gid) = appCleanFromInput('login', 'pass', 'mail', 'active', 'gid');

  if ($login == '')
    {
    die("Поле 'Логин' не заполнено<br />\n");
    // Логин может состоять из букв, цифр и подчеркивания
    }
  elseif (!preg_match("/^\w{3,}$/", $login))
    {
    die("В поле 'Логин' введены недопустимые символы<br />\n");
    }
  if ($mail == '')
    {
    die("Поле 'E-mail' не заполнено<br />\n");
    // Проверяем e-mail на корректность
    }
  elseif (!preg_match("/^[a-zA-Z0-9_\.\-]+@([a-zA-Z0-9\-]+\.)+[a-zA-Z]{2,6}$/", $mail))
    {
    die("Указанный 'E-mail' имеет недопустимый формат<br />\n");
    }
  if ($pass == '')
    {
    die("Поле 'Пароль' не заполнено<br />\n");
    }
  elseif (!preg_match("/^\w{3,}$/", $pass))
    {
    die("В поле 'Пароль' введены недопустимые символы<br />\n");
    }

  $pass = md5($pass);
  $addtime = time();

  global $db;
  $db->query("INSERT INTO user (login, pass, mail, addtime, gid, active) VALUES ('%s', '%s','%s', '%s', '%d', '%d')", $login, $pass, $mail, $addtime, $gid, $active);

  appModClassLoad('user');
  $user = new user;

  $user->sendRegMail($login, $pass, $mail);
  // header ("location: ".$_SERVER['HTTP_REFERER']);
  }

?>