<?php
class IndexController extends Controller
  {
  public $defaultAction = 'ViewEditor';

  function actionViewEditor()
    {
    //$this->phpTree = $this->projectEditor->php_file_tree(APP_DIRECTORY, "?module=projectEditor&action=listFile&file=[link]");
    $this->phpTree = $this->projectEditor->php_file_tree(APP_DIRECTORY, '/projectEditor/list_file/?file=[link]');
    $this->view();
    }
  function actionListFile()
    {
    $file = $this->getInput('file', '');
    //"data:image/gif;base64,"

    $fileType = mime_content_type(APP_DIRECTORY.$file);
    
    switch($fileType)
      {
      case 'image/gif':
      case 'image/png':
      case 'image/jpg':
      case 'image/jpeg':
      case 'image/ico':
        echo "data:$fileType;base64,".base64_encode(file_get_contents(APP_DIRECTORY.$file));
        break;

      default:
        echo file_get_contents(APP_DIRECTORY.$file);
        break;
      }
    
    }
  function actionSaveFile()
    {
    $fileSrc = $this->getInput('fileSrc');
    if(empty($fileSrc))
      return false;
    
    $file = fopen(APP_DIRECTORY.$fileSrc, "w");
    fwrite($file, $this->getInput('fileSource'));
    fclose($file);
    }
    
  function actionSaveProject()
    {
    $openTabs = $this->getInput('openTabs');
        
    appVarSetCached('projectEditor', 'openTabs', $openTabs);
    }
    
  function actionOpenProject()
    {
    echo json_encode(appVarGetCached('projectEditor', 'openTabs'));
    }
  }
?>
