<?php

function smarty_modifier_nicesec($bytes)
	{
  $unim = array("���.","���.","���.");
  $c = 0;
  while ($bytes>=60)
    {
    $c++;
    $bytes = $bytes/60;
    }
  //��������� mb
  //if ($c==2) return round($bytes).' '.$unim[$c];
  return number_format($bytes,($c ? 2 : 0),":",",")." ".$unim[$c];
	}

?>
