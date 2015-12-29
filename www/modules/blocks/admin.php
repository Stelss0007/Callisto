<?php
use app\modules\blocks\models\Blocks;

class AdminController extends Controller
  {
  public $defaultAction = 'blocks_list';
  
  function actionBlocksList()
    {
    $this->getAccess(ACCESS_ADMIN);
  
    $blocks = Blocks::blockList();
   
    $this->blocks_list_l = $blocks['blocks_list_l'];
    $this->blocks_list_r = $blocks['blocks_list_r'];
    $this->blocks_list_t = $blocks['blocks_list_t'];
    $this->blocks_list_b = $blocks['blocks_list_b'];
    $this->blocks_list_c = $blocks['blocks_list_c'];
    
    $browsein = [];
    $browsein[] = ['url'=>'/admin/main', 'displayname'=>'Dasboard'];
    $browsein[] = ['url'=>'/admin/blocks', 'displayname'=>'Блоки'];
       
    $this->assign('module_browsein', $browsein);
    
    $this->viewPage();
    }
    
  function actionInstall($input_position)
    {
    $this->getAccess(ACCESS_ADMIN);
    
    $position['l']='Слева';
    $position['r']='Справа';
    $position['t']='Сверху';
    $position['b']='Снизу';
    $position['c']='Поцентру';

    $position = $position[$input_position];
    if(empty ($position)) 
      $this->showMessage('Неизвестная позиция!');
    
    //==================Все блоки в директории блоков=============================
    //Взяли список с диска
    $block_list_all = array();
    $dir_handler = opendir('blocks');
    while ($dir = readdir($dir_handler))
      {
      if ((is_dir("blocks/$dir")) &&
                    ($dir != '.') &&
                    ($dir != '..') &&
                    ($dir != 'CVS') &&
                    (file_exists ("blocks/$dir/info.php")))
        {
        // Found
        $info = array();
        $info['version'] = '0';
        $info['description'] = '';
        include("blocks/$dir/info.php");
        $info['name'] = $dir;
        array_push ($block_list_all, $info);
        }
      }
    closedir($dir_handler);
    
    $this->assign('blocks_list_all', $block_list_all);
    $this->assign('position', $input_position);
    
    $browsein = [];
    $browsein[] = ['url'=>'/admin/main', 'displayname'=>'Dasboard'];
    $browsein[] = ['url'=>'/admin/blocks', 'displayname'=>'Блоки'];
    $browsein[] = ['url'=>'/admin/blocks/install', 'displayname'=>'Добавление блока "'.$position.'"'];
    
    $this->assign('module_browsein', $browsein);
    
    $this->viewPage();
    }
    
  function actionAdd($input_position, $block_name)
    {
    $this->getAccess(ACCESS_ADMIN);
    
    $position['l']='Слева';
    $position['r']='Справа';
    $position['t']='Сверху';
    $position['b']='Снизу';
    $position['c']='Поцентру';

    $position = $position[$input_position];
    if(empty ($position)) 
      $this->showMessage('Неизвестная позиция!');
    
    //Взяли список с диска
    if(!file_exists ("blocks/$block_name/info.php")) 
      die ('Отсутствует блок!');

    // Found
    $info = array();
    $info['version'] = '0';
    $info['description'] = '';
    include("blocks/$block_name/info.php");
    $info['name'] = $block_name;
    
    $weight = Blocks::weightMax(['position'=>$input_position]);
    $weight++;

    $info['weight'] = $weight;
    $info['last_update'] = time();
    $info['position'] = $input_position;
    $info['pattern'] = '.*';
   
    $block = new Blocks($info);
    $block->save();
    
    $this->showMessage('Элемент добавлен', '/admin/blocks');
    }
    
  function actionWeightUp($id)
    {
    $this->getAccess(ACCESS_ADMIN);
    
    $block = Blocks::find($id);
    $block->weightUp(['position'=>$block->position]);
    
    $this->redirect();
    }
    
  function actionWeightDown($id)
    {
    $this->getAccess(ACCESS_ADMIN);
    
    $block = Blocks::find($id);
    $block->weightDown(['position'=>$block->position]);
    
    $this->redirect();
    }
    
  function actionWeightSet($id, $weightOld, $weightNew, $blockPosition)
    {
    $this->getAccess(ACCESS_ADMIN);
    
    $block = Blocks::find($id);
    
    if($block->position != $blockPosition) {
        $block->weightDelete(['position' => $block->position]);
        $block->position = $blockPosition;
        $block->save();
    }
    
    $block->weightSet($weightNew, ['position' => $block->position]);

    echo $this->t('sys_saved');
    //$this->redirect();
    }
    
  function actionActive($id)
    {
    $this->getAccess(ACCESS_ADMIN);
    
    Blocks::activate($id);

    $this->redirect();
    }
    
  function actionDeactive($id)
    {
    $this->getAccess(ACCESS_ADMIN);
    
    Blocks::deactivate($id);
    
    $this->redirect();
    }
    
  function actionDelete($id, $weight, $block_position)
    {
    $this->getAccess(ACCESS_ADMIN);
    
    $block = Blocks::find($id);
    $block->weightDelete(['position' => $block_position]);
    $block->delete();

    $this->redirect();
    }
    
  function actionModify($id)
    {
    $this->getAccess(ACCESS_ADMIN);
    
    $position['l']='Слева';
    $position['r']='Справа';
    $position['t']='Сверху';
    $position['b']='Снизу';
    $position['c']='Поцентру';


    $block = Blocks::find($id);
    
    $this->assign('positions', $position);
    $this->assign('ref', $_SERVER['HTTP_REFERER']);

    //Получим доп настройки блока, передав ему управление
    $block_file='blocks/'.$block->name.'/block.php';
    if (file_exists ($block_file))
      {
      include_once($block_file);
      $block_obj = new $block->name($block);
      $block_obj->name = $block->name;
//      $block_modify_fn = $blocks_list[0]['block_name'].'_modify';
      $block_modify_fn = 'modify';
      
      if (method_exists($block_obj, $block_modify_fn))
        {
        $block_config_result = $block_obj->$block_modify_fn($block);
        $this->assign('block_config_result', $block_config_result['content']);
        }
      }

    $this->assign('block', $block);

    //BrowseIn
    $browsein = [];
    $browsein[] = ['url'=>'/admin/main', 'displayname'=>'Dasboard'];
    $browsein[] = ['url'=>'/admin/blocks/', 'displayname'=>'Блоки'];
    $browsein[] = ['url'=>'/admin/blocks/', 'displayname'=>'Редактирование блока "'.$block->name.'"'];

    $this->assign('module_browsein', $browsein);
    $this->viewPage();
    }
    
  function actionUpdate()
    {
    $this->getAccess(ACCESS_ADMIN);
    
    $position['l']='Слева';
    $position['r']='Справа';
    $position['t']='Сверху';
    $position['b']='Снизу';
    $position['c']='Поцентру';

    $position = $position["{$this->inputVars['position']}"];
    if(empty ($position)) 
      die ('Неизвестная позиция!');

    if(empty($this->inputVars['active']))
      {
      $this->inputVars['active'] = '0';
      }
    $block = Blocks::find($this->inputVars['id']);  
    $block->setAttributesByArray($this->inputVars);
    $block->save();


    //Обновим доп настройки блока, передав ему управление
    $block_file='blocks/'.$block->name.'/block.php';
    
    if (file_exists ($block_file))
      {
      include_once($block_file);
      $block_obj = new $block->name($block);
      $block_obj->name = $block->name;
//      $block_modify_fn = $blocks_list[0]['block_name'].'_modify';
      $block_modify_fn = 'update';
      if (method_exists($block_obj, $block_modify_fn))
        {
        $block_obj->input_vars = $this->inputVars;
        $block_config_result = $block_obj->$block_modify_fn($block);
        }
      }
    /*TODO Доделать пересчет весов если изменилась позиция блока*/
    if($this->inputVars['submit_exit'])  
      {
      $this->showMessage('Изменеия сохранены', $this->inputVars['ref']);
      }
    else
      {
      $this->showMessage('Изменеия сохранены', $this->referer);
      }
    }
    
  function actionInfo($block_name, $position)
    {
    if(!file_exists ("blocks/$block_name/info.php"))
      {
      $this->showMessage('Блок не найден', $this->inputVars['ref']);
      }
      
    $position_['l']='Слева';
    $position_['r']='Справа';
    $position_['t']='Сверху';
    $position_['b']='Снизу';
    $position_['c']='Поцентру';
      
    include_once "blocks/$block_name/info.php";
    $this->assign('block_info', $info);
    
    $browsein = array();
    $browsein[] = array ('url'=>'/admin/main',
                        'displayname'=>'Dasboard');
    $browsein[] = array ('url'=>'/admin/blocks/',
                        'displayname'=>'Блоки');
    $browsein[] = array ('url'=>'/admin/blocks/install/'.$position,
                        'displayname'=>'Добавление блока "'.$position_[$position].'"');
    
    $browsein[] = array ('url'=>'/admin/blocks/',
                        'displayname'=>'Информация о блоке "'.$info['block_displayname'].'"');

    $this->module_browsein = $browsein;
    
    $this->viewPage();
    }
  }

