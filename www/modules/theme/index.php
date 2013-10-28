<?php
class Index extends Controller
  {
  public $defaultAction = 'theme_list';
  
  function theme_list()
    {
    //print_r('333');
    $this->viewPage();
    }
  }
?>
