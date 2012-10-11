<?php

/*
 * Smarty plugin
 *
 * $value       - Значение, ид населенного пункта (0)
 * $minChars    - Минимальное количество введенных символов, после которых отправится запрос (2)
 * $autoFill    - Автозаполнения текстового поля (false)
 * $cached      - Кеширование (true)
 * $cacheLength - Длина Кеша (30)
 * $limit       - Лимит возвращаемых/отображаемых данных (10)
 * $file        - файл обработчик 'index.php'
 * $delay       - Задержка в милисекундах перед отправкой запроса, после того как была отпущена клавиша(40)
 * $width       - Ширина компонента (500)
 * $type        - Тип элемента(short) (short - Просто текстовое поле, full - C выпадающим списком стран)
 *
 */

function smarty_function_my_hit_search($params, &$smarty)
  {
  extract($params);
  sysJSLoad ('kernel','jQuery');
   if (empty($sufix)) $sufix='[]';
  
  if (empty($minChars)) $minChars = '2';
  if (empty($autoFill)) $autoFill = 'false';
  if (empty($cached)) $cached = 'true';
  if (empty($limit)) $limit = '10';
  if (empty($cacheLength)) $cacheLength = '30';
  if (empty($delay)) $delay = '400';
  if (empty($value)) $value = '';
  if (empty($id)) $id = '0';
  if (empty($text)) $text = '';
  
  if (empty($width)) $width = '500';
  if (empty($scrollHeight)) $scrollHeight = '210';
  if (empty($type) || $type!='full') $type = 'short';

  if (empty($multy)) {$multy = false; $sufix ='';}
  

  //Проверка двойных загрузок
	static $loaded = array();

  $name = rtrim($name,"[]");
  $loaded[$name]=$loaded[$name]+1;

  if($loaded[$name]>1)
    {
    $obj_id=$name.($loaded[$name]-1);
    $obj_id=str_replace('[', '_', $obj_id);
    $obj_id=trim($obj_id,']');
    
    }
  else
    {
    $obj_id = $name;
    $obj_id=str_replace('[', '_', $obj_id);
    $obj_id=trim($obj_id,']');
    }
  
  //////////////////////////////////////////////////////////////////////////////
  //min variant
  if($type=='short')
    {
    if (empty($file))$file = "index.php?module=kino_star&type=ajax&func=get_star_full";

    if(empty ($visible))
      $visible = 'none';

    if (empty($bgcolor)) $bgcolor = 'wheat';

    sysJsLoad("kernel", "jQuery");
    sysJsLoad("kernel", "jsAutocomplate");
    sysCssLoad("kernel", "jsAutocomplate");


    $script = "

             <script language='javascript' >
            $(document).ready(function () {
              
             //============================================================================
              function $obj_id"."_format(object) {
                var result = '';
                if(object.img)
                  {
                  result = result + '<img src=\"'+object.img+'\" width=\"40\">';
                  }
               
               result = result + '<div style=\"display: inline-block; vertical-align: top; padding-left: 5px;\">'+object.label;
               if(object.info)
                {
                 result = result + '<br><font size=\"1\" color=\"#595959\" face=\"Arial\">';
                 result = result + object.info;
                 result = result + '</font>';
                }
               return   result + '</div>';
              }

              function $obj_id"."_format_result(object) {
                
                return object.label;
              }

              $('#$obj_id"."_text').blur(function(e){
               if($('#$obj_id"."_id').val()==0)
               {";
    if($autoAdd)
      {
      $script .="
               var objName = $('#".$obj_id."_text').val();
               var add_btn=\"&nbsp;<a href='' onclick='myWindow(\\\"$autoAdd\\\", \\\"Добавление\\\", \\\"\"+objName+\"\\\"); return false;\'><img src=\'/files/shared/images/system/add.gif\' style=\'vertical-align: middle;\'></a>\";
               ";
      }
     $script .="
               $('#$obj_id"."_labelOk').css('display', 'inline');
               $('#$obj_id"."_labelOk').css('color', 'red');
               $('#$obj_id"."_labelOk').html('X'+add_btn);
               }
              });

              $('#$obj_id"."_text').autocomplete_geo('$file&term='+$('#$obj_id"."_text').val(), {
                multiple: false,
                dataType: 'json',
                width:$width,
                minChars:$minChars,
                autoFill: $autoFill,
                matchCase: $cached,
                max:$limit,
                cacheLength:$cacheLength,
                delay:$delay,
                scrollHeight:$scrollHeight,

                parse: function(data,i, max) {
                  $('#$obj_id"."_id').val('0');
                  $('#$obj_id"."_temp').val($('#$obj_id"."_text').val());
                  if(max != 1 )
                    {
                    $('#$obj_id"."_id').val('0');
                    $('#$obj_id"."_labelOk').html(max);
                    }
                  else
                    {
                    $('#$obj_id"."_labelOk').css('display', 'inline');
                    $('#$obj_id"."_labelOk').css('color', 'green');
                    $('#$obj_id"."_id').val(item.id);
                    $('#$obj_id"."_labelOk').html('&radic;');
                    }

                  return $.map(data, function(row) {
                    var res = $obj_id"."_format_result(row);
                    return {
                      data: row,
                      value: res,
                      result: res
                    }
                  });
                },

                formatItem: function(item, i, max) {
                  if(max != 1 )
                    {
                    $('#$obj_id"."_id').val('0');
                    $('#$obj_id"."_labelOk').html('');
                    }
                  else
                    {
                    $('#$obj_id"."_labelOk').css('display', 'inline');
                    $('#$obj_id"."_labelOk').css('color', 'green');
                    $('#$obj_id"."_id').val(item.id);
                    $('#$obj_id"."_labelOk').html('&radic;');
                    }
                  return $obj_id"."_format(item);
                }
              })

              .result(function(event, item){
                $('#$obj_id"."_id').val(item.id);
                $('#$obj_id"."_temp').val($('#$obj_id"."_text').val());
                $('#$obj_id"."_labelOk').html('&radic;');
                $('#$obj_id"."_labelOk').css('display', 'inline');
                $('#$obj_id"."_labelOk').css('color', 'green');
              })

              .click(function(e){
                      if($('#$obj_id"."_temp').val() != $('#$obj_id"."_text').val())
                        {
                        $('#$obj_id"."_id').val('0');
                        $('#$obj_id"."_labelOk').css('display', 'none');
                        }
                      });


            //----------
            if ($.browser.mozilla && $.browser.version.substr(0,3)=='1.9') {
                   $('#$obj_id"."_text').bind('input', function() {
                     $('#$obj_id"."_text').click();
                    });
                }
                else {
                    $('#$obj_id"."_text').bind('keyup', function() {
                        $('#$obj_id"."_text').click();
                    });
                }

            });


            </script>
            ";


    //Собераем сам INPUT
    $input_view = "
                    <input type='hidden' value='$autoAdd' id='$obj_id"."_file_add'>
                    <input type='hidden' value='$id' id='$obj_id"."_id' name='$name"."_id$sufix'>
                    <input type='hidden' value='$text' id='$obj_id"."_temp'>
                    <input value='$text' class='ac_input' id='$obj_id"."_text' name='$name"."$sufix' type='text' style='width: $width"."px;'>
                    <span id='$obj_id"."_labelOk' style='display: $visible; color: green; font-family:bold; font-size: 20;'>&radic;</span>
                    
                  ";


    //Выводим на страницу элемент
    echo $script;
    echo $input_view;

    return; // $result;
    }
  }
 

?>
