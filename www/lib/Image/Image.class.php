<?php

/*
 * Класс работы с изображениями
 */

class Image
  {

  var $image;
  var $image_type;
  var $test1 = 1;

  function test1()
    {
    $this->test1 = 'hello';
    }
  function test()
    {
    echo $this->test1;
    }
  function load($filename)
    {
    $image_info = getimagesize($filename);
    $this->image_type = $image_info[2];
    if ($this->image_type == IMAGETYPE_JPEG)
      {
      $this->image = imagecreatefromjpeg($filename);
      }
    elseif ($this->image_type == IMAGETYPE_GIF)
      {
      $this->image = imagecreatefromgif($filename);
      }
    elseif ($this->image_type == IMAGETYPE_PNG)
      {
      $this->image = imagecreatefrompng($filename);
      }
    }

  function save($filename, $image_type=IMAGETYPE_JPEG, $compression=98, $permissions=null)
    {
    if ($image_type == IMAGETYPE_JPEG)
      {
      imagejpeg($this->image, $filename, $compression);
      }
    elseif ($image_type == IMAGETYPE_GIF)
      {
      imagegif($this->image, $filename);
      }
    elseif ($image_type == IMAGETYPE_PNG)
      {
      imagepng($this->image, $filename);
      }
    if ($permissions != null)
      {
      chmod($filename, $permissions);
      }
    imagedestroy($this->image);
    }

  function output($image_type=IMAGETYPE_JPEG)
    {
    if ($image_type == IMAGETYPE_JPEG)
      {
      imagejpeg($this->image);
      }
    elseif ($image_type == IMAGETYPE_GIF)
      {
      imagegif($this->image);
      }
    elseif ($image_type == IMAGETYPE_PNG)
      {
      imagepng($this->image);
      }
    }

  function getWidth()
    {
    return imagesx($this->image);
    }

  function getHeight()
    {
    return imagesy($this->image);
    }

  function resizeToHeight($height)
    {
    $ratio = $height / $this->getHeight();
    $width = $this->getWidth() * $ratio;
    $this->resize_strong($width, $height);
    }

  function resizeToWidth($width)
    {
    $ratio = $width / $this->getWidth();
    $height = $this->getheight() * $ratio;
    $this->resize_strong($width, $height);
    }

  function resize($w, $h)
    {
    $ratio = $w/$h; 
    $src_ratio=$this->getWidth()/$this->getheight();
    
    if ($ratio<$src_ratio) 
      { 
      $h = $w/$src_ratio; 
      } 
    else 
      { 
      $w = $h*$src_ratio; 
      } 
    $this->resize_strong($w, $h);
    }
    
  function scale($scale)
    {
    $width = $this->getWidth() * $scale / 100;
    $height = $this->getheight() * $scale / 100;
    $this->resize($width, $height);
    }

  function resize_strong($width, $height)
    {
    $new_image = imagecreatetruecolor($width, $height);
    imagecopyresampled($new_image, $this->image, 0, 0, 0, 0, $width, $height, $this->getWidth(), $this->getHeight());
    $this->image = $new_image;
    }

  }
