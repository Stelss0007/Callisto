<?php
/*
 * Отправка письма
*/
function appMail($to, $subject, $body, $is_html=false)
  {
  //Значит создали обьект
  require_once('kernel/phpmailer/class.phpmailer.php');
  $mail = new PHPMailer();

  //Перекодируем все в кои8
  $subject = convert_cyr_string($subject,"w","k");
  $body = convert_cyr_string($body,"w","k");

  //Конфигурируем базовые настройки
  $mail->From = appModGetVar('app_config','mail_from');
  $mail->FromName = convert_cyr_string(appModGetVar('app_config','mail_fromname'),"w","k");
  $mail->CharSet = 'koi8-r';
  //$mail->WordWrap = $wordwrap;
  //$mail->Priority = $priority;
  //$mail->Encoding = $encoding;

  //Составляем письмо
  $mail->IsHTML($is_html);
  $mail->Subject  =  $subject;
  $mail->Body     =  $body;
  //Может быть один емайл, а может быть и много :))
  if (is_array ($to))
    {
    foreach ($to as $value)
      {
      $mail->AddAddress($value);
      };
    }
    else
      {
      $mail->AddAddress($to);
      };

  //Конфигурируем метод отправки
  $mail_method = appModGetVar('app_config','mail_method');

  //СМТП
  if ($mail_method == 'smtp')
    {
    $mail->IsSMTP();
    $mail->Host = appModGetVar('app_config','mail_smtphost');
    $mail->SMTPAuth = false;
    }

  //smtpauth
  if ($mail_method == 'smtpauth')
    {
    $mail->IsSMTP();
    $mail->Host = appModGetVar('app_config','mail_smtphost');
    $mail->SMTPAuth = true; // turn on SMTP authentication
    $mail->Username = appModGetVar('app_config','mail_smtpuser');
    $mail->Password = appModGetVar('app_config','mail_smtppass');
    }

  //sendmail
  if ($mail_method == 'sendmail')
    {
    $mail->IsSendmail();
    $mail->Sendmail = appModGetVar('app_config','mail_sendmailpath');
    }

  //qmail
  if ($mail_method == 'qmail')
    {
    $mail->IsQmail();
    }

  //PHP mail()
  if ($mail_method == 'mail')
    {
    $mail->IsMail();
    }

  if ($mail->Send())
    {
    return true;
    }

  return false;
  }

/* Увеличиваем вес элимента в базе
 * Пераетса массив в формате key=>value
 */
function appDBWeightMoveUp ($apptable, $weight, $where='')
  {
  //Если самый первый некуда уже двигать
  if ($weight==1){return true;};

  $column = appDBGetColumns($apptable);
  //Подготавливаем $where
  $where=str_replace('WHERE ','',$where);

  if ($where!='')
    {
    $where="AND $where";
    };
  //Передвигаемый элимент
  $UpedEliment=appDbSelect ($apptable, $column, "WHERE $column[weight]='$weight' $where");
  //Предвидущий элимент
  $PreviusEliment=appDbSelect ($apptable, $column, "WHERE $column[weight]='".($weight-1)."' $where");
  //
  //Собственно сама растусовка
  $PreviusEliment[weight]=$PreviusEliment[weight]+1;
  $UpedEliment[weight]=$UpedEliment[weight]-1;

  appDbUpdate ($apptable, $PreviusEliment, "WHERE $column[id]='".$PreviusEliment[id]."'");
  appDbUpdate ($apptable, $UpedEliment, "WHERE $column[id]='".$UpedEliment[id]."'");
  return true;
  };

/* Увеличиваем вес элимента в базе
 * Пераетса массив в формате key=>value
 */
function appDBWeightMoveDown ($apptable, $weight, $where='')
  {
  //Если самый нижний некуда уже двигать
  $MaxWeight=appDbMaxWeight ($apptable, $where);
  if ($weight==$MaxWeight){return true;};

  $column =  appDBGetColumns($apptable);
  //Подготавливаем $where
  $where=str_replace('WHERE ','',$where);
  if ($where!='')
    {
    $where="AND $where";
    };

  //Передвигаемый элимент
  $UpedEliment=appDbSelect ($apptable, $column, "WHERE $column[weight]='$weight' $where");
  //Следующий элимент
  $NextEliment=appDbSelect ($apptable, $column, "WHERE $column[weight]='".($weight+1)."' $where");
  //
  //Собственно сама растусовка
  $NextEliment[weight]=$NextEliment[weight]-1;
  $UpedEliment[weight]=$UpedEliment[weight]+1;

  appDbUpdate ($apptable, $NextEliment, "WHERE $column[id]='".$NextEliment[id]."'");
  appDbUpdate ($apptable, $UpedEliment, "WHERE $column[id]='".$UpedEliment[id]."'");
  return true;
  }

