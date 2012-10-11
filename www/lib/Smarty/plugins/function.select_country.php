<?php

/*
 * Smarty plugin
 *
 * $minChars    - Минимальное количество введенных символов, после которых отправится запрос (2)
 * $autoFill    - Автозаполнения текстового поля (false)
 * $cached      - Кеширование (true)
 * $cacheLength - Длина Кеша (30)
 * $limit       - Лимит возвращаемых/отображаемых данных (10)
 * $file        - файл обработчик 'index.php'
 * $delay       - Задержка в милисекундах перед отправкой запроса, после того как была отпущена клавиша(40)
 * $width       - Ширина компонента (500)
 */

function smarty_function_select_country($params, &$smarty)
  {
  extract($params);

  if (empty($minChars)) $minChars = '0';
  if (empty($autoFill)) $autoFill = 'false';
  if (empty($cached)) $cached = 'true';
  if (empty($limit)) $limit = '300';
  if (empty($cacheLength)) $cacheLength = '30';
  if (empty($delay)) $delay = '400';
  if (empty($file))$file = "index.php?module=geobase&type=ajax&func=get_city";
  if (empty($width)) $width = '500';
  if (empty($scrollHeight)) $scrollHeight = '210';

  $sql = "
            SELECT  co.id, co.`countries_displayname_ru`, co.`countries_displayname_en`
            FROM `sys_geobase_countries` co
            WHERE co.`countries_displayname_ru` LIKE '$value%' OR co.`countries_displayname_en` LIKE '$value%'
           ";
  $res = sysDBQuery($sql);
  
  $country='';
  while($row = mysql_fetch_array($res))
       {
       $country .= "{id: \"$row[id]\", title: \"$row[countries_displayname_ru]\", title_en: \"$row[countries_displayname_en]\"},";
       }
  $arrCountry = '['.rtrim($country,',').'];';

  $text = '';
  if ($value)
    {
    $sql = "
            SELECT  co.id, co.`countries_displayname_ru`, co.`countries_displayname_en`
            FROM `sys_geobase_countries` co
            WHERE co.`countries_displayname_ru` LIKE '$value%' OR co.`countries_displayname_en` LIKE '$value%'
           ";
    $result = sysDBQuery($sql);
    $row_result = mysql_fetch_assoc($result);

    $text .= $row_result['countries_displayname_ru'];
    $visible = 'inline';
    }
  else
    {
    $value = 0;
    $visible = 'none';
    }


  if (empty($bgcolor)) $bgcolor = 'wheat';

  sysJsLoad("geobase", "jsAutocomplate");
  sysCssLoad("geobase", "jsAutocomplate");


  $script = "
           <script language='javascript' >
          var countrys = $arrCountry;
          $(document).ready(function () {
           //============================================================================
            function $name"."_format(city) {
              var result = city.title; + '<br>';

             //=========ENGLISH==================
             result_en = '<br><font size=\"1\" color=\"#595959\" face=\"Arial\">'
             result_en = result_en + city.title_en;
             result_en = result_en + '</font>'
              

              return  result + result_en;
            }

            function $name"."_format_result(city) {
              var result = '';
              if(city.country)
                result = result+city.country;
               if(city.adm1)
                result = result+ ', ' + city.adm1;
              if(city.adm2)
                result = result+', ' + city.adm2;
              return  result+ ', ' +city.title;
            }


            $('#$name"."_text').autocomplete(countrys, {
              width:$width,
              minChars:$minChars,
              autoFill: false,
              max:$limit,
              scrollHeight:$scrollHeight,

              parse: function(data,i, max) {
                $('#$name"."_id').val('0');
                $('#$name"."_temp').val($('#$name"."_text').val());
                if(max != 1 )
                  {
                  $('#$name"."_id').val('0');
                  $('#$name"."_labelOk').html(max);
                  }
                else
                  {
                  $('#$name"."_labelOk').css('display', 'inline');
                  $('#$name"."_id').val(item.id);
                  $('#$name"."_labelOk').html('&radic;');
                  }

                return $.map(data, function(row) {
                  var res = $name"."_format_result(row);
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
                  $('#$name"."_id').val('0');
                  $('#$name"."_labelOk').html('');
                  }
                else
                  {
                  $('#$name"."_labelOk').css('display', 'inline');
                  $('#$name"."_id').val(item.id);
                  $('#$name"."_labelOk').html('&radic;');
                  }
                return $name"."_format(item);
              }
            })

            .result(function(event, item){
              $('#$name"."_id').val(item.id);
              $('#$name"."_temp').val($('#$name"."_text').val());
              $('#$name"."_labelOk').html('&radic;');
              $('#$name"."_labelOk').css('display', 'inline');
            })

            .click(function(e){
                    if($('#$name"."_temp').val() != $('#$name"."_text').val())
                      {
                      $('#$name"."_id').val('0');
                      $('#$name"."_labelOk').css('display', 'none');
                      }
                    });


          //----------
          if ($.browser.mozilla && $.browser.version.substr(0,3)=='1.9') {
                 $('#$name"."_text').bind('input', function() {
                   $('#$name"."_text').click();
                  });
              }
              else {
                  $('#$name"."_text').bind('keyup', function() {
                      $('#$name"."_text').click();
                  });
              }

          });
          </script>
          ";


  //Собераем сам INPUT
  $input_view = "
                  <div style='text-indent: 0;'>
                  <input type='hidden' value='$value' id='$name"."_id' name='$name'>
                  <input type='hidden' value='$text' id='$name"."_temp'>
                  <input value='$text' class='ac_input' id='$name"."_text' type='text' style='width: $width"."px;'>
                  <span id='$name"."_labelOk' style='display: $visible; color: green; font-family:bold; font-size: 20;'>&radic;</span>
                  </div>
                ";


  //Выводим на страницу элемент
  echo $script;
  echo $input_view;

  return; // $result;
  }

?>
