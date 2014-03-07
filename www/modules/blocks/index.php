<?php
class IndexController extends Controller
  {
  public $defaultAction = 'blocks_list';
  
  function blocksList()
    {
    $this->getAccess(ACCESS_ADMIN);
  
    $blocks = $this->blocks->block_list();
   
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
    
    $position[l]='�����';
    $position[r]='������';
    $position[t]='������';
    $position[b]='�����';
    $position[c]='��������';

    $position = $position[$input_position];
    if(empty ($position)) 
      $this->showMessage('����������� �������!');
    
    //==================��� ����� � ���������� ������=============================
    //����� ������ � �����
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
    $browsein[] = array ('url'=>'/blocks',
                        'displayname'=>'�����');
    $browsein[] = array ('url'=>'/blocks/install',
                        'displayname'=>'���������� ����� "'.$position.'"');
    
    $this->module_browsein = $browsein;
    
    $this->viewPage();
    }
    
  function add($input_position, $block_name)
    {
    $this->getAccess(ACCESS_ADMIN);
    
    $position[l]='�����';
    $position[r]='������';
    $position[t]='������';
    $position[b]='�����';
    $position[c]='��������';

    $position = $position[$input_position];
    if(empty ($position)) 
      $this->showMessage('����������� �������!');
    
    //����� ������ � �����
    if(!file_exists ("blocks/$block_name/info.php")) 
      die ('����������� ����!');

    // Found
    $info = array();
    $info['version'] = '0';
    $info['description'] = '';
    include("blocks/$block_name/info.php");
    $info['name'] = $block_name;
    
    $weight = $this->blocks->weightMax("block_position = '{$input_position}'");
    $weight++;

    $info['weight'] = $weight;
    $info['block_last_update'] = time();
    $info['block_position'] = $input_position;
    $info['block_pattern'] = '.*';
   
    $this->arrayToModel($this->blocks, $info);
    
    //$this->debugGetModelVars();
    
    $id = $this->blocks->save();
    
    $this->showMessage('������� ��������', '/blocks');
    }
    
  function weightUp($weight,$block_position)
    {
    $this->getAccess(ACCESS_ADMIN);
    $this->blocks->weightUp($weight, "block_position = '$block_position'");
    $this->redirect();
    }
    
  function weightDown($weight,$block_position)
    {
    $this->getAccess(ACCESS_ADMIN);
    $this->blocks->weightDown($weight ,"block_position = '$block_position'");
    $this->redirect();
    }
    
  function active($id)
    {
    $this->getAccess(ACCESS_ADMIN);
    $this->blocks->block_active = '1';
    $this->blocks->save($id);
    $this->redirect();
    }
    
  function deactive($id)
    {
    $this->getAccess(ACCESS_ADMIN);
    $this->blocks->block_active = '0';
    $this->blocks->save($id);
    $this->redirect();
    }
    
  function delete($id, $weight, $block_position)
    {
    $this->getAccess(ACCESS_ADMIN);
    $this->blocks->weightDelete($weight ,"block_position = '$block_position'");
    $this->blocks->delete($id);
    $this->redirect();
    }
    
  function modify($id)
    {
    $this->getAccess(ACCESS_ADMIN);
    
    $position[l]='�����';
    $position[r]='������';
    $position[t]='������';
    $position[b]='�����';
    $position[c]='��������';


    $block = $this->blocks->getById($id);
    
    $this->positions = $position;
    $this->ref = $_SERVER['HTTP_REFERER'];

    //������� ��� ��������� �����, ������� ��� ����������
    $block_file='blocks/'.$block['block_name'].'/block.php';
    if (file_exists ($block_file))
      {
      include_once($block_file);
      $block_obj = new $block['block_name']($block);
      $block_obj->block_name = $block['block_name'];
//      $block_modify_fn = $blocks_list[0]['block_name'].'_modify';
      $block_modify_fn = 'modify';
      if (method_exists($block_obj, $block_modify_fn))
        {
        $block_config_result = $block_obj->$block_modify_fn($block);
        $this->block_config_result = $block_config_result['block_content'];
        }
      }

    $this->assign($block);

    //BrowseIn
    $browsein = array();
    $browsein[] = array ('url'=>'/blocks/',
                        'displayname'=>'�����');
    $browsein[] = array ('url'=>'/blocks/',
                        'displayname'=>'�������������� ����� "'.$block['block_name'].'"');

    $this->module_browsein = $browsein;
    $this->viewPage();
    }
    
  function update()
    {
    $this->getAccess(ACCESS_ADMIN);
    
    $position[l]='�����';
    $position[r]='������';
    $position[t]='������';
    $position[b]='�����';
    $position[c]='��������';

    $position = $position["{$this->input_vars['block_position']}"];
    if(empty ($position)) 
      die ('����������� �������!');
    
    $this->arrayToModel($this->blocks, $this->input_vars);
    $id = $this->blocks->save();

    $block = $this->blocks->getById($id);

    //������� ��� ��������� �����, ������� ��� ����������
    $block_file='blocks/'.$block['block_name'].'/block.php';
    
    if (file_exists ($block_file))
      {
      include_once($block_file);
      $block_obj = new $block['block_name']($block);
      $block_obj->block_name = $block['block_name'];
//      $block_modify_fn = $blocks_list[0]['block_name'].'_modify';
      $block_modify_fn = 'update';
      if (method_exists($block_obj, $block_modify_fn))
        {
        $block_obj->input_vars = $this->input_vars;
        $block_config_result = $block_obj->$block_modify_fn($block);
        }
      }
    /*TODO �������� �������� ����� ���� ���������� ������� �����*/
      
    $this->showMessage('�������� ���������',$this->input_vars['ref']);
    }
  }
?>
