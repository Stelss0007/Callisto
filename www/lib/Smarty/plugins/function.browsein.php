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

//��������� ������
$result='';
for ($i=0; $i<count($data); $i++)
  {
  if(!isset($data[$i]))
    continue;
  
  $item=$data[$i];
  if ((($i+1) < count($data)))
    {
    if (isset($a_attr) && $a_attr)//��������� � ��������������� ���������� href
      {
      if (($i+1) != count($data)) //���� �� ��������� ������� �����������
        {
        $result.="<a $a_attr href=\"$item[url]\">{$item['displayname']}</a>$delimiter";
        }
        else
          {//���� ��������� ��� �����������
          $result.="<a $a_attr href=\"$item[url]\">{$item['displayname']}</a>";
          };
      }
      else//��������� ��� �������������� ��������� href
        {
        if (($i+1) != count($data)) //���� �� ��������� ������� �����������
          {
          $result.="<a href=\"$item[url]\">{$item['displayname']}</a>$delimiter";
          }
          else
            {//���� ��������� ��� �����������
            $result.="<a href=\"$item[url]\">{$item['displayname']}</a>";
            };
        };
    }
    else//������� ������ ��������
      {
      $result.= isset($item['displayname']) ? $item['displayname'] : '';
      };
  };
  
return $result;
}

?>