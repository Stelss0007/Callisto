<?php
class AdminController extends Controller
  {
  public $defaultAction = 'article_list';
  
  function articleList()
    {
    echo '222';
    }
    
  function articleManage()
    {
    $this->viewPage();
    }
  }
