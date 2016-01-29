<?php
include "lib/phpqrcode/qrlib.php";

class APIController extends Controller
  {
    
  function actionAuthorize()
    {
    $params = json_decode(base64_decode($this->getInput('sign_v1')));
      
    $user = \app\modules\payments\models\UserBankInfo::findOne(['phone'=>$params->phone]);
    
    if(!$user) 
        {
        return ['status'=>'error', 'message'=>'Пользователь с таким номером телефона не существует', 'code'=>1];
        }
    if($user->pin != md5($params->pin))
        {
        return ['status'=>'error', 'message'=>'Не верный пинкод', 'code'=>2];
        }
    
    $userSession = \app\lib\UserSession\UserSession::getInstance();
    $userSession->setVar('userInfo', $user);
   
    return ['status'=>'ok'];
    }
    
  function actionUserCreate()
    {
    $user = \app\modules\payments\models\UserBankInfo::findOne(['phone'=>$this->getInput('phone')]);
    
    if($user)
        {
        return ['status'=>'error', 'message'=>'Пользователь с таким номером телефона уже существует'];
        }
        
    $userParams = $this->getInput();
    
    $user = new \app\modules\payments\models\UserBankInfo();
    $user->setAttributesByArray($userParams);
   
    return ['status'=>'ok'];
    }
    
  function actionGetCode(){
        // Создаем и выводим QR код с текстом
        $backColor = 0xFFFF00;
        $foreColor = 0xFF00FF;

        // Создаем QR код в формате SVG
        //QRcode::svg("http://phpmaster.com", false, "L", 6, 6, false, $backColor, $foreColor);

        $userSession = \app\lib\UserSession\UserSession::getInstance();
        $userInfo = $userSession->getVar('userInfo');
         
        $userName = $userInfo->first_name.' '.$userInfo->last_name;
        
        $data = [
            'user_name' => $userName,
            'phone'	=> $userInfo->phone,
        ];
//appDebugExit($_SESSION);
        $userParams = json_decode(base64_decode($this->getInput('sign_v1')));

        $data['summa'] = $userParams->summa;
        $data['description'] = $userParams->description;

        //echo json_encode($data, JSON_UNESCAPED_UNICODE);exit;
        //var_dump($data);exit;

        $qrProcessingServerPageName = 'http://callisto/payments/transfer?sign_id=';
        $qrContent = $qrProcessingServerPageName.base64_encode(json_encode($data, JSON_UNESCAPED_UNICODE));
//print_r($data);
//echo json_encode($data, JSON_UNESCAPED_UNICODE);exit;
        header("Content-type: image/png");

        ob_start();
        QRcode::png($qrContent, false, "L", 6, 6, false);
        $imageString = base64_encode(ob_get_contents());
        ob_end_clean();

        echo 'data:image/png;base64,'.$imageString;
        exit;
  }
  
 
  }

