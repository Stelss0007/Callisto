<?php
class IndexController extends Controller
  {
  public $defaultAction = 'blocks_list';
  
  function actionBlocksList()
    {
    $this->redirect('/admin/blocks');
    }
  }

