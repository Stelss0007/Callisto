<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class Test2 extends Model
  {
  function getName($a='')
    {
    return " Ruslan 2 {$a}";
    }
  function sum($a = 1, $b = 2)
    {
    return $a + $b;
    }
  }
?>
