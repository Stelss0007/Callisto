<?php
class IndexController extends Controller
  {
  public $defaultAction = 'theme_list';
  
  function fileList()
    {
    $this->redirect("/admin/files/file_list");
    }
  }
?>
