<?php
class IndexController extends Controller
  {
  public $defaultAction = 'blocks_list';
  
  function actionBlocksList()
    {
    $this->getAccess(ACCESS_ADMIN);
  
    $blocks = $this->blocks->block_list();
   
    $this->blocks_list_l = $blocks['blocks_list_l'];
    $this->blocks_list_r = $blocks['blocks_list_r'];
    $this->blocks_list_t = $blocks['blocks_list_t'];
    $this->blocks_list_b = $blocks['blocks_list_b'];
    $this->blocks_list_c = $blocks['blocks_list_c'];
    
    $this->viewPage();
    }
  }

