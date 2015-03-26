<?php
class Statistic extends Model
  {
  var $table = '`statistic`';
  
  public function setLog() 
    {
    $offset = 0;
    $currentTime = time();
    $t = $currentTime + 3600*$offset;
    $day = date("D",$t);
    $dt = date("Ymd",$t);
    $tm = date("H:i",$t);
    $refer = $_SERVER['HTTP_REFERER'];
    $lang = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2);
    $user = $_SERVER['HTTP_USER_AGENT'];
    $req = $_SERVER['REQUEST_URI'];
    $ip = null;
    
    if ($ip = $_SERVER['HTTP_X_FORWARDED_FOR'])
        {
        if (!stristr($_SERVER['HTTP_X_FORWARDED_FOR'], $_SERVER['REMOTE_ADDR']) and !empty($_SERVER['HTTP_X_FORWARDED_FOR'])) 
           $ip .= ", ".$_SERVER['REMOTE_ADDR']; 
        else 
           $ip = $_SERVER['REMOTE_ADDR'];

        $proxy = $_SERVER['REMOTE_ADDR'];
        }
    else 
        { 
        $ip = $_SERVER['REMOTE_ADDR']; 
        $proxy = ""; 
        }
    if ($proxy == $ip) 
        $proxy = "";
    
    $a = explode(", ",$ip); 
    $real_ip = $a[count($a)-1];
    
    if (!empty($proxy)) 
        $host = gethostbyaddr($proxy); 
    elseif 
        ($host = gethostbyaddr($ip));
    elseif 
        ($host = gethostbyaddr($real_ip)) ; 
    else 
        $host = $ip;

    $userhash = $_COOKIE["userhash"]; // Узнаём, что за пользователь
    if (!$userhash) {
      /* Если это новый пользователь, то добавляем ему cookie, уникальные для него */
      $userhash = uniqid();
      setcookie("userhash", $userhash, 0x6FFFFFFF);
    }
   
    
    $this->timestamp = $currentTime;
    $this->userhash = $userhash;
    $this->day = $day;
    $this->dt = $dt;
    $this->tm = $tm;
    $this->refer = $refer;
    $this->ip = $ip;
    $this->proxy = $proxy;
    $this->host = $host;
    $this->lang = $lang;
    $this->user = $user;
    $this->req = $req;
    $this->save();
    }
  }
