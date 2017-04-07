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

function smarty_function_select_location($params, &$smarty)
  {
  extract($params);
  sysJSLoad ('kernel','jQuery');
  
  if (empty($minChars)) $minChars = '2';
  if (empty($autoFill)) $autoFill = 'false';
  if (empty($cached)) $cached = 'true';
  if (empty($limit)) $limit = '10';
  if (empty($cacheLength)) $cacheLength = '30';
  if (empty($delay)) $delay = '400';
  
  if (empty($width)) $width = '500';
  if (empty($scrollHeight)) $scrollHeight = '210';
  if (empty($type) || $type!='full') $type = 'short';

  //min variant
  if($type=='short')
    {
    if (empty($file))$file = "index.php?module=geobase&type=ajax&func=get_city";
    $text = '';
    if ($value)
      {
      $sql = "
              SELECT
                    co.id as country_id,
                    co.`countries_displayname_ru`,
                    a1.`adm1_displayname_ru`,
                    a2.`adm2_displayname_ru`,
                    c.`city_displayname_ru`
              FROM `sys_geobase_city` c
              LEFT JOIN `sys_geobase_countries` co ON (co.id = c.`city_country_id`)
              LEFT JOIN `sys_geobase_adm1` a1 ON (a1.id = c.`city_adm1_id`)
              LEFT JOIN `sys_geobase_adm2` a2 ON (a2.`id` = c.`city_adm2_id`)
              WHERE c.id = '$value'
             ";
      $result = sysDBQuery($sql);
      $row_result = mysql_fetch_assoc($result);

      $text .= $row_result['countries_displayname_ru'];

      if ($row_result['adm1_displayname_ru']) $text .= ', '.$row_result['adm1_displayname_ru'];

      if ($row_result['adm2_displayname_ru']) $text .= ', '.$row_result['adm2_displayname_ru'];

      $text .= ', '.$row_result['city_displayname_ru'];

      $visible = 'inline';
      }
    else
      {
      $value = 0;
      $visible = 'none';
      }

    if (empty($bgcolor)) $bgcolor = 'wheat';

    sysJsLoad("kernel", "jQuery");
    sysJsLoad("geobase", "jsAutocomplate");

    sysCssLoad("geobase", "jsAutocomplate");


    $script = "
             <script language='javascript' >
            $(document).ready(function () {
             //============================================================================
              function $name"."_format(city) {
                var result = city.title + '<br>';
                if(city.country)
                  result = result+city.country;
                 if(city.adm1)
                  result = result+ ', ' + city.adm1;
                if(city.adm2)
                  result = result+', ' + city.adm2;

               //=========ENGLISH==================
               result_en = '<br><font size=\"1\" color=\"#595959\" face=\"Arial\">'

               result_en = result_en + city.title_en;
               if(city.adm2_en)
                  result_en = result_en + ', ' + city.adm2_en;
               if(city.adm1_en)
                  result_en = result_en + ', ' + city.adm1_en;
               if(city.country_en)
                  result_en = result_en + ', ' + city.country_en;

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

              $('#$name"."_text').blur(function(e){
               if($('#$name"."_id').val()==0)
               {
               $('#$name"."_labelOk').css('display', 'inline');
               $('#$name"."_labelOk').css('color', 'red');
               $('#$name"."_labelOk').html('X');
               }
              });

              $('#$name"."_text').autocomplete_geo('$file&term='+$('#$name"."_text').val(), {
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
                    $('#$name"."_labelOk').css('color', 'green');
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
                    $('#$name"."_labelOk').css('color', 'green');
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
                $('#$name"."_labelOk').css('color', 'green');
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
 //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
 //variant with country
  else
    {

    if (empty($file))$file = "index.php?module=geobase&type=ajax&func=get_city_bycountry";
    $text = '';
    if ($value)
      {
      $sql = "
              SELECT co.`id` as country_id,
                    co.`countries_displayname_ru`,
                    a1.`adm1_displayname_ru`,
                    a2.`adm2_displayname_ru`,
                    c.`city_displayname_ru`
              FROM `sys_geobase_city` c
              LEFT JOIN `sys_geobase_countries` co ON (co.id = c.`city_country_id`)
              LEFT JOIN `sys_geobase_adm1` a1 ON (a1.id = c.`city_adm1_id`)
              LEFT JOIN `sys_geobase_adm2` a2 ON (a2.`id` = c.`city_adm2_id`)
              WHERE c.id = '$value'
             ";
      $result = sysDBQuery($sql);
      $row_result = mysql_fetch_assoc($result);

      $text .= $row_result['countries_displayname_ru'];

      if ($row_result['adm1_displayname_ru']) $text .= ', '.$row_result['adm1_displayname_ru'];

      if ($row_result['adm2_displayname_ru']) $text .= ', '.$row_result['adm2_displayname_ru'];

      $text .= ', '.$row_result['city_displayname_ru'];

      $visible = 'inline';
      }
    else
      {
      $value = 0;
      $visible = 'none';
      }


    //Построим список стран
    $sql = "
            SELECT  co.id, co.`countries_displayname_ru`, co.`countries_displayname_en`
            FROM `sys_geobase_countries` co
            ORDER BY co.`countries_displayname_ru`
           ";
    $res = sysDBQuery($sql);

    $country='';
    $countryItem="<option value='0'>Выберите страну</option>";
    while($row = mysql_fetch_array($res))
         {
         $country .= "{id: \"$row[id]\", title: \"$row[countries_displayname_ru]\", title_en: \"$row[countries_displayname_en]\"},";

         if($row['id']==$row_result['country_id'])
           {
           $countryItem .= "<option  selected value='$row[id]'>$row[countries_displayname_ru]</option>";
           }
         else
           {
           $countryItem .= "<option value='$row[id]'>$row[countries_displayname_ru]</option>";
           }
         }
    $arrCountry = '['.rtrim($country,',').'];';
    //Конец построили список стран

    if (empty($bgcolor)) $bgcolor = 'wheat';

    sysJsLoad("geobase", "jsAutocomplate");
    sysCssLoad("geobase", "jsAutocomplate");


    $script = "
             <script language='javascript' >
            $(document).ready(function () {
             //============================================================================
              function $name"."_format(city) {
                var result = city.title + '<br>';
                if(city.country)
                  result = result+city.country;
                 if(city.adm1)
                  result = result+ ', ' + city.adm1;
                if(city.adm2)
                  result = result+', ' + city.adm2;

               //=========ENGLISH==================
               result_en = '<br><font size=\"1\" color=\"#595959\" face=\"Arial\">'

               result_en = result_en + city.title_en;
               if(city.adm2_en)
                  result_en = result_en + ', ' + city.adm2_en;
               if(city.adm1_en)
                  result_en = result_en + ', ' + city.adm1_en;
               if(city.country_en)
                  result_en = result_en + ', ' + city.country_en;

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

              $('#$name"."_text').autocomplete('$file&term='+$('#$name"."_text').val(), {
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
                country:'$name"."_country',

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
                    <span>Страна: </span>
                    <select style='width: $width"."px;' id='$name"."_country'>
                      $countryItem
                    </select>
                    <br>
                    <span>Город:  &nbsp;</span>
                    
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
  }

?>
