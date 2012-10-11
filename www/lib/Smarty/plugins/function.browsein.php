<?php
/*
 * Smarty plugin
 * $date
 * $delimiter
 * $a_attr
 * $show_last
 * $href_last
 * $lastname_only
 * -------------------------------------------------------------
 * <a href="">Конфигурация сайта</a>&nbsp;<span style="font-weight:bold;">&raquo;&raquo;</span>&nbsp;Основные настройки
 */
function smarty_function_browsein($params, &$smarty)
{
extract ($params);
if (!isset ($delimiter))
  {
  $delimiter = "&nbsp;<span style=\"font-weight:bold;\">&raquo;</span>&nbsp;";
  };

if (isset($show_last) && !$show_last)
  {//Если show_last = false не показываем последний элимент
  array_pop ($date);
  };

if ($lastname_only)
  {//Если только последний
  $last_item = array_pop ($date);
  $result = $last_item[displayname];
  return ($result);
  };

//Формируем список
$result='';
for ($i=0; $i<count($date); $i++)
  {
  $item=$date[$i];
  if ((($i+1) < count($date)) || $href_last)
    {
    if ($a_attr)//формируем с дополнительными атрибутами href
      {
      if (($i+1) != count($date)) //Если не последний выводим разделитель
        {
        $result.="<a $a_attr href=\"$item[url]\">$item[displayname]</a>$delimiter";
        }
        else
          {//Если последний без разделителя
          $result.="<a $a_attr href=\"$item[url]\">$item[displayname]</a>";
          };
      }
      else//формируем без дополнительных атрибутов href
        {
        if (($i+1) != count($date)) //Если не последний выводим разделитель
          {
          $result.="<a href=\"$item[url]\">$item[displayname]</a>$delimiter";
          }
          else
            {//Если последний без разделителя
            $result.="<a href=\"$item[url]\">$item[displayname]</a>";
            };
        };
    }
    else//выводим просто название
      {
      $result.=$item[displayname];
      };
  };

return $result;
}

?>