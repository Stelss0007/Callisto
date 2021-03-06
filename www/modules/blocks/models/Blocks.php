<?php
namespace app\modules\blocks\models;
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class Blocks extends \app\db\ActiveRecord\Model
  {
  public static $tableName = 'block';
  
  public static function blockList()
    {
    $blocks = self::find()
              ->orderBy(['weight'])
              ->all()
            ;
    
    $blocks_list = [];
    $blocks_list['blocks_list_l'] = [];
    $blocks_list['blocks_list_r'] = [];
    $blocks_list['blocks_list_t'] = [];
    $blocks_list['blocks_list_b'] = [];
    $blocks_list['blocks_list_c'] = [];

    foreach($blocks as $block)
      {
      switch ($block->position)
        {
        case 'l':
          $blocks_list['blocks_list_l'][] = $block;
          break;
        case 'r':
          $blocks_list['blocks_list_r'][] = $block;
          break;
        case 't':
          $blocks_list['blocks_list_t'][] = $block;
          break;
        case 'b':
          $blocks_list['blocks_list_b'][] = $block;
          break;
        case 'c':
          $blocks_list['blocks_list_c'][] = $block;
          break;
        }
      }
    return $blocks_list;
    }
    

    
  function block_activation($id)
    {
    if(!is_numeric($id))
      return false;

    $this->query("UPDATE block SET active = IF(active ='1','0','1') WHERE id='$id'");
    }
    
  function install($block_name, $input_position = 'l')
    {
    $position['l']='Слева';
    $position['r']='Справа';
    $position['t']='Сверху';
    $position['b']='Снизу';
    $position['c']='Поцентру';

    $position = $position[$input_position];
    if(empty ($position)) 
      die('Неизвестная позиция!');
    
    //Взяли список с диска
    if(!file_exists ("blocks/$block_name/info.php")) 
      die ('Отсутствует блок!');

    // Found
    $info = array();
    $info['version'] = '0';
    $info['description'] = '';
    include("blocks/$block_name/info.php");
    $info['name'] = $block_name;
    
    $weight = $this->weightMax("block_position = '{$input_position}'");
    $weight++;

    $info['weight'] = $weight;
    $info['last_update'] = time();
    $info['position'] = $input_position;
    $info['pattern'] = '.*';
   
    $this->arrayToModel($this, $info);
    
    $this->save();
    }
    
  function groupActionInstall($blocks)
    {
    if(empty($blocks))
      return false;

    foreach($blocks as $block)
      {
      $this->install($block, $this->getInput('position', 'l'));
      }
    }
  }