/*
 * Удаления веса из таблицы
*/
function appDBWeightDelete ($apptable, $weight, $where='')
  {
  //Получили столбцы
  $column = appDBGetColumns($apptable);
  //Подготавливаем $where
  $where=str_replace('WHERE ','',$where);
  if ($where!='')
    {
    $where="AND $where";
    };

  $sql = "UPDATE $apptable SET $column[weight]=$column[weight]-1
          WHERE $column[weight]>'$weight' $where";

  appDBQuery($sql);

  if (mysql_errno()!=0)
    {
    appException ('appDBWeightDelete', DATABASE_ERROR, mysql_error()."<br> $sql");
    };
  return true;
  }

/*
 * Возвращает спиисок временных зон
*/
function appGetTzList ()
  {
  /*
   * Timezone information
   */
  $tzinfo = array('0'    => '(GMT -12:00 hours) Eniwetok, Kwajalein',
                '1'    => '(GMT -11:00 hours) Midway Island, Samoa',
                '2'    => '(GMT -10:00 hours) Hawaii',
                '3'    => '(GMT -9:00 hours) Alaska',
                '4'    => '(GMT -8:00 hours) Pacific Time (US & Canada)',
                '5'    => '(GMT -7:00 hours) Mountain Time (US & Canada)',
                '6'    => '(GMT -6:00 hours) Central Time (US & Canada), Mexico City',
                '7'    => '(GMT -5:00 hours) Eastern Time (US & Canada), Bogota, Lima, Quito',
                '8'    => '(GMT -4:00 hours) Atlantic Time (Canada), Caracas, La Paz',
                '8.5'  => '(GMT -3:30 hours) Newfoundland',
                '9'    => '(GMT -3:00 hours) Brazil, Buenos Aires, Georgetown',
                '10'   => '(GMT -2:00 hours) Mid-Atlantic',
                '11'   => '(GMT -1:00 hours) Azores, Cape Verde Islands',
                '12'   => '(GMT) Western Europe Time, London, Lisbon, Casablanca, Monrovia',
                '13'   => '(GMT +1:00 hours) CET(Central Europe Time), Brussels, Copenhagen',
                '14'   => '(GMT +2:00 hours) EET(Eastern Europe Time), Kaliningrad, South Africa',
                '15'   => '(GMT +3:00 hours) Baghdad, Kuwait, Riyadh, Moscow, St. Petersburg',
                '15.5' => '(GMT +3:30 hours) Tehran',
                '16'   => '(GMT +4:00 hours) Abu Dhabi, Muscat, Baku, Tbilisi',
                '16.5' => '(GMT +4:30 hours) Kabul',
                '17'   => '(GMT +5:00 hours) Ekaterinburg, Islamabad, Karachi, Tashkent',
                '17.5' => '(GMT +5:30 hours) Bombay, Calcutta, Madras, New Delhi',
                '18'   => '(GMT +6:00 hours) Almaty, Dhaka, Colombo',
                '19'   => '(GMT +7:00 hours) Bangkok, Hanoi, Jakarta',
                '20'   => '(GMT +8:00 hours) Beijing, Perth, Singapore, Hong Kong, Chongqing',
                '21'   => '(GMT +9:00 hours) Tokyo, Seoul, Osaka, Sapporo, Yakutsk',
                '21.5' => '(GMT +9:30 hours) Adelaide, Darwin',
                '22'   => '(GMT +10:00 hours) EAST(East Australian Standard)',
                '23'   => '(GMT +11:00 hours) Magadan, Solomon Islands, New Caledonia',
                '24'   => '(GMT +12:00 hours) Auckland, Wellington, Fiji, Kamchatka');
  return ($tzinfo);
  }

/*
 * Возвращает спиисок языков в системе
*/
function appGetLangList()
  {
  $LangList=array();
  //Доступные языки
  $handle = opendir('lang');
  while ($f = readdir($handle))
    {
    if ($f != '.' && $f != '..' && $f != 'CVS' && !ereg("[.]",$f))
      {
//      $LangList[$f] = $alllang[$f];
      $LangList[$f] = $f;
      }
    }
  closedir($handle);
//  sort($LangList);
  return ($LangList);
  }

