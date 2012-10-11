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
 * <a href="">������������ �����</a>&nbsp;<span style="font-weight:bold;">&raquo;&raquo;</span>&nbsp;�������� ���������
 */
function smarty_function_browsein($params, &$smarty)
{
extract ($params);
if (!isset ($delimiter))
  {
  $delimiter = "&nbsp;<span style=\"font-weight:bold;\">&raquo;</span>&nbsp;";
  };

if (isset($show_last) && !$show_last)
  {//���� show_last = false �� ���������� ��������� �������
  array_pop ($date);
  };

if ($lastname_only)
  {//���� ������ ���������
  $last_item = array_pop ($date);
  $result = $last_item[displayname];
  return ($result);
  };

//��������� ������
$result='';
for ($i=0; $i<count($date); $i++)
  {
  $item=$date[$i];
  if ((($i+1) < count($date)) || $href_last)
    {
    if ($a_attr)//��������� � ��������������� ���������� href
      {
      if (($i+1) != count($date)) //���� �� ��������� ������� �����������
        {
        $result.="<a $a_attr href=\"$item[url]\">$item[displayname]</a>$delimiter";
        }
        else
          {//���� ��������� ��� �����������
          $result.="<a $a_attr href=\"$item[url]\">$item[displayname]</a>";
          };
      }
      else//��������� ��� �������������� ��������� href
        {
        if (($i+1) != count($date)) //���� �� ��������� ������� �����������
          {
          $result.="<a href=\"$item[url]\">$item[displayname]</a>$delimiter";
          }
          else
            {//���� ��������� ��� �����������
            $result.="<a href=\"$item[url]\">$item[displayname]</a>";
            };
        };
    }
    else//������� ������ ��������
      {
      $result.=$item[displayname];
      };
  };

return $result;
}

?>