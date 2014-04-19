<?php

class AdminController extends Controller
  {
  public $defaultAction = 'category_list';
  
  function actionCategoryList()
    {
    $this->viewPage();
    }
  
  }