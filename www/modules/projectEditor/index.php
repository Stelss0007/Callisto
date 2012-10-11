<?php
class Index extends Controller
  {
  function viewEditor()
    {
    $this->phpTree = $this->projectEditor->php_file_tree($_SERVER['DOCUMENT_ROOT'], "?module=projectEditor&action=listFile&file=[link]");
    $this->view();
    }
  function listFile($file)
    {
    echo file_get_contents($file);
    }
  }
?>
