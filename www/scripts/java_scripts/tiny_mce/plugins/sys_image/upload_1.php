<?php

//TODO �� �������� ����_����
$mime = array('image/bmp'=>true,
              'image/gif'=>true,
              'image/jpeg'=>true,
              'image/png'=>true);

$maxsize = 20971520;
/*
����������� ���� ART 	image/x-jg        ��� �� ���� �� ���������
����������� ���� BMP 	image/bmp
����������� ���� GIF 	image/gif
����������� ���� JPEG 	image/jpeg
����������� ���� PNG (.png) 	image/png
����������� ���� TIFF 	image/tiff        � �� ���� �� ���������
 */

if($mime[$_FILES['userfile']['type']])
  {
  if($_FILES['userfile']['size']<$maxsize)
    {
    $root = $_SERVER['DOCUMENT_ROOT'];
    $uploaddir = '/diskdb/blogs/uploadimages/';
    $e = substr( $_FILES['userfile']['name'], strrpos($_FILES['userfile']['name'], '.') - 1 );
    $fname = sha1_file($_FILES['userfile']['tmp_name']);
    $uploaddir .= substr($fname,-1).'/';

      global $sysConfig;
      $dir_perms = $sysConfig['default.dir.perms'];

      if (!file_exists($root.$uploaddir))
        mkdir($root.$uploaddir, $dir_perms, true);

    $fname .= $e;
    if (move_uploaded_file($_FILES['userfile']['tmp_name'], $root.$uploaddir.$fname))
      {
      print "File is valid, and was successfully uploaded.";
      echo '<script type="text/javascript">' ;
      echo     'window.top.opener.OpenFile("'.$uploaddir.$fname.'"); ';
      echo     'window.top.close();';
      echo '</script>' ;
      }
    else
      echo '�� ������� ��������� ��� ����';
    }
  else
    {
    echo '������ ������������ ����� ������� �����';
    unlink($_FILES['userfile']['tmp_name']);
    }
  }
  else
  {
    echo '��� ������������ ����� �� ��������������';
    unlink($_FILES['userfile']['tmp_name']);
  }
?>
