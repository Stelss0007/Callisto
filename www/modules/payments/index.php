<?php
include "lib/phpqrcode/qrlib.php";

class IndexController extends Controller
  {
  function actionIndex()
    {
    $this->redirect('/admin/users');
    }
    
  function actionGetCode(){
        // Создаем и выводим QR код с текстом
        $backColor = 0xFFFF00;
        $foreColor = 0xFF00FF;

        // Создаем QR код в формате SVG
        //QRcode::svg("http://phpmaster.com", false, "L", 6, 6, false, $backColor, $foreColor);
        $data = [
            'user_name' => 'Ruslan',
            'summa' => '20',
            'phone'	=> '0978803826',
            'description' => 'Тестовый платеж'
        ];

        $userParams = json_decode(base64_decode($_GET['sign_v1']));

        $data['summa'] = $userParams->summa;
        $data['description'] = $userParams->description;

        //echo json_encode($data, JSON_UNESCAPED_UNICODE);exit;
        //var_dump($data);exit;

        $qrProcessingServerPageName = 'http://callisto/payments/transfer?sign_id=';
        $qrContent = $qrProcessingServerPageName.base64_encode(json_encode($data, JSON_UNESCAPED_UNICODE));

        header('Access-Control-Allow-Origin: ' . $_SERVER['HTTP_ORIGIN']);
        header("Content-type: image/png");

        ob_start();
        QRcode::png($qrContent, false, "L", 6, 6, false);
        $imageString = base64_encode(ob_get_contents());
        ob_end_clean();

        echo 'data:image/png;base64,'.$imageString;
        exit;
  }
  
  function actionLogin()
    {
    $data = $this->inputVars;
    if($data['submit'])
      {
      $login = $this->users->logIn($data['login'], $data['pass']);
      if(empty($login))
        {
        $this->showMessage($this->t('no_user_pass'), null, null, MESSAGE_ERROR);
        $this->redirect();
        }
      $this->showMessage($this->t('login_success'));
      $this->redirect();
      }
      
    if($this->users->isLogin())
      {
      $this->isLogin = true;
      }
    else
      {
      $this->isLogin = false;
      }  
    $this->viewPage();
    }
  }

