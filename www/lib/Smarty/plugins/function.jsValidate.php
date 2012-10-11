<?php

/*
 * Smarty plugin
 *
 * $transition      - вид перехода (1)
 * $tmb_bar         - тумсбар с прокруткой (true)
 * $speed           - скорость смены слайдов(5000мсек), если встановлен флаг автопоказа
 * $autoplay        - автопоказ слайдов 'false'
 * $height          - высота просматриваемой картинки, по ней вычисляется и ширина $height/$weight = 1/2
 * $show            - флаг показать собраный результат
 * $href            - ссылка для перехода если был клик по картинке
 * $descript        - описание, выводится в правом нижнем углу при просмотре картинки
 * $name            - имя, id галереи
 * $startOn         - номер отображаемого елемента(начинается с нуля, по умолчанию ноль)
 *
 *                    Пример вызова
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

function smarty_function_jsValidate($params, &$smarty)
  {
  extract($params);
  $style_class='1';

//
//  sysJSLoad('jsValidate', array("jsValidate"), FALSE, FALSE, TRUE);
//  sysJSLoad('jsValidate', array("jsValidate"), FALSE, FALSE, TRUE);

  sysJSLoad ('kernel','jQuery');
  sysJSLoad ('kernel','jsValidate');
  syscssLoad('kernel','jsValidate');
  

  $script = "<script>
              $(document).ready(
              function (){
              // validate the comment form when it is submitted
              $('#$name').validate();
              });
              </script>
            ";

  $style = "";
 
  $html = "";

  //Выводим на страницу элемент
  echo $style, $script, $html;
  return $result;
  }

?>