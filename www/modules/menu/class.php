<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class Menu extends Model
  {
  var $table = 'menu';
  
  function menu_list($parent_id)
    {
    $result = array();
    $this->query("SELECT * FROM $this->table WHERE parent_id = '%d'", $parent_id);
    $menu = $this->fetch_array();
    
    return $menu;
    }
 
    
  function menu_create($data)
    {
    $this->insert($this->table, $data);
    }
    
  function menu_update($data, $id)
    {
    if(!is_numeric($id))
      return false;
    
    $this->update($this->table, $data, "id = '$id'");
    }
    
  function menu_delete($id)
    {
    if(!is_numeric($id))
      return false;

    $this->query("DELETE FROM $this->table WHERE id='$id'");
    }
    
  function tree_items($parent_id = 0, $active = true)
    {
    $this->query("SELECT * FROM $this->table ORDER BY parent_id, weight");
    $menus = $this->fetch_array();
      
    return appTreeBuild(&$menus, $parent_id);
    }
  }
?>
