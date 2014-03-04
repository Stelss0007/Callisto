<?php
class IndexController extends Controller
  {
  //Пример отображения результата модуля
  function view_mod()
    {
    //$this->errors->setError("Index not Exist!!!");
    $this->getAccess(ACCESS_READ);
    $this->type = 'user';
    $this->view();
    }

  function view_page()
    {
    //$_SESSION['user_gid'] = -1;
//    $this->debuger->debug("Очень простое сообщение на консоль");
//    $this->debuger->debug("object", $this);
    $obj1 = $this->test->getObjectsList(array('arg1'=>'1'), array('arg2'=>'asc'), $offset);
    
    $obj2 = $this->test->get_5_ByYearOrderByYear('49, 50, 48');
    
    print_r($obj2);
    
    $this->smarty->caching = true;
    $this->type = 'user';
    //$this->getAccess(ACCESS_ADMIN);
    $this->a = 'Hello World';
    $this->b = 'Hello World2';
    
    $this->blockAdd('left', array('block_displayname'=>'Block From Code1', 'block_content'=>'hello block1'));
    $this->blockAdd('left', array('block_displayname'=>'Block From Code2', 'block_content'=>'hello block2'));
    $this->blockAdd('left', array('block_displayname'=>'Block From Code3', 'block_content'=>'hello block3'));
    
    $this->blockAdd('right', array('block_displayname'=>'Block From Code4', 'block_content'=>'hello block4'));
    $this->blockAdd('right', array('block_displayname'=>'Block From Code5', 'block_content'=>'hello block5'));
    $this->blockAdd('bottom', array('block_displayname'=>'Block From Code6', 'block_content'=>'hello block6'));
    //$this->print_vars();
    $this->viewPage();
    }

  //Пример приема параметров через аргументы метода
  function view_arg($a='1', $b=2, $c=4, $n='0')
    {
    echo $a.$b.$c.$n;
    }
    
  //Пример работы с доступом
  function view_access()
    {
    //$this->errors->setError("Index not Exist!!!");
    $this->getAccess(ACCESS_READ);
    $this->type = 'user';
    $this->view();
    }
   
  //Пример работы с доступом
  function view_error()
    {
    $this->errors->setError("This is Error!!!");
    }  
    
  //Пример получения объекта по его ИД  
  function view_object($guid=0)
    {
    print_r($this->test->getObject($guid));
    $this->debuger->debug('Привет');
    }
  
  //Пример получения списка объектов  
  function view_objects($offset=0)
    {
    print_r($this->test->getObjectsList(array('arg1'=>'1'), array('arg2'=>'asc'), $offset));
    }
  
  //Пример удаления объекта по его ИД
  function delete_object($id=0)
    {
    $this->test->deleteObject($id);
    }
  
  //Пример обновления объекта по его ИД
  function update_object($a='1', $b=2, $c=4, $n='0')
    {
    //echo $this->test->sum(6,8);
    
    $this->test->arg2 = 55;
    $this->test->save(7);
    
    $this->usesModel('test2');
    //echo $this->test2->getName($a);
    }
    
  function add_object()
    {
    $this->view();
    }
    
  function create_object()
    {
    $post = $this->getPostData(array('lastname'=>'required min(2) max(6)', 'firstname'=>'required min(2) max(6)'));
    $this->arrayToModel($this->test, $post);
    
    $id = $this->test->save();
    
    //img
    $this->getImage('photo1', 'image/png');
    $this->saveImage($id, $name);
    
    $this->redirect("/test/view_object/".$id);
    }
    
  function test_bug($a)
    {
    $this->a = $a;
    $this->c = 45;
    $this->help = "hhjsdahfjsdhjfhsjdhfjhfjhasjhfjshdgjhsdf";
    $this->viewPage();
    //$this->session->setVar('rus', 'hello');
    
    echo $this->session->getVar('rus', '22');
    }
    
  //Пример момещения данніх в сессию  
  function set_session($a='hello')
    {
    $this->session->setVar('rus', $a);
    
    echo $this->session->getVar('rus', '22');
    }
    
  //Пример получения данных из сессии  
  function get_session($default_val='this is default')
    {
    echo $this->session->getVar('rus', $default_val);
    }
    
  //Пример пользовательского сообщения  
  function view_message($default_val='this is message')
    {
    $this->showMessage($default_val, '/index.php?module=test&action=validForm');
    }
    
  //Пример получения текущего урла и предыдущего 
  function view_urls()
    {
    echo 'url = '.$this->URL.'<br>';
    echo 'prev_url = '.$this->prevURL.'<br>';
    }
   
  //Пример редиректа 
  function view_redirect()
    {
    $this->redirect('/index.php?module=test&action=view_page');
    }

  //Пример работы формы пример отображения формы 
  function validForm()
    {
    echo stripslashes("KIOSQUE 31 L\'ESCALE BLEUE - Constitution de soci?t? : EURL");
    $this->view();
    }

  //Пример работы формы пример получения результатов, валидации данных  
  function valid()
    {
    print_r($this->getPostData(array('lastname'=>'required min(2) max(6)', 'email'=>'email')));
    print_r($this->getPostData(array('lastname'=>'required min(2) max(6)')));
    }
    
  //Пример преобразования массива в поля объекта
  function array_to_obj()
    {
    $test_array = array('name'=>'ruslan_test', 'telephone'=>'111112222');
    
    $this->arrayToModel($this->test, $test_array);
  
    $id = $this->test->save();
    
    $this->redirect('/index.php?module=test&action=array_to_obj_view&id='.$id);
    }
  //Пример преобразования массива в поля объекта
  function array_to_obj_view($guid)
    {
    print_r($this->test->getObject($guid));
    }
    
   //Пример преобразования массива в поля объекта
  function view_debugs()
    {
    $this->a = 2;
    $this->b = 3;
    
    $this->debugGetViewVars();
    
    //OR MODEL DEBUG, COMENTED UPER CODE
    
    $test_array = array('name'=>'ruslan_test', 'telephone'=>'111112222');
    
    $this->arrayToModel($this->test, $test_array);
    
    $this->debugGetViewVars();
    }
  function lib()
    {
    $a = $this->usesLib('Image');
    $this->lib->Image->test1();
    $a->test();
    }
    
  function youtube()
    {
    $this->view();
    }
  function youtube_result()
    {
    print_r($_COOKIE);
    print_r($_POST);
    print_r($_FILES);
    }
    
  function youtube_upload()
    {
    $target_url = $_POST['yt_upload_url'];//"https://uploads.gdata.youtube.com/action/FormDataUpload/AIwbFATEHzMjIEYmJl1DVdXgDbtEcmP42AYX-Y1VA9Md7wW5ATSi6uis3C8MZXCUsc3CcrzqkBMfTaikPw2hS-pxkIlLZL1NEA?nexturl=http%3A%2F%2Fcallisto.com%2Ftest%2Fyoutube%2F";
    $token = $_POST['yt_upload_token']; //'AIwbFATKcAOblRNxotDckF320VqUq2mHkBkDeMiljM7ZQn4TMCpywIPuvegQEZtjOnvDN9JBc7sVZ37cM0hkj6LnzB-GXnel7Vl2MpBULhUTP-dUCSKAYkp_v5pAQdIRv84LWoJYX3pkWfxEeZHJDwabc9WiGqfiX8C-0dNxh7u0ot9S235Fo8zNP7ndfpQ-SQMeeqpC0dlvbIDO3Mbe1vrSUef8TqYFAzC83jb0LmML3pEtYE9ianwRq-_JcI7IVXh4-cz5RCrU722lvhNx92wt254qnIOYdg';

    $file_name_with_full_path = realpath('./PSYCHO.mp4');
   
    $post = array('token' => $token,'file'=>'@'.$file_name_with_full_path);
    
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    curl_setopt($ch, CURLOPT_HEADER, 1);
    curl_setopt($ch, CURLOPT_VERBOSE, 1);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    
    curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/4.0 (compatible;)");
    curl_setopt($ch, CURLOPT_URL, $target_url);
    curl_setopt($ch, CURLOPT_POST, true);
   
    curl_setopt($ch, CURLOPT_POSTFIELDS, $post); 
    $response = curl_exec($ch);
    
    print_r($response);
    exit;
    }
  

  function table()
    {
    $this->viewPage();
    }
    
  function table_ajax()
    {
    $strRequest = file_get_contents('php://input');
    $Request = json_decode($strRequest);
    
    foreach($Request as $key=>$item)
      {
      $Request[$key]->number =  $Request[$key]->number . ' add message'.$key;
      }
    echo json_encode($Request);
    }
    
    
    
    
    
  function test_y()
    {
    
    }

  }
?>
