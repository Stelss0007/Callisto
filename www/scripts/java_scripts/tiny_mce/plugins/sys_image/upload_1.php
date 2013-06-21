<?php

//TODO из сетингов макс_сайз
$mime = array('image/bmp'=>true,
              'image/gif'=>true,
              'image/jpeg'=>true,
              'image/png'=>true);

$maxsize = 20971520;
/*
Графический файл ART 	image/x-jg        вот на этот не проверяет
Графический файл BMP 	image/bmp
Графический файл GIF 	image/gif
Графический файл JPEG 	image/jpeg
Графический файл PNG (.png) 	image/png
Графический файл TIFF 	image/tiff        и на этот не проверяет
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
      echo 'Не удалось загрузить ваш файл';
    }
  else
    {
    echo 'Размер зажружаемого файла слишком велик';
    unlink($_FILES['userfile']['tmp_name']);
    }
  }
  else
  {
    echo 'Тип зажружаемого файла не поддерживается';
    unlink($_FILES['userfile']['tmp_name']);
  }
?>
