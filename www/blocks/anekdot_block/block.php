<?php
class anekdot_block extends Block
  {
  function display(&$blockinfo)
    {
    //Проверка на доступ
    //if (!sysSecAuthAction($sysObject, ACCESS_READ)) return true;

   
    //Настройки модуля
    $port = '80';
    $query = 'anekdot/'.date('d').'.html';
    $host = 'anekdotov.net';
    $maxlen = 4096;
    $referer = 'http://www.anekdotov.net/';
    $useragent = 'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1)';
    $timeout = 5;
    $reload_time = 60*60*24; // Раз в сутки
    $reload_iferr_time = 60*20; // 20 минут


    //Скачиваем
//    $fp = @fsockopen($host, $port, $errno, $errstr, $timeout);
//
//    fputs($fp, 'GET http://' . $host . '/' . $query . " HTTP/1.0\r\n");
//    fputs($fp, 'Host: ' . $host . "\r\n");
//    fputs($fp, 'Referer: ' . $referer . "\r\n");
//    fputs($fp, 'User-Agent: ' . $useragent . "\r\n\r\n");
//    $buffer = '';
//    $start_time = time();
//    while(!feof($fp))
//      {
//      $line = fgets($fp, 4096);
//      $line = str_replace("\n","",$line);
//      $line = str_replace("\r","",$line);
//      $buffer .= $line;
//      }
//    fputs($fp, "Connection: close\r\n\r\n");
//    fclose($fp);
//
//    // Парсим
//    $anekdots_list = array();
//    preg_match_all('/<p align=justify>(.*?)<br><br>/', $buffer, $struct);
//    foreach ($struct[1] as $v)
//      {
//      $v = strip_tags($v, '<BR>')."\n";
//      $v = str_replace('<BR>', "\r", $v);
//      if (strlen($v) <= $maxlen)
//        {
//        $anekdots_list[] = str_replace("\r","<br>",$v);
//        }
//      }
//    $rand_anek_id = rand(0, 9);
//    $this->anekdot = $anekdots_list[$rand_anek_id];

    return $this->view();
    }
  }
?>