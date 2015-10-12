<?php

/*
 * Smarty plugin
 * $number - номер мес€ца
 * $type - тип (множественный или единственный)
 */

function smarty_function_month_name($params, &$smarty)
	{
	extract($params);
	
  if (empty($type))
		$type = 0;


  //-- определ€ем массив дл€ мес€цев --
    $month = array();
    $month[1][0]="€нвар€";
    $month[1][1]="€нварь";

    $month[2][0]="феврал€";
    $month[2][1]="феврал€";

    $month[3][0]="марта";
    $month[3][1]="март";

    $month[4][0]="апрел€";
    $month[4][1]="апрель";

    $month[5][0]="ма€";
    $month[5][1]="май";

    $month[6][0]="июн€";
    $month[6][1]="июнь";

    $month[7][0]="июл€";
    $month[7][1]="июль";

    $month[8][0]="августа";
    $month[8][1]="август";

    $month[9][0]="сент€бр€";
    $month[9][1]="сент€брь";

    $month[10][0]="окт€бр€";
    $month[10][1]="окт€брь";

    $month[11][0]="но€бр€";
    $month[11][1]="но€брь";

    $month[12][0]="декабр€";
    $month[12][0]="декабрь";

    echo $month[$number][$type];

	}

?>