<?php
class IndexController extends Controller
  {
  function actionViewEditor()
    {
    //$this->phpTree = $this->projectEditor->php_file_tree(APP_DIRECTORY, "?module=projectEditor&action=listFile&file=[link]");
    $this->phpTree = $this->projectEditor->php_file_tree(APP_DIRECTORY, '/projectEditor/list_file');
    $this->view();
    }
  function actionListFile($file)
    {
    echo 'rus';
    echo file_get_contents($file);
    }
  }
?>
