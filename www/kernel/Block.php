<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
use app\modules\blocks\models\Blocks;
/**
 * Description of block
 *
 * @author Your Name <your.name at your.org>
 */
class Block extends AppObject
  {
  //public $vars = array();
  public $smarty = null;
  public $id;
  public $name;
  public $displayname;
  public $pattern;
  public $content;
  public $position;
  public $active;
  public $refresh;
  public $last_update;
  public $lang;
  public $css_class;
  public $module_object;
  public $input_vars;
  
  public $object;
  public $root_dir;
  public static $localTheme;
  
  //public $session;
  public $lib;
  //public $libs = array();
  protected $modname;
  private $lang_default = 'rus';

  function __construct($blockInfo) 
    {
    $this->root_dir = APP_DIRECTORY.'/';
    foreach($blockInfo as $key=>$value)
      {
      $this->$key = $value;
      if($key == 'content')
        {
        if(!empty($value))
          {
          $this->$key = unserialize(stripslashes($value));
          $this->content = unserialize(stripslashes($value));
          foreach($this->content as $blockKey => $blockValue)
            {
            $this->$blockKey = $blockValue;
            }
          }
        }
      }
    $this->object = $this->name.'|display|'.$this->id;
    require_once(SMARTY_DIR.'Smarty.class.php');
    $this->smarty = new viewTpl();
    $this->smarty->assign($blockInfo);
    
    //Установим язык
    $this->setLang(\App::$config['lang']);
    }
    /************************** Блоки  *******************************/
  //Соберем все блоки и приготовим к отображению по своим местам

  public static function blockShowAll(&$myTpl, &$object, $theme, $modname)
    {
    self::$localTheme = $theme;
    
    $dbBlockList = app\modules\blocks\models\Blocks::find()
            ->where(['active' => '1'])
            ->orderBy(['position', 'weight'])
            ->all()
    ;
  
    $resultBlocks = array ();
    $resultBlocks['left']=array ();
    $resultBlocks['right']=array ();
    $resultBlocks['top']=array ();
    $resultBlocks['bottom']=array ();
    $resultBlocks['center']=array ();
    

    foreach($dbBlockList as $item)
      {
      //Проверим подходит ли этот блок данному объекту
      $pattern='/'.$item->pattern.'/iU';
      if (!preg_match ($pattern, $object)) continue;

      //В информацию о блоке добавляем - module_object
      $item->module_object = $object;
      $item->module_name = $modname;
      $item->theme = $theme;

      //Выполним код блока и вернем результат
      $blockContent = self::blockRun($item);
      
      //В зависимости от положения
      switch ($item->position)
        {
        case 'l'://Левые блоки
          array_push ($resultBlocks['left'], $blockContent);
          break;
        case 'r':
          array_push ($resultBlocks['right'], $blockContent);
          break;
        case 't':
          array_push ($resultBlocks['top'], $blockContent);
          break;
        case 'b':
          array_push ($resultBlocks['bottom'], $blockContent);
          break;
        case 'c':
          array_push ($resultBlocks['center'], $blockContent);
          break;
        }
      }

    //Загоняем в шаблон
    $myTpl->assign('blocks', $resultBlocks);
    return true;
    }

  public static function blockRun($block)
    {
    $blockName = $block->name;
    $result = array ();
    if(empty($blockName))
      {
      return $result;
      }

    $$blockName = null;
    //Подключим файл блока, если он есть, если нет вернем ошибку
    $fname = "blocks/{$blockName}/block.php";
  
    if (file_exists($fname))
      {
      include_once ($fname);
     
      $$blockName = new $blockName($block);
      $$blockName->loadBlockLang($blockName);
      $$blockName->name = $blockName;
      }
    else
      {
      $result['displayname'] = 'Блок не найден';
      $result['content'] = 'Блок не найден';
      return $result;
      }
    //Ищем функцию отображения результатов работы блока
    $blockfunc = "display";

    if (method_exists($$blockName, $blockfunc))
      {
      
      $result = $$blockName->$blockfunc($block);
      if (!empty ($result['content']))
        {
        $result['id'] = $block->id;
        $result['displayname'] = $block->displayname;
        $result['position'] = $block->position;
        $result['weight'] = $block->weight;
        $result['active'] = $block->active;
        $result['name'] = $block->name;
        $result['css_class'] = $block->css_class;
        $result['theme_id'] = $block->theme_id;
        $result['pattern'] = $block->pattern;
        //$result = array_merge ($block, $result);
        }
        
      return $result;
      }
    else
      {
      $result['displayname'] = 'Блок не найден';
      $result['content'] = 'Блок не найден';
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
  
  final function assign($var_name = null, $var_value = '')
    {
    if(empty($var_name))
      {
      return true;
      }
    if(is_array($var_name))
      {
      $this->vars = array_merge($this->vars, $var_name);
      }
    else
      {
      $this->vars[$var_name] = $var_value;
      }
    }
    
  final public function getBlockContent($name='', $value='')
    {
    if(empty($name))
      {
      return $this->content;
      }
    if(empty($this->content) || empty($this->content[$name]))
      {
      return $value;
      }
    return $this->content[$name];
    }
    
  final public function setBlockContent($name, $value)
    {
    $this->vars[$name] = $value;
    }
    
  final public function tplFileName($method, $debug=false)
    {
    $view_file_name = $method;
    $this->theme = self::$localTheme;
    if(file_exists($this->root_dir.'themes/'.$this->theme.'/blocks/'.$this->name.'/'.$method.'.tpl'))
      {
      //$this->tpls[] = '(Overridden by Theme) '.'themes/'.$this->theme.'/'.$this->module_dir.$view_file_name.'.tpl';
      return $this->root_dir.'themes/'.$this->theme.'/blocks/'.$this->name.'/'.$method.'.tpl';
      }
    elseif(file_exists($this->root_dir.'blocks/'.$this->name.'/themes/default/'.$method.'.tpl'))
      {
      //$this->tpls[] = '(Original Module TPL) '.$this->module_dir.'themes/default/'.$view_file_name.'.tpl';
      return $this->root_dir.'blocks/'.$this->name.'/themes/default/'.$method.'.tpl';
      }
    elseif(!empty($debug))
      {
      //$this->tpls[] = '(TPL file is not exist!) '.$this->module_dir.'themes/default/'.$view_file_name.'.tpl';
      return 'TPL file is not exist! '.$this->root_dir.'blocks/'.$this->name.'/themes/default/'.$method.'.tpl <br> You most created tpl file <b>"'.$method.'.tpl"</b> for block <b>'.$this->block_name.'</b><br>';
      }
    else
      {
      //$this->tpls[] = '(TPL file is not exist!) '.$this->module_dir.'themes/default/'.$view_file_name.'.tpl';
      echo 'TPL file is not exist! '.$this->root_dir.'blocks/'.$this->name.'/themes/default/'.$method.'.tpl <br> You most created tpl file <b>"'.$method.'.tpl"</b> for block <b>'.$this->block_name.'</b><br>';
      echo "Values for TPL:<br>";
      echo "<pre>";
      print_r($this->vars);
      echo "</pre>";
      die();
      }
    }
   
    
  final public function viewCached()
    {
    $method = $this->GetCallingMethodName(2); 
    $tpl_dir = $this->tplFileName($method);
    
//    if(!$this->smarty->is_cached($tpl_dir, $ObjectName))
    if(!$this->smarty->isCached($tpl_dir, $ObjectName))
      return true;
    
    $ObjectName = $this->block_object = $this->name.'|'.$method.'|'.$this->id;
    $result['content'] = $this->smarty->fetch($tpl_dir, $ObjectName);
    return $result;
    }
    
  final public function view()
    {
    $method = $this->GetCallingMethodName(2); 
    $tpl_dir = $this->tplFileName($method);
    $this->allVarToTpl();
    $ObjectName = $this->block_object = $this->name.'|'.$method.'|'.$this->id;
    $result['content'] = $this->smarty->fetch($tpl_dir, $ObjectName);
    return $result;
    }
    
  final public function save($id)
    {
    $block = Blocks::find($id);
    if($this->vars['attributes']) {
        $this->vars['attributes']['content'] = '';
        $block->content = serialize($this->vars['attributes']);
    } else {
        $this->vars['content'] = '';
        $block->content = serialize($this->vars);
    }
        
    $block->save();
    }

  function setLang($lang='rus')
    {
    $this->lang = $lang;
    }
    
  function loadBlockLang($blockName)
    {
    if (file_exists ("blocks/$blockName/lang/$this->lang/lang.conf"))
      {
      $this->smarty->configLoad("blocks/$blockName/lang/$this->lang/lang.conf");
      }
    elseif (($this->lang !=$this->lang_default) && file_exists("blocks/$blockName/lang/$this->lang_default/lang.conf"))
      {
      $this->smarty->configLoad("blocks/$blockName/lang/$this->lang_default/lang.conf");
      }
    return true;
    }
  }
