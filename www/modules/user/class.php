<?php
class user
  {
  function professionList()
    {
    $result = array();
    $result[0] = "Не задано...";
    $result[1] = "Учусь в школе";
    $result[2] = "Студент";
    $result[3] = "Предприниматель";
    $result[4] = "Работник на предприятии";
    $result[5] = "Служащий на предприятии";
    $result[6] = "Не имею основного места работы";
    return $result;
    }

  function maritalStatusList()
    {
    $result = array();
    $result[0] = "Не задано...";
    $result[1] = "Женат/замужем, есть дети";
    $result[2] = "Женат/замужем, нет детей";
    $result[3] = "Не женат/не замужем, есть дети";
    $result[4] = "Не женат/не замужем, нет детей";
    $result[5] = "Разведён/разведена, есть дети";
    $result[6] = "Разведён/разведена, нет детей";
    return $result;
    }

  function sexList()
    {
    $result = array();
    $result[0] = "Не задано...";
    $result[1] = "Мужской";
    $result[2] = "Женский";
    return $result;
    }

  function createImage($upload, $insert_id)
    {
    //Путь к картинке источнику
    $path = $upload['tmp_name'];

    $type_array = array('gif'=>IMG_GIF,
                        'jpg'=>IMG_JPG,
                        'jpeg'=>IMG_JPG,
                        'png'=>IMG_PNG,
                        'png'=>3,
                        'bmp'=>IMG_WBMP,
                        'wbmp'=>IMG_WBMP);
    
    //Попытаемся прочитать картинку
    $imginfo = getimagesize($path);
    if(!in_array($imginfo[2], $type_array))
      return false;

    appUsesLib('Image');
    $im = new Image;

    //Ревизия
    $revision_sufix = ($upload['photo_r'])?$upload['photo_r']:'0';
    //Путь к картинке
    $full_fileid = str_pad($insert_id, 8, "0", STR_PAD_LEFT);
    $dir_photo = './images/user/photo/' . $full_fileid[7] . '/' . $full_fileid[6] . '/'.$full_fileid.'/';
    $src_photo = './images_src/user/photo/' . $full_fileid[7] . '/' . $full_fileid[6] . '/';

    $dir_perms = 0775;
    //Создадим директорию если ее нету
    if(!file_exists($dir_photo))
      mkdir($dir_photo, $dir_perms, true);
    //Создадим директорию если ее нету
    if(!file_exists($src_photo))
      mkdir($src_photo, $dir_perms, true);
    //Информация о картинке
    $photo_img_array = array();
    
    $im->load($path);
    $im->resizeToWidth(150);
    $im->save($dir_photo.$full_fileid.'_w150_'.$revision_sufix.'.jpg', IMAGETYPE_JPEG, 90);

    $im->load($dir_photo.$full_fileid.'_w150_'.$revision_sufix.'.jpg');

    $photo_img_array['photo_h'] = $im->getHeight();
    $photo_img_array['photo_w'] = $im->getWidth();
    $photo_img_array['photo_r'] = $revision_sufix;

    return $photo_img_array;
    }


  }
?>