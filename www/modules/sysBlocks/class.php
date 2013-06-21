<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class SysBlocks extends Model
  {
  var $table = 'sys_blocks';
  
  function block_list()
    {
    $this->query("SELECT * FROM sys_blocks ORDER BY block_position, weight");
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
    
  function block($id)
    {
    if(!is_numeric($id))
      return false;
    
    $this->query("SELECT * FROM sys_block WHERE id='$id'");
    $block =  $this->fetch_array();
    return $block[0];
    }
    
  function block_create($data)
    {
    if($data['pass'])
      $data['pass'] = md5($data['pass']);
    
    $this->insert($this->table, $data);
    }
    
  function block_update($data, $id)
    {
    if(!is_numeric($id))
      return false;
    if($data['pass'])
      $data['pass'] = md5($data['pass']);
    
    $this->update($this->table, $data, "id = '$id'");
    }
    
  function block_delete($id)
    {
    if(!is_numeric($id))
      return false;

    $this->query("DELETE FROM sys_block WHERE id='$id'");
    }
    
  function block_activation($id)
    {
    if(!is_numeric($id))
      return false;

    $this->query("UPDATE sys_block SET active = IF(active ='1','0','1') WHERE id='$id'");
    }
    
  function logIn($login, $pass)
    {
    $pass = md5($pass);
    $this->query("SELECT * FROM sys_block WHERE login='%s' AND pass='%s' AND active = '1'", $login, $pass);
    $block =  $this->fetch_array();
    
    if(empty($block))
      return false;
    
    $this->session->blockLogin($block[0]);
    return true;
    }
    
  function logOut()
    {
    $this->session->blockLogOut();
    }
    
  function isLogin()
    {
    return $this->session->isLogin();
    }
    
  function blockId()
    {
    return $this->session->blockId();
    }
  function blockGid()
    {
    return $this->session->blockGid();
    }
  }
?>
