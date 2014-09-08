<?php
class IndexController extends Controller
  {
  function actionViewEditor()
    {
    //$this->phpTree = $this->projectEditor->php_file_tree(APP_DIRECTORY, "?module=projectEditor&action=listFile&file=[link]");
    $this->phpTree = $this->projectEditor->php_file_tree(APP_DIRECTORY, '/projectEditor/list_file/?file=[link]');
    $this->view();
    }
  function actionListFile()
    {
    $file = $this->getInput('file', '');
    echo file_get_contents(APP_DIRECTORY.$file);
    }
  }
?>
