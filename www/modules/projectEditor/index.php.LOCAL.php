<?php
class IndexController extends Controller
  {
  public $defaultAction = 'ViewEditor';
  function actionViewEditor()
    {
    $this->phpTree = $this->projectEditor->php_file_tree(APP_DIRECTORY, "?module=projectEditor&action=listFile&file=[link]");
    $this->view();
    }
  function actionListFile($file)
    {
    echo file_get_contents($file);
    }
  }
?>