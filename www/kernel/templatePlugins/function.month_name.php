<?php

/*
 * Smarty plugin
 * $number - ����� ������
 * $type - ��� (������������� ��� ������������)
 */

function smarty_function_month_name($params, &$smarty)
	{
	extract($params);
	
  if (empty($type))
		$type = 0;


  //-- ���������� ������ ��� ������� --
    $month = array();
    $month[1][0]="������";
    $month[1][1]="������";

    $month[2][0]="�������";
    $month[2][1]="�������";

    $month[3][0]="�����";
    $month[3][1]="����";

    $month[4][0]="������";
    $month[4][1]="������";

    $month[5][0]="���";
    $month[5][1]="���";

    $month[6][0]="����";
    $month[6][1]="����";

    $month[7][0]="����";
    $month[7][1]="����";

    $month[8][0]="�������";
    $month[8][1]="������";

    $month[9][0]="��������";
    $month[9][1]="��������";

    $month[10][0]="�������";
    $month[10][1]="�������";

    $month[11][0]="������";
    $month[11][1]="������";

    $month[12][0]="�������";
    $month[12][0]="�������";

    echo $month[$number][$type];

	}

?>