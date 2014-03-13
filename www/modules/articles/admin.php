<?php
class AdminController extends Controller
  {
  public $defaultAction = 'article_list';
  
  function articleList()
    {
    $this->viewPage();
    }
    
  function articleManage()
    {
    $this->viewPage();
    }
  }
