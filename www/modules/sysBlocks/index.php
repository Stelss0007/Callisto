<?php
class Index extends Controller
  {
  public $defaultAction = 'blocks_list';
  
  function blocks_list()
    {
    $this->getAccess(ACCESS_ADMIN);
    
    $blocks = $this->sysBlocks->block_list();
   
    $this->blocks_list_l = $blocks['blocks_list_l'];
    $this->blocks_list_r = $blocks['blocks_list_r'];
    $this->blocks_list_t = $blocks['blocks_list_t'];
    $this->blocks_list_b = $blocks['blocks_list_b'];
    $this->blocks_list_c = $blocks['blocks_list_c'];
    
    $this->viewPage();
    }
    
  function install($input_position)
    {
    $this->getAccess(ACCESS_ADMIN);
    
    $position[l]='Слева';
    $position[r]='Справа';
    $position[t]='Сверху';
    $position[b]='Снизу';
    $position[c]='Поцентру';

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
    
    $this->blocks_list_all = $block_list_all;
    $this->position = $input_position;
    
    $browsein = array();
    $browsein[] = array ('url'=>'/sysBlocks',
                        'displayname'=>'Блоки');
    $browsein[] = array ('url'=>'/sysBlocks/install',
                        'displayname'=>'Добавление блока "'.$position.'"');
    
    $this->module_browsein = $browsein;
    
    $this->viewPage();
    }
    
  function add($input_position, $block_name)
    {
    $this->getAccess(ACCESS_ADMIN);
    
    $position[l]='Слева';
    $position[r]='Справа';
    $position[t]='Сверху';
    $position[b]='Снизу';
    $position[c]='Поцентру';

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
    
    $weight = $this->sysBlocks->weightMax("block_position = '{$input_position}'");
    $weight++;

    $info['weight'] = $weight;
    $info['block_last_update'] = time();
    $info['block_position'] = $input_position;
    $info['block_pattern'] = '.*';
   
    $this->arrayToModel($this->sysBlocks, $info);
    
    //$this->debugGetModelVars();
    
    $id = $this->sysBlocks->save();
    
    $this->showMessage('Элемент добавлен', '/sysBlocks');
    }
    
  function weight_up($weight,$block_position)
    {
    $this->getAccess(ACCESS_ADMIN);
    $this->sysBlocks->weightUp($weight, "block_position = '$block_position'");
    $this->redirect();
    }
    
  function weight_down($weight,$block_position)
    {
    $this->getAccess(ACCESS_ADMIN);
    $this->sysBlocks->weightDown($weight ,"block_position = '$block_position'");
    $this->redirect();
    }
    
  function active($id)
    {
    $this->getAccess(ACCESS_ADMIN);
    $this->sysBlocks->block_active = '1';
    $this->sysBlocks->save($id);
    $this->redirect();
    }
    
  function deactive($id)
    {
    $this->getAccess(ACCESS_ADMIN);
    $this->sysBlocks->block_active = '0';
    $this->sysBlocks->save($id);
    $this->redirect();
    }
    
  function delete($id, $weight, $block_position)
    {
    $this->getAccess(ACCESS_ADMIN);
    $this->sysBlocks->weightDelete($weight ,"block_position = '$block_position'");
    $this->sysBlocks->delete($id);
    $this->redirect();
    }
    
  function modify($id)
    {
    $this->getAccess(ACCESS_ADMIN);
    
    $position[l]='Слева';
    $position[r]='Справа';
    $position[t]='Сверху';
    $position[b]='Снизу';
    $position[c]='Поцентру';


    $blocks_list = $this->sysBlocks->getById($id);

    foreach($blocks_list[0] as $key=>$value)
      $this->$key = $value;
    
    $this->positions = $position;
    $this->ref = $_SERVER['HTTP_REFERER'];

    //Получим доп настройки блока, передав ему управление
    $block_file='blocks/'.$blocks_list[0]['block_name'].'/block.php';
    if (file_exists ($block_file))
      {
      include_once($block_file);
      $block = new $blocks_list[0]['block_name']($blocks_list[0]);
      $block->block_name = $blocks_list[0]['block_name'];
//      $block_modify_fn = $blocks_list[0]['block_name'].'_modify';
      $block_modify_fn = 'modify';
      if (method_exists($block, $block_modify_fn))
        {
        $block_config_result = $block->$block_modify_fn($blocks_list[0]);
        $this->block_config_result = $block_config_result['block_content'];
        }
      }



    //BrowseIn
    $browsein = array();
    $browsein[] = array ('url'=>'/sysBlocks/',
                        'displayname'=>'Блоки');
    $browsein[] = array ('url'=>'/sysBlocks/',
                        'displayname'=>'Редактирование блока "'.$blocks_list[0]['block_name'].'"');

    $this->module_browsein = $browsein;
    $this->viewPage();
    }
    
  function update()
    {
    $this->getAccess(ACCESS_ADMIN);
    
    $position[l]='Слева';
    $position[r]='Справа';
    $position[t]='Сверху';
    $position[b]='Снизу';
    $position[c]='Поцентру';

    $position = $position["{$this->input_vars['block_position']}"];
    if(empty ($position)) 
      die ('Неизвестная позиция!');
    
    $this->arrayToModel($this->sysBlocks, $this->input_vars);
    $id = $this->sysBlocks->save();

    $blocks_list = $this->sysBlocks->getById($id);

    //Обновим доп настройки блока, передав ему управление
    $block_file='blocks/'.$blocks_list[0]['block_name'].'/block.php';
    
    if (file_exists ($block_file))
      {
      include_once($block_file);
      $block = new $blocks_list[0]['block_name']($blocks_list[0]);
      $block->block_name = $blocks_list[0]['block_name'];
//      $block_modify_fn = $blocks_list[0]['block_name'].'_modify';
      $block_modify_fn = 'update';
      if (method_exists($block, $block_modify_fn))
        {
        $block->input_vars = $this->input_vars;
        $block_config_result = $block->$block_modify_fn($blocks_list[0]);
        }
      }
    /*TODO Доделать пересчет весов если изменилась позиция блока*/
      
    $this->showMessage('Изменеия сохранены',$this->input_vars['ref']);
    }
  }
?>
