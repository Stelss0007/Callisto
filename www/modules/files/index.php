<?php
class IndexController extends Controller
  {
  public $defaultAction = 'theme_list';
  
  function actionFileList()
    {
    $this->redirect("/admin/files/file_list");
    }
  }

