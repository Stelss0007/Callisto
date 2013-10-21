<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of block
 *
 * @author Your Name <your.name at your.org>
 */
class Block
  {
  
  public $vars = array();
  public $smarty = null;
  public $block_id;
  public $block_name;
  public $block_displayname;
  public $block_pattern;
  public $block_content;
  public $block_position;
  public $block_active;
  public $block_refresh;
  public $block_last_update;
  public $block_lang;
  public $block_css_class;
  public $module_object;
  public $input_vars;
  
  public $block_object;
  public $root_dir;
  public $theme;
  
  public $session;
  public $lib;
  public $libs = array();
  protected $modname;
  
  private $lang;
  private $lang_default = 'rus';

  function __construct($block_info) 
    {
    global $coreConfig;
    $this->root_dir = $_SERVER['DOCUMENT_ROOT'].'/';
    foreach($block_info as $key=>$value)
      {
      $this->$key = $value;
      if($key == 'block_content')
        {
        if(!empty($value))
          {
          $this->$key = unserialize(stripslashes($value));
          $block_content = unserialize(stripslashes($value));
          foreach($block_content as $block_key => $block_value)
            {
            $this->$block_key = $block_value;
            }
          }
        }
      }
    $this->block_object = $this->block_name.'|display|'.$this->block_id;
    require_once(SMARTY_DIR.'Smarty.class.php');
    $this->smarty = new viewTpl();
    $this->smarty->assign($block_info);
    
    //Установим язык
    $this->setLang($coreConfig['lang']);
    }
    /************************** Блоки  *******************************/
  //Соберем все блоки и приготовим к отображению по своим местам

  public static function blockShowAll(&$myTpl, &$object, $theme)
    {
    $db=DBConnector::getInstance();
    $ses_info=UserSession::getInstance();
    $db->query("SELECT * FROM block WHERE block_active = '1' ORDER BY block_position, block_weight");
    $db_block_list = $db->fetch_array();
  //  echo 'Результат значений:<br><pre>';
  //  print_r($object);
  //  echo '</pre>';
  //  exit;

    $result_blocks = array ();
    $result_blocks['left']=array ();
    $result_blocks['right']=array ();
    $result_blocks['top']=array ();
    $result_blocks['bottom']=array ();
    $result_blocks['center']=array ();

    foreach($db_block_list as $item)
      {
      //Проверим подходит ли этот блок данному объекту
      $pattern='/'.$item['block_pattern'].'/iU';
      if (!preg_match ($pattern, $object)) continue;

      //В информацию о блоке добавляем - module_object
      $item['module_object'] = $object;
      $item['theme'] = $theme;

      //Выполним код блока и вернем результат
      $block_content = self::blockRun($item);

      //В зависимости от положения
      switch ($item['block_position'])
        {
        case 'l'://Левые блоки
          array_push ($result_blocks['left'], $block_content);
          break;
        case 'r':
          array_push ($result_blocks['right'], $block_content);
          break;
        case 't':
          array_push ($result_blocks['top'], $block_content);
          break;
        case 'b':
          array_push ($result_blocks['bottom'], $block_content);
          break;
        case 'c':
          array_push ($result_blocks['center'], $block_content);
          break;
        }
      }

    //Загоняем в шаблон
    $myTpl->assign('blocks', $result_blocks);
    return true;
    }

  public static function blockRun($block)
    {
    $result = array ();
    $$block[block_name] = null;
    //Подключим файл блока, если он есть, если нет вернем ошибку
    $fname = "blocks/$block[block_name]/block.php";
    
    if (file_exists($fname))
      {
      include_once ($fname);
      
      $$block[block_name] = new $block[block_name]($block);
      $$block[block_name]->loadBlockLang($block[block_name]);
      }
    else
      {
      $result['block_displayname'] = 'Блок не найден';
      $result['block_content'] = 'Блок не найден';
      return $result;
      }
    //Ищем функцию отображения результатов работы блока
    $blockfunc = "display";

    if (method_exists($$block[block_name], $blockfunc))
      {
      
      $result = $$block[block_name]->$blockfunc($block);

      if (!empty ($result['block_content']))
        {
        $result['id'] = $blockinfo['id'];
        $result = array_merge ($block, $result);
        }
        
      return $result;
      }
    else
      {
      $result['block_displayname'] = 'Блок не найден';
      $result['block_content'] = 'Блок не найден';
      return $result;
      }

    }
  function __set($name, $value)
    {
    if(property_exists($this, $name))
      {
      $this->$name = $value;
      return true;
      }
    else
      {
      $this->$name = $value;
      }
    $this->vars[$name] = $value;
    return true;
    }  
    
  final public function allVarToTpl()
    {
    foreach ($this->vars as $name => $value)
      {
      $this->smarty->assign($name, $value, false);
      }
    }
    
    
    
    
    
  final public function tplFileName($method, $debug=false)
    {
    $view_file_name = $method;
    if(file_exists($this->root_dir.'themes/'.$this->theme.'/blocks/'.$this->block_name.'/'.$method.'.tpl'))
      {
      //$this->tpls[] = '(Overridden by Theme) '.'themes/'.$this->theme.'/'.$this->module_dir.$view_file_name.'.tpl';
      return $this->root_dir.'themes/'.$this->theme.'/blocks/'.$this->block_name.'/'.$method.'.tpl';
      }
    elseif(file_exists($this->root_dir.'blocks/'.$this->block_name.'/themes/default/'.$method.'.tpl'))
      {
      //$this->tpls[] = '(Original Module TPL) '.$this->module_dir.'themes/default/'.$view_file_name.'.tpl';
      return $this->root_dir.'blocks/'.$this->block_name.'/themes/default/'.$method.'.tpl';
      }
    elseif(!empty($debug))
      {
      //$this->tpls[] = '(TPL file is not exist!) '.$this->module_dir.'themes/default/'.$view_file_name.'.tpl';
      return 'TPL file is not exist! '.$this->root_dir.'blocks/'.$this->block_name.'/themes/default/'.$method.'.tpl <br> You most created tpl file <b>"'.$method.'.tpl"</b> for block <b>'.$this->block_name.'</b><br>';
      }
    else
      {
      //$this->tpls[] = '(TPL file is not exist!) '.$this->module_dir.'themes/default/'.$view_file_name.'.tpl';
      echo 'TPL file is not exist! '.$this->root_dir.'blocks/'.$this->block_name.'/themes/default/'.$method.'.tpl <br> You most created tpl file <b>"'.$method.'.tpl"</b> for block <b>'.$this->block_name.'</b><br>';
      echo "Values for TPL:<br>";
      echo "<pre>";
      print_r($this->vars);
      echo "</pre>";
      die();
      }
    }
    
  final public function GetCallingMethodName($position = null, $with_args = false)
    {
    $e = new Exception();
    $trace = $e->getTrace();
    
    $position = ($position) ? $position : (sizeof($trace)-1);
    if(empty($with_args))
      return $trace[$position]['function'];
    
    return array('function'=>$trace[$position]['function'], 'args' => $trace[$position]['args']);
    print_r($trace);
    }
    
  final public function view()
    {
    $method = $this->GetCallingMethodName(2); 
    $tpl_dir = $this->tplFileName($method);
    $this->allVarToTpl();
    $ObjectName = $this->block_object = $this->block_name.'|'.$method.'|'.$this->block_id;
    $result['block_content'] = $this->smarty->fetch($tpl_dir, $ObjectName);
    return $result;
    }
    
  final public function save($id)
    {
//    print_r($this->vars);
//    echo serialize($this->vars);exit;
    $this->usesModel('blocks');
    $this->blocks->block_content = serialize($this->vars);
    $this->blocks->save($id);
    }
    
  //////////////////////////////////////////////////////////////////////////////
  ////////////////////////////   MODELS     ////////////////////////////////////
  //////////////////////////////////////////////////////////////////////////////
  final public function usesModel($modulename=null)
    {
    //echo $this->modname;exit;
    $modelname = (!empty($modulename)) ? $modulename : $this->modname; 
    $modulename = (!empty($modulename)) ? $modulename : $this->modname; 
    require_once 'modules/'.$modulename.'/class.php';
    $className = $modulename;
    //$this->$modelname = & new $className($className);
    $this->$modelname = & new $className($className);
    $this->$modelname->type = $modulename;
    
    $this->$modelname->session = & $this->session;
    
    //echo $modelname;
    //print_r(get_class_methods($this->$modelname));
    $this->models[] = $modulename.' (modules/'.$modulename.'/class.php)';
    return $this->$modelname;
    }
  
  final public function arrayToModel(&$model, $array)
    {
    if(empty($array))
      return false;
    foreach($array as $key=>$value)
      {
      $model->$key = $value;
      }
    }

  //////////////////////////////////////////////////////////////////////////////
  ////////////////////////////   LIB        ////////////////////////////////////
  //////////////////////////////////////////////////////////////////////////////
  final public function usesLib($libname=null)
    {
    require_once 'lib/'.$libname.'/'.$libname.'.class.php';
    $className = $libname;
    $obj = & new $className();
    $this->lib->$libname = $obj;
    $this->libs[] = $className.' (lib/'.$libname.'/'.$libname.'.class.php)';
    return $obj;
    }  
    
  //////////////////////////////////////////////////////////////////////////////
  ////////////////////////////   SESSIONS    ///////////////////////////////////
  //////////////////////////////////////////////////////////////////////////////
  final public function sessinInit()
    {

    $this->session = & new UserSession;
    //print_r(get_class_methods($this->$modelname));
    }
    
  function setLang($lang='rus')
    {
    $this->lang = $lang;
    }
    
  function loadBlockLang($blockName)
    {
    if (file_exists ("blocks/$blockName/lang/$this->lang/lang.conf"))
      {
      $this->smarty->config_load("blocks/$blockName/lang/$this->lang/lang.conf");
      }
    elseif (($this->lang !=$this->lang_default) && file_exists("blocks/$blockName/lang/$this->lang_default/lang.conf"))
      {
      $this->smarty->config_load("blocks/$blockName/lang/$this->lang_default/lang.conf");
      }
    return true;
    }
  }
?>
