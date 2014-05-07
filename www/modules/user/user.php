<?php
/*
 * Главная страница
*/
function user_user_main()
  {
  $tpl = tplInfo(__FUNCTION__, __FILE__);
  //Проверка на доступ
  //if (!getAccess($tpl['object'], ACCESS_READ)) return;

  $smarty = new coreTpl();
  $smarty->caching = false;

  appModClassLoad('user');
  $user = new user();

  $prof_list = $user->professionList();
  $family_list = $user->maritalStatusList();
  $sex_list = $user->sexList();

  $smarty->assign('prof_list', $prof_list);
  $smarty->assign('family_list', $family_list);
  $smarty->assign('sex_list', $sex_list);

  $browsein = array();
  $browsein[]=array ('url'=>'index.php?module=user&type=user&func=main',
                     'displayname'=>'Личная страница');

  $result['object'] = $tpl['object'];
  $result['content'] = $smarty->fetch($tpl['src'],$tpl['object']);
  $result['browsein'] = $browsein;
  
  return $result;
  }

/*
 * Главная страница
 */
function user_user_login()
  {
  $tpl = tplInfo(__FUNCTION__, __FILE__);
  //Проверка на доступ
  //if (!getAccess($tpl['object'], ACCESS_READ)) return;
  
  $db=DBConnector::getInstance();
  $ses_info=UserSession::getInstance();

  $smarty = new coreTpl();
  $smarty->caching = false;

  //Построили дерево разделов
  appModClassLoad ('user');
  $user = new user;
 
  if($ses_info->isLogin())
      $smarty->assign('user_id', $ses_info->userId()); 

  $browsein = array();
  $browsein[]=array ('url'=>'index.php?module=user&type=user&func=main',
                     'displayname'=>'Вход в систему');

  //Вывод результатов
  $result['object'] = $tpl['object'];
  $result['content'] = $smarty->fetch($tpl['src'],$tpl['object']);
  $result['browsein'] = $browsein;
  
  return $result;
  }



function user_user_create_user()
  {
  $tpl = tplInfo(__FUNCTION__, __FILE__);
  //Проверка на доступ
  //if (!getAccess($tpl['object'], ACCESS_READ)) return;
  $input_data = appCleanInputArray($_POST);
  //print_r($input_data);exit;

  /*****************************************************************************
   *            ВАЛИДАЦИЯ НУЖНЫХ ПОЛЕЙ
   *****************************************************************************/
  //Проверим поле логин
  if ($input_data['login'] == '')
    {
    // Поле логин должно быть заполнено
    appShowMessage($_SERVER['HTTP_REFERER'], 'Поле \'Логин\' не заполнено');
    }
  elseif (!preg_match("/^\w{3,}$/", $input_data['login']))
    {
    // Логин может состоять из букв, цифр и подчеркивания
    appShowMessage($_SERVER['HTTP_REFERER'], 'В поле \'Логин\' введены недопустимые символы');
    }

  //Проверим поле почты
  if ($input_data['mail'] == '')
    {
    // Проверяем e-mail на заполнение
    appShowMessage($_SERVER['HTTP_REFERER'], 'Поле \'E-mail\' не заполнено');
    }
  elseif (!preg_match("/^[a-zA-Z0-9_\.\-]+@([a-zA-Z0-9\-]+\.)+[a-zA-Z]{2,6}$/", $input_data['mail']))
    {
    // Проверяем e-mail на корректность
    appShowMessage($_SERVER['HTTP_REFERER'], 'Указанный \'E-mail\' имеет недопустимый формат');
    }

  //Проверим поле пароль
  if ($input_data['pass'] == '' || $input_data['pass2'] == '')
    {
    // Поле пароль и повтор пароля должны быть заполнеными
    appShowMessage($_SERVER['HTTP_REFERER'], 'Поле \'Пароль\' не заполнено');
    }
  elseif ($input_data['pass'] !== $input_data['pass2'])
    {
    // Поле пароль и повтор пароля должны быть одинаковыми
    appShowMessage($_SERVER['HTTP_REFERER'], 'Поля \'Пароль\' и \'Повтор пароля\' не совпадают');
    }
  elseif (!preg_match("/^\w{3,}$/", $input_data['pass']))
    {
    // Пароль может состоять из букв, цифр и подчеркивания
    appShowMessage($_SERVER['HTTP_REFERER'], 'В поле \'Пароль\' введены недопустимые символы');
    }
/***********************  КОНЕЦ ВАЛИДАЦИИ  *************************************/

  $db=DBConnector::getInstance();
  $ses_info=UserSession::getInstance();

  //Дополним пришедшую от клиента инфу
  $input_data['pass'] = md5($input_data['pass']);
  $input_data['addtime'] = time();
  $input_data['last_visit'] = $input_data['addtime'];
  $input_data['gid'] = 2; //Группа по умолчанию "зарегистрированный пользователь"
  $input_data['active'] = 1;//Сразу активен
  
  $insert_id = $db->insert('user', $input_data);
  //$db->query("INSERT INTO user (login, pass, mail, addtime, gid) VALUES ('%s', '%s','%s', '%s', '2')", $login, $pass, $mail, $addtime);

  if($_FILES['file'])
    {
    appModClassLoad('user');
    $user = new user();
    $img_info = $user->createImage($_FILES['file'], $insert_id);
    if($img_info)
      $db->update('user', $img_info,"id='$insert_id'");
    }

  //Зарегистрировались, теперь пойдем в свой профиль
  //Для этого создадим сессию и перейдем на страницу с профилем
  $user_info['login'] = $input_data['login'];
  $user_info['gid'] = $input_data['gid'];
  $user_info['id'] = $insert_id;
  $ses_info->userLogin($user_info);

  appShowMessage('index.php?module=user&type=user&func=user_view&id='.$insert_id, 'Регистрация успешно завершина');
  //showMessage($_SERVER['HTTP_REFERER'], 'Регистрация успешно завершина');
  }



