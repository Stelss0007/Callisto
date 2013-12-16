<?php
class Index extends Controller
  {
  public $defaultAction = 'theme_list';
  
  function theme_list()
    {
    $browsein = array();
    $browsein[] = array ('url'=>'/theme',
                        'displayname'=>'����');
    
    $this->module_browsein = $browsein;
    
    $this->assign('themes_list_all', $this->theme->getList());
    $this->viewPage();
    }

  function install($input_position)
    {
    $this->getAccess(ACCESS_ADMIN);
    
    //==================��� ����=============================
    //����� ������ � �����

    
    $this->themes_list_all = $this->theme->fileSystemListActual();
        
    $browsein = array();
    $browsein[] = array ('url'=>'/theme',
                        'displayname'=>'����');
    $browsein[] = array ('url'=>'/theme/install',
                        'displayname'=>'��������� ����');
    
    $this->module_browsein = $browsein;
    
    $this->viewPage();
    }
    
  function add($theme_name)
    {
    $this->getAccess(ACCESS_ADMIN);
       
    //����� ������ � �����
    if(!file_exists ("themes/$theme_name/info.php")) 
      die ('���� �����������!');

    // Found
    $info = array();
    $info['version']      = '0';
    $info['description']  = '';
    
    include("themes/$theme_name/info.php");
    
    $info['theme_name']         = $theme_name;
    $info['theme_title']        = $info['title'];
    $info['theme_author']       = $info['author'];
    $info['theme_description']  = $info['description'];
    $info['theme_version']      = $info['version'];
    $info['theme_last_update']  = time();

   
    $this->arrayToModel($this->theme, $info);
     
    $id = $this->theme->save();
    
    $this->showMessage('������� ��������', '/theme');
    }
  function activate($id)
    {
    $this->getAccess(ACCESS_ADMIN);
    $this->theme->activate($id);
    $this->showMessage($this->t('theme_activated'), '/theme');
    }
    
  function delete($id)
    {
    $this->getAccess(ACCESS_ADMIN);
    $this->theme->delete($id);
    $this->showMessage($this->t('theme_deleted'), '/theme');
    }
  }
?>
