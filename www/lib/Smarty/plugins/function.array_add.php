<?php
//������������� �������� � �������
//name 
//key
//value
function smarty_function_array_append($params, &$smarty)
{
extract($params);

$arraydate = $smarty->getTemplateVars($name);

if (!is_array($arraydate))
  {
  $arraydate=array();
  };

if (isset ($key))
  {
  $arraydate[][$key]=$value;
  }
  else
    {
    $arraydate[]=$value;
    };
//array_push ($arraydate, $var);
$smarty->assign($name, $arraydate);

}
?>