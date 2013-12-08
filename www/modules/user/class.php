<?php
class user
  {
  function professionList()
    {
    $result = array();
    $result[0] = "�� ������...";
    $result[1] = "����� � �����";
    $result[2] = "�������";
    $result[3] = "���������������";
    $result[4] = "�������� �� �����������";
    $result[5] = "�������� �� �����������";
    $result[6] = "�� ���� ��������� ����� ������";
    return $result;
    }

  function maritalStatusList()
    {
    $result = array();
    $result[0] = "�� ������...";
    $result[1] = "�����/�������, ���� ����";
    $result[2] = "�����/�������, ��� �����";
    $result[3] = "�� �����/�� �������, ���� ����";
    $result[4] = "�� �����/�� �������, ��� �����";
    $result[5] = "�������/���������, ���� ����";
    $result[6] = "�������/���������, ��� �����";
    return $result;
    }

  function sexList()
    {
    $result = array();
    $result[0] = "�� ������...";
    $result[1] = "�������";
    $result[2] = "�������";
    return $result;
    }

  function createImage($upload, $insert_id)
    {
    //���� � �������� ���������
    $path = $upload['tmp_name'];

    $type_array = array('gif'=>IMG_GIF,
                        'jpg'=>IMG_JPG,
                        'jpeg'=>IMG_JPG,
                        'png'=>IMG_PNG,
                        'png'=>3,
                        'bmp'=>IMG_WBMP,
                        'wbmp'=>IMG_WBMP);
    
    //���������� ��������� ��������
    $imginfo = getimagesize($path);
    if(!in_array($imginfo[2], $type_array))
      return false;

    appUsesLib('Image');
    $im = new Image;

    //�������
    $revision_sufix = ($upload['photo_r'])?$upload['photo_r']:'0';
    //���� � ��������
    $full_fileid = str_pad($insert_id, 8, "0", STR_PAD_LEFT);
    $dir_photo = './images/user/photo/' . $full_fileid[7] . '/' . $full_fileid[6] . '/'.$full_fileid.'/';
    $src_photo = './images_src/user/photo/' . $full_fileid[7] . '/' . $full_fileid[6] . '/';

    $dir_perms = 0775;
    //�������� ���������� ���� �� ����
    if(!file_exists($dir_photo))
      mkdir($dir_photo, $dir_perms, true);
    //�������� ���������� ���� �� ����
    if(!file_exists($src_photo))
      mkdir($src_photo, $dir_perms, true);
    //���������� � ��������
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