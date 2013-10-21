<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class Blocks extends Model
  {
  var $table = 'block';
  
  function block_list()
    {
    $this->query("SELECT * FROM block ORDER BY block_position, {$this->table}_weight");
    $blocks= $this->fetch_array();

    $blocks_list = array();

    foreach($blocks as $block)
      {
      switch ($block['block_position'])
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
  }
?>
