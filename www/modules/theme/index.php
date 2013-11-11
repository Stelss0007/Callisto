<?php
class Index extends Controller
  {
  public $defaultAction = 'theme_list';
  
  function theme_list()
    {
    //print_r('333');
    //appDebug($this->theme->getList());
    $this->viewPage();
    }
    
  function install($input_position)
    {
    $this->getAccess(ACCESS_ADMIN);
    
    //==================Все Темы=============================
    //Взяли список с диска
    $theme_list_all = array();
    $dir_handler = opendir('themes');
    while ($dir = readdir($dir_handler))
      {
      if ((is_dir("themes/$dir")) &&
                    ($dir != '.') &&
                    ($dir != '..') &&
                    ($dir != 'CVS') &&
                    (file_exists ("themes/$dir/info.php")))
        {
        // Found
        $info = array();
        $info['version'] = '0';
        $info['description'] = '';
        include("themes/$dir/info.php");
        $info['name'] = $dir;
        array_push ($theme_list_all, $info);
        }
      }
    closedir($dir_handler);
    
    $this->themes_list_all = $theme_list_all;
        
    $browsein = array();
    $browsein[] = array ('url'=>'/theme',
                        'displayname'=>'Темы');
    $browsein[] = array ('url'=>'/theme/install',
                        'displayname'=>'Установка темы');
    
    $this->module_browsein = $browsein;
    
    $this->viewPage();
    }
    
  function add($theme_name)
    {
    $this->getAccess(ACCESS_ADMIN);
       
    //Взяли список с диска
    if(!file_exists ("themes/$theme_name/info.php")) 
      die ('Тема отсутствует!');

    // Found
    $info = array();
    $info['version'] = '0';
    $info['description'] = '';
    include("themes/$theme_name/info.php");
    $info['theme_name'] = $theme_name;
    $info['theme_description'] = $info['description'];
    $info['theme_version'] = $info['version'];
    
    $info['theme_last_update'] = time();

   
    $this->arrayToModel($this->themes, $info);
     
    $id = $this->theme->save();
    
    $this->showMessage('Элемент добавлен', '/theme');
    }
  }
?>