function user_user_user_login()
  {
  //print_r($_SERVER['HTTP_HOST']);exit;
  $tpl = tplInfo(__FUNCTION__, __FILE__);
  //Проверка на доступ
  //if (!getAccess($tpl['object'], ACCESS_READ)) return;
  
  $db=DBConnector::getInstance();
  $ses_info=UserSession::getInstance();
  
  list($login, $pass) = appCleanFromInput('login', 'pass');

  if ($login == '')
    {
    appShowMessage($_SERVER['HTTP_REFERER'], 'Поле \'Логин\' не заполнено');
    //die("Поле 'Логин' не заполнено<br />\n");
    // Логин может состоять из букв, цифр и подчеркивания
    }
  elseif (!preg_match("/^\w{3,}$/", $login))
    {
    appShowMessage($_SERVER['HTTP_REFERER'], 'В поле \'Логин\' введены недопустимые символы');
    //die("В поле 'Логин' введены недопустимые символы<br />\n");
    }

  if (!preg_match("/^\w{3,}$/", $pass))
    {
    //die("В поле 'Пароль' введены недопустимые символы<br />\n");
    appShowMessage($_SERVER['HTTP_REFERER'], 'В поле \'Пароль\' введены недопустимые символы');
    }

  $pass = md5($pass);


  $db->query("SELECT * FROM user WHERE login='%s' AND pass='%s'", $login, $pass);

  if($db->num_rows()>0)
    {
    $user_info = $db->fetch_array();
    $ses_info->userLogin($user_info[0]);
    }
  else
    {
    appShowMessage($_SERVER['HTTP_REFERER'], 'Не правильный логин или пароль');
    }

  appModClassLoad('user');
  $user = new user;
  appShowMessage('index.php?module=user&type=user&func=user_view&id='.$ses_info->userId(), 'Вход выполнен');
  //showMessage($_SERVER['HTTP_REFERER'], 'Вход выполнен');
  }


function user_user_user_logout()
  {
  $tpl = tplInfo(__FUNCTION__, __FILE__);
  //Проверка на доступ
  //if (!getAccess($tpl['object'], ACCESS_READ)) return;

  $db=DBConnector::getInstance();
  $ses_info=UserSession::getInstance();
  
  $ses_info->userLogOut();
  appShowMessage($_SERVER['HTTP_REFERER'], 'Выход из системы');
  }

function user_user_user_view()
  {
  $tpl = tplInfo(__FUNCTION__, __FILE__);

  $id = appCleanFromInput('id');

  if(!is_numeric($id))
    appShowMessage($_SERVER['HTTP_REFERER'], 'Не верно указан ид пользователя!');
  //Проверка на доступ
  //if (!getAccess($tpl['object'], ACCESS_READ)) return;

  $db=DBConnector::getInstance();
  $ses_info=UserSession::getInstance();

  $db->query("SELECT * FROM user WHERE id='%s'", $id);
  $user_info = $db->fetch_array();

  if(!$user_info[0])
    appShowMessage($_SERVER['HTTP_REFERER'], 'Страница пользователя не создана или не активна');

  $smarty = new coreTpl();
  $smarty->caching = false;

  appModClassLoad('user');
  $user = new user();

  $prof_list = $user->professionList();
  $family_list = $user->maritalStatusList();
  $sex_list = $user->sexList();

  $smarty->assign('prof_list', $prof_list);
  $smarty->assign('family_list', $family_list);
  $smarty->assign('sex_list', $sex_list);

  $smarty->assign($user_info[0]);

  $browsein = array();
  $browsein[]=array ('url'=>'index.php?module=user&type=user&func=main',
                     'displayname'=>'Личная страница');

  $result['object'] = $tpl['object'];
  $result['content'] = $smarty->fetch($tpl['src'],$tpl['object']);
  $result['browsein'] = $browsein;

  return $result;
  }

?>