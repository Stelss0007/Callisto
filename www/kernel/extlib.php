<?php
/*
 * �������� ������
*/
function sysMail($to, $subject, $body, $is_html=false)
  {
  //������ ������� ������
  require_once('kernel/phpmailer/class.phpmailer.php');
  $mail = new PHPMailer();

  //������������ ��� � ���8
  $subject = convert_cyr_string($subject,"w","k");
  $body = convert_cyr_string($body,"w","k");

  //������������� ������� ���������
  $mail->From = sysModGetVar('SYS_config','mail_from');
  $mail->FromName = convert_cyr_string(sysModGetVar('SYS_config','mail_fromname'),"w","k");
  $mail->CharSet = 'koi8-r';
  //$mail->WordWrap = $wordwrap;
  //$mail->Priority = $priority;
  //$mail->Encoding = $encoding;

  //���������� ������
  $mail->IsHTML($is_html);
  $mail->Subject  =  $subject;
  $mail->Body     =  $body;
  //����� ���� ���� �����, � ����� ���� � ����� :))
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

  //������������� ����� ��������
  $mail_method = sysModGetVar('SYS_config','mail_method');

  //����
  if ($mail_method == 'smtp')
    {
    $mail->IsSMTP();
    $mail->Host = sysModGetVar('SYS_config','mail_smtphost');
    $mail->SMTPAuth = false;
    }

  //smtpauth
  if ($mail_method == 'smtpauth')
    {
    $mail->IsSMTP();
    $mail->Host = sysModGetVar('SYS_config','mail_smtphost');
    $mail->SMTPAuth = true; // turn on SMTP authentication
    $mail->Username = sysModGetVar('SYS_config','mail_smtpuser');
    $mail->Password = sysModGetVar('SYS_config','mail_smtppass');
    }

  //sendmail
  if ($mail_method == 'sendmail')
    {
    $mail->IsSendmail();
    $mail->Sendmail = sysModGetVar('SYS_config','mail_sendmailpath');
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

/* ����������� ��� �������� � ����
 * �������� ������ � ������� key=>value
 */
function sysDBWeightMoveUp ($systable, $weight, $where='')
  {
  //���� ����� ������ ������ ��� �������
  if ($weight==1){return true;};

  $column = sysDBGetColumns($systable);
  //�������������� $where
  $where=str_replace('WHERE ','',$where);

  if ($where!='')
    {
    $where="AND $where";
    };
  //������������� �������
  $UpedEliment=sysDbSelect ($systable, $column, "WHERE $column[weight]='$weight' $where");
  //����������� �������
  $PreviusEliment=sysDbSelect ($systable, $column, "WHERE $column[weight]='".($weight-1)."' $where");
  //
  //���������� ���� ����������
  $PreviusEliment[weight]=$PreviusEliment[weight]+1;
  $UpedEliment[weight]=$UpedEliment[weight]-1;

  sysDbUpdate ($systable, $PreviusEliment, "WHERE $column[id]='".$PreviusEliment[id]."'");
  sysDbUpdate ($systable, $UpedEliment, "WHERE $column[id]='".$UpedEliment[id]."'");
  return true;
  };

/* ����������� ��� �������� � ����
 * �������� ������ � ������� key=>value
 */
function sysDBWeightMoveDown ($systable, $weight, $where='')
  {
  //���� ����� ������ ������ ��� �������
  $MaxWeight=sysDbMaxWeight ($systable, $where);
  if ($weight==$MaxWeight){return true;};

  $column =  sysDBGetColumns($systable);
  //�������������� $where
  $where=str_replace('WHERE ','',$where);
  if ($where!='')
    {
    $where="AND $where";
    };

  //������������� �������
  $UpedEliment=sysDbSelect ($systable, $column, "WHERE $column[weight]='$weight' $where");
  //��������� �������
  $NextEliment=sysDbSelect ($systable, $column, "WHERE $column[weight]='".($weight+1)."' $where");
  //
  //���������� ���� ����������
  $NextEliment[weight]=$NextEliment[weight]-1;
  $UpedEliment[weight]=$UpedEliment[weight]+1;

  sysDbUpdate ($systable, $NextEliment, "WHERE $column[id]='".$NextEliment[id]."'");
  sysDbUpdate ($systable, $UpedEliment, "WHERE $column[id]='".$UpedEliment[id]."'");
  return true;
  };

/*
 * �������� ���� �� �������
*/
function sysDBWeightDelete ($systable, $weight, $where='')
  {
  //�������� �������
  $column = sysDBGetColumns($systable);
  //�������������� $where
  $where=str_replace('WHERE ','',$where);
  if ($where!='')
    {
    $where="AND $where";
    };

  $sql = "UPDATE $systable SET $column[weight]=$column[weight]-1
          WHERE $column[weight]>'$weight' $where";

  sysDBQuery($sql);

  if (mysql_errno()!=0)
    {
    sysException ('sysDBWeightDelete', DATABASE_ERROR, mysql_error()."<br> $sql");
    };
  return true;
  };

/*
 * ���������� ������� ��������� ���
*/
function sysGetTzList ()
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
  };

/*
 * ���������� ������� ������ � �������
*/
function sysGetLangList()
  {
  $LangList=array();
  //��������� �����
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
  };



?>