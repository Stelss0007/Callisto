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

//Формируем список
$result='';
for ($i=0; $i<count($date); $i++)
  {
  if(!isset($date[$i]))
    continue;
  
  $item=$date[$i];
  if ((($i+1) < count($date)))
    {
    if ($a_attr)//формируем с дополнительными атрибутами href
      {
      if (($i+1) != count($date)) //Если не последний выводим разделитель
        {
        $result.="<a $a_attr href=\"$item[url]\">{$item['displayname']}</a>$delimiter";
        }
        else
          {//Если последний без разделителя
          $result.="<a $a_attr href=\"$item[url]\">{$item['displayname']}</a>";
          };
      }
      else//формируем без дополнительных атрибутов href
        {
        if (($i+1) != count($date)) //Если не последний выводим разделитель
          {
          $result.="<a href=\"$item[url]\">{$item['displayname']}</a>$delimiter";
          }
          else
            {//Если последний без разделителя
            $result.="<a href=\"$item[url]\">{$item['displayname']}</a>";
            };
        };
    }
    else//выводим просто название
      {
      $result.= isset($item['displayname']) ? $item['displayname'] : '';
      };
  };

return $result;
}

?>