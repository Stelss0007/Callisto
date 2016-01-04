<?php

class AdminController extends Controller
  {
  public function actionIndex() 
    {
    $browsein = array();
    $browsein[] = array ('url'=>'/admin/main',
                        'displayname'=>'Главное меню');
    $browsein[] = array ('url'=>'/admin/modules',
                        'displayname'=>'Модули');
 
    
    $this->module_browsein = $browsein;
    
    
    $instaledModules = $this->modules->getList();
    
    $module_list_all = array();
    $dir_handler = opendir('modules');
    while ($dir = readdir($dir_handler))
      {
      if ((is_dir("modules/$dir")) &&
                    ($dir != '.') &&
                    ($dir != '..') &&
                    ($dir != 'CVS') &&
                    (file_exists ("modules/$dir/info.php")))
        {
        // Found
        $info = array();
        $info['version'] = '0';
        $info['description'] = '';
        include("modules/$dir/info.php");
        $info['name'] = $dir;
        array_push ($module_list_all, $info);
        }
      }
    closedir($dir_handler);
    
    $this->modules_list_all = $module_list_all;
    
    $this->viewPage();  
    }
    
    function actionInfo($module_name, $position)
        {
        if(!file_exists ("modules/$module_name/info.php"))
          {
          $this->showMessage('Module '.$module_name.' not found or info.php are missing', $this->inputVars['ref']);
          }


        include_once "modules/$module_name/info.php";
        $this->assign('module_info', $info);

        $browsein = array();
        $browsein[] = array ('url'=>'/admin/main',
                            'displayname'=>'Dasboard');
        $browsein[] = array ('url'=>'/admin/modules/',
                            'displayname'=>'Модули');
        $browsein[] = array ('url'=>'/admin/modules/',
                            'displayname'=>'Информация о модуле "'.$info['module_displayname'].'"');

        $this->module_browsein = $browsein;

        $this->viewPage();
        }
        
        
    function actionInstall($moduleName)
        {
        if(!file_exists ("modules/$moduleName/install.php"))
          {
          $this->showMessage('Module '.$moduleName.' not found or install.php are missing', $this->inputVars['ref']);
          }
        include_once "modules/$moduleName/install.php";
        
        $moduleInstall = new \Install();
        $moduleInstall->up();
        
        }
    function actionCreate()
        {
        $this->viewPage();
        }
  }