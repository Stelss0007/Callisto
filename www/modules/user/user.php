<?php
/*
 * ������� ��������
*/
function user_user_main()
  {
  $tpl = tplInfo(__FUNCTION__, __FILE__);
  //�������� �� ������
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
                     'displayname'=>'������ ��������');

  $result['object'] = $tpl['object'];
  $result['content'] = $smarty->fetch($tpl['src'],$tpl['object']);
  $result['browsein'] = $browsein;
  
  return $result;
  }

/*
 * ������� ��������
 */
function user_user_login()
  {
  $tpl = tplInfo(__FUNCTION__, __FILE__);
  //�������� �� ������
  //if (!getAccess($tpl['object'], ACCESS_READ)) return;
  
  $db=DBConnector::getInstance();
  $ses_info=UserSession::getInstance();

  $smarty = new coreTpl();
  $smarty->caching = false;

  //��������� ������ ��������
  appModClassLoad ('user');
  $user = new user;
 
  if($ses_info->isLogin())
      $smarty->assign('user_id', $ses_info->userId()); 

  $browsein = array();
  $browsein[]=array ('url'=>'index.php?module=user&type=user&func=main',
                     'displayname'=>'���� � �������');

  //����� �����������
  $result['object'] = $tpl['object'];
  $result['content'] = $smarty->fetch($tpl['src'],$tpl['object']);
  $result['browsein'] = $browsein;
  
  return $result;
  }



function user_user_create_user()
  {
  $tpl = tplInfo(__FUNCTION__, __FILE__);
  //�������� �� ������
  //if (!getAccess($tpl['object'], ACCESS_READ)) return;
  $input_data = appCleanInputArray($_POST);
  //print_r($input_data);exit;

  /*****************************************************************************
   *            ��������� ������ �����
   *****************************************************************************/
  //�������� ���� �����
  if ($input_data['login'] == '')
    {
    // ���� ����� ������ ���� ���������
    appShowMessage($_SERVER['HTTP_REFERER'], '���� \'�����\' �� ���������');
    }
  elseif (!preg_match("/^\w{3,}$/", $input_data['login']))
    {
    // ����� ����� �������� �� ����, ���� � �������������
    appShowMessage($_SERVER['HTTP_REFERER'], '� ���� \'�����\' ������� ������������ �������');
    }

  //�������� ���� �����
  if ($input_data['mail'] == '')
    {
    // ��������� e-mail �� ����������
    appShowMessage($_SERVER['HTTP_REFERER'], '���� \'E-mail\' �� ���������');
    }
  elseif (!preg_match("/^[a-zA-Z0-9_\.\-]+@([a-zA-Z0-9\-]+\.)+[a-zA-Z]{2,6}$/", $input_data['mail']))
    {
    // ��������� e-mail �� ������������
    appShowMessage($_SERVER['HTTP_REFERER'], '��������� \'E-mail\' ����� ������������ ������');
    }

  //�������� ���� ������
  if ($input_data['pass'] == '' || $input_data['pass2'] == '')
    {
    // ���� ������ � ������ ������ ������ ���� �����������
    appShowMessage($_SERVER['HTTP_REFERER'], '���� \'������\' �� ���������');
    }
  elseif ($input_data['pass'] !== $input_data['pass2'])
    {
    // ���� ������ � ������ ������ ������ ���� �����������
    appShowMessage($_SERVER['HTTP_REFERER'], '���� \'������\' � \'������ ������\' �� ���������');
    }
  elseif (!preg_match("/^\w{3,}$/", $input_data['pass']))
    {
    // ������ ����� �������� �� ����, ���� � �������������
    appShowMessage($_SERVER['HTTP_REFERER'], '� ���� \'������\' ������� ������������ �������');
    }
/***********************  ����� ���������  *************************************/

  $db=DBConnector::getInstance();
  $ses_info=UserSession::getInstance();

  //�������� ��������� �� ������� ����
  $input_data['pass'] = md5($input_data['pass']);
  $input_data['addtime'] = time();
  $input_data['last_visit'] = $input_data['addtime'];
  $input_data['gid'] = 2; //������ �� ��������� "������������������ ������������"
  $input_data['active'] = 1;//����� �������
  
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

  //������������������, ������ ������ � ���� �������
  //��� ����� �������� ������ � �������� �� �������� � ��������
  $user_info['login'] = $input_data['login'];
  $user_info['gid'] = $input_data['gid'];
  $user_info['id'] = $insert_id;
  $ses_info->userLogin($user_info);

  appShowMessage('index.php?module=user&type=user&func=user_view&id='.$insert_id, '����������� ������� ���������');
  //showMessage($_SERVER['HTTP_REFERER'], '����������� ������� ���������');
  }



function user_user_user_login()
  {
  //print_r($_SERVER['HTTP_HOST']);exit;
  $tpl = tplInfo(__FUNCTION__, __FILE__);
  //�������� �� ������
  //if (!getAccess($tpl['object'], ACCESS_READ)) return;
  
  $db=DBConnector::getInstance();
  $ses_info=UserSession::getInstance();
  
  list($login, $pass) = appCleanFromInput('login', 'pass');

  if ($login == '')
    {
    appShowMessage($_SERVER['HTTP_REFERER'], '���� \'�����\' �� ���������');
    //die("���� '�����' �� ���������<br />\n");
    // ����� ����� �������� �� ����, ���� � �������������
    }
  elseif (!preg_match("/^\w{3,}$/", $login))
    {
    appShowMessage($_SERVER['HTTP_REFERER'], '� ���� \'�����\' ������� ������������ �������');
    //die("� ���� '�����' ������� ������������ �������<br />\n");
    }

  if (!preg_match("/^\w{3,}$/", $pass))
    {
    //die("� ���� '������' ������� ������������ �������<br />\n");
    appShowMessage($_SERVER['HTTP_REFERER'], '� ���� \'������\' ������� ������������ �������');
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
    appShowMessage($_SERVER['HTTP_REFERER'], '�� ���������� ����� ��� ������');
    }

  appModClassLoad('user');
  $user = new user;
  appShowMessage('index.php?module=user&type=user&func=user_view&id='.$ses_info->userId(), '���� ��������');
  //showMessage($_SERVER['HTTP_REFERER'], '���� ��������');
  }


function user_user_user_logout()
  {
  $tpl = tplInfo(__FUNCTION__, __FILE__);
  //�������� �� ������
  //if (!getAccess($tpl['object'], ACCESS_READ)) return;

  $db=DBConnector::getInstance();
  $ses_info=UserSession::getInstance();
  
  $ses_info->userLogOut();
  appShowMessage($_SERVER['HTTP_REFERER'], '����� �� �������');
  }

function user_user_user_view()
  {
  $tpl = tplInfo(__FUNCTION__, __FILE__);

  $id = appCleanFromInput('id');

  if(!is_numeric($id))
    appShowMessage($_SERVER['HTTP_REFERER'], '�� ����� ������ �� ������������!');
  //�������� �� ������
  //if (!getAccess($tpl['object'], ACCESS_READ)) return;

  $db=DBConnector::getInstance();
  $ses_info=UserSession::getInstance();

  $db->query("SELECT * FROM user WHERE id='%s'", $id);
  $user_info = $db->fetch_array();

  if(!$user_info[0])
    appShowMessage($_SERVER['HTTP_REFERER'], '�������� ������������ �� ������� ��� �� �������');

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
                     'displayname'=>'������ ��������');

  $result['object'] = $tpl['object'];
  $result['content'] = $smarty->fetch($tpl['src'],$tpl['object']);
  $result['browsein'] = $browsein;

  return $result;
  }

?>