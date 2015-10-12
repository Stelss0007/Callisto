<?php
use app\modules\theme\models\Theme; 

class AdminController extends Controller
  {
  public $defaultAction = 'theme_list';
  
  function actionThemeList()
    {
    $this->getAccess(ACCESS_ADMIN);
    
    $browsein = [];
    $browsein[] = ['url'=>'/admin/theme', 'displayname'=>'Темы'];
    
    $this->assign('module_browsein',$browsein);
    $this->assign('themes_list_all', Theme::findAll());
  
    $this->viewPage();
    }

  function actionInstall($input_position)
    {
    $this->getAccess(ACCESS_ADMIN);
    
    //==================Все Темы=============================
    //Взяли список с диска
    $this->assign(themes_list_all, Theme::fileSystemListActual());
        
    $browsein = [
                    ['url'=>'/admin/theme', 'displayname'=>'Темы'],
                    ['url'=>'/admin/theme/install', 'displayname'=>'Установка темы']
                ];
    
    $this->assign('module_browsein', $browsein);
    
    $this->viewPage();
    }
    
  function actionAdd($theme_name)
    {
    $this->getAccess(ACCESS_ADMIN);
       
    //Взяли список с диска
    if(!file_exists ("themes/$theme_name/info.php")) 
      die ('Тема отсутствует!');

    // Found
    $info = [];
    $info['version']      = '0';
    $info['description']  = '';
    
    include("themes/$theme_name/info.php");
    
    $info['theme_name']         = $theme_name;
    $info['theme_title']        = $info['title'];
    $info['theme_author']       = $info['author'];
    $info['theme_description']  = $info['description'];
    $info['theme_version']      = $info['version'];
    $info['theme_last_update']  = time();

    $theme = new Theme();
    $theme->setAttributesByArray($info);
    $theme->save();
    
    $this->showMessage('Элемент добавлен', '/admin/theme');
    }
    
  function actionActivate($id)
    {
    $this->getAccess(ACCESS_ADMIN);
    
    Theme::activate($id);
    
    $this->showMessage($this->t('theme_activated'), '/admin/theme');
    }
    
  function actionDelete($id)
    {
    $this->getAccess(ACCESS_ADMIN);
    
    $theme = Theme::find($id);
    $theme->delete();
    
    $this->showMessage($this->t('theme_deleted'), '/admin/theme');
    }

  }
