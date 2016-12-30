<?php
use app\modules\projectEditor\models\ProjectEditor;

class AdminController extends Controller
  {
  public $defaultAction = 'ViewEditor';

  function actionGetFileTree()
    {
    echo ProjectEditor::php_file_tree(APP_DIRECTORY, '/projectEditor/list_file/?file=[link]');
    }
  function actionViewEditor()
    {
    //$this->phpTree = ProjectEditor::php_file_tree(APP_DIRECTORY, "?module=projectEditor&action=listFile&file=[link]");
    $this->phpTree = ProjectEditor::php_file_tree(APP_DIRECTORY, '/projectEditor/list_file/?file=[link]');
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
    
  function actionCreateFolder()
    {
    $inputs = $this->getInput(array('currentFolder','newFolder'));
    if(empty($inputs['currentFolder']) || empty($inputs['newFolder']))
      return;
    
    mkdir(APP_DIRECTORY.$inputs['currentFolder'].'/'.$inputs['newFolder'], 0777, true);
    echo 'OK';
    }
    
  function actionCreateFile()
    {
    $inputs = $this->getInput(array('currentFolder','newFile'));
    if(empty($inputs['currentFolder']) || empty($inputs['newFile']))
      return;
    
    $newFile = fopen(APP_DIRECTORY.$inputs['currentFolder'].'/'.$inputs['newFile'], "w") or die("Unable to open file!");
    //$txt = "";
    //fwrite($newFile, $txt);
    fclose($newFile);
    echo 'OK';
    }
    
  function actionRename()
    {
    $inputs = $this->getInput(array('currentObjectName','newObjectName'));
    if(empty($inputs['currentObjectName']) || empty($inputs['newObjectName']))
      return;
    
    $parrentFolderArray = explode('/', $inputs['currentObjectName']);
    unset($parrentFolderArray[count($parrentFolderArray)-1]);
    
    $inputs['newObjectName'] = implode('/', $parrentFolderArray) . '/' . $inputs['newObjectName'];
    
    if($inputs['currentObjectName'] != $inputs['newObjectName'])
      {
      rename(APP_DIRECTORY.$inputs['currentObjectName'], APP_DIRECTORY.$inputs['newObjectName']);
      }
      
    echo 'OK';
    }
  }

