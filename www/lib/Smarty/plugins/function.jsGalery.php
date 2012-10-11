<?php

/*
 * Smarty plugin
 *
 * $transition      - ��� �������� (1)
 * $tmb_bar         - ������� � ���������� (true)
 * $speed           - �������� ����� �������(5000����), ���� ���������� ���� ����������
 * $autoplay        - ��������� ������� 'false'
 * $height          - ������ ��������������� ��������, �� ��� ����������� � ������ $height/$weight = 1/2
 * $show            - ���� �������� �������� ���������
 * $href            - ������ ��� �������� ���� ��� ���� �� ��������
 * $descript        - ��������, ��������� � ������ ������ ���� ��� ��������� ��������
 * $name            - ���, id �������
 * $startOn         - ����� ������������� ��������(���������� � ����, �� ��������� ����)
 *
 *                    ������ ������
 *
    {jsGalery name='rus4' src='img1/1.jpg' descript='Htllo world!!!' href='http://google.ru' }
    {jsGalery name='rus4' src='img1/2.jpg' descript='Hello rus!!!'}
    {jsGalery name='rus4' src='img1/3.jpg'}
    {jsGalery name='rus4' src='img1/4.jpg'}
    {jsGalery name='rus4' src='img1/5.jpg'}
    {jsGalery name='rus4' src='img1/6.jpg'}
    {jsGalery name='rus4' src='img1/7.jpg'}
    {jsGalery name='rus4' src='img1/8.jpg'}
    {jsGalery name='rus4' src='img1/9.jpg'}
    {jsGalery name='rus4' src='img1/10.jpg'}
 
    {jsGalery name='rus4' show=true autoplay='false'  transition='0' height=330 speed=3000}
 */

function smarty_function_jsGalery($params, &$smarty)
  {
  extract($params);
  $style_class='1';
  if(!$autoplay || $autoplay=='false')
    {
    $autoplay = 'false';
    $style_class=".pika-textnav a.play div {display:none;}";
    }

  if(!$transition)
    $transition = '1';

  if(!$tmb_bar)
    $tmb_bar = 'true';

  if(!$speed)
    $speed = '5000';

  if(!$height)
    {
    $height = 250;
    }

  if(!$startOn)
    {
    $startOn=0;
    }

  $width = $height * 2;
  $thumb_line_width = $width-10;

  global $jsGaleryImagesHTML;
  //������� ��� ��������
  //$imagesHTML = '';
  if(!$show)
    {
      $temp_img = "<img src='$src'/>";
      if ($href) 
        $temp_img = "<a href='$href'>".$temp_img."</a>" ;
        else
          $temp_img = "<a href=\"javascript:$('#$name').PikaChoose.nextClick;\">".$temp_img."</a>";
      if ($descript) $temp_img = $temp_img."<span>$descript</span>";
      $jsGaleryImagesHTML .= "<li>$temp_img</li>";
     
      return;
    }

  if (empty($width)) $width = '100%';

  sysJSLoad('jsGalery', array("jsGalery"), FALSE, FALSE, TRUE);

  $script = "<script>
              $(document).ready(
              function (){
                $('#$name').PikaChoose({autoPlay:$autoplay, speed:$speed, transition:[$transition], carousel:$tmb_bar, startOn:$startOn});
              });
              </script>
            ";

  $style = "
            <style>
              $style_class
              .pika-stage {width: $width"."px; height: $height"."px;}
              .jcarousel-skin-pika .jcarousel-clip-horizontal {width:$thumb_line_width"."px;}
            </style>
           ";
 
  $html = "
          <div class='pikachoose'>
            <ul id='$name' class='jcarousel-skin-pika'>
              $jsGaleryImagesHTML
            </ul>
          </div>
         ";

  //������� �� �������� �������
  echo $style, $script, $html;
  $jsGaleryImagesHTML = '';
  return $result;
  }

?>