<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class Menu extends Model
  {
  var $table = 'menu';
  
  function menu_list($parent_id = 0)
    {

    $this->query("SELECT * FROM $this->table WHERE menu_parent_id = '%d' ORDER BY menu_weight", $parent_id);
    $menu = $this->fetchArray();
    
    return $menu;
    }
    
  function getParents($path = null)
    {
    $parrent_is = str_replace("::", "', '", $path);
    $parrent_order= str_replace("::", ", ", $path);
    
    if($parrent_is)
      {
      $sql = "SELECT * FROM $this->table  WHERE id IN ('$parrent_is') ORDER BY FIELD(id, $parrent_order)";
      $this->query($sql);
      }
      
    $parrents = $this->fetchArray();
    
    return $parrents;
    }
    
  function parent_browsein($path = null)
    {
    $parrent_is = str_replace("::", "', '", $path);
    $parrent_order= str_replace("::", ", ", $path);
    
    if($parrent_is)
      {
      $sql = "SELECT * FROM $this->table  WHERE id IN ('$parrent_is') ORDER BY FIELD(id, $parrent_order)";
      $this->query($sql);
      }
      
    $parrents = $this->fetchArray();
    $browsein[] = array('url'=>'/admin/menu/menu_list/', 'displayname'=>'Menu');
    foreach($parrents as $value)
      {
      $browsein[] = array('url'=>'/admin/menu/menu_list/'.$value['id'], 'displayname'=>$value['menu_title']);
      }
    
    return $browsein;
    }
 
    
  function hasSubitemById($id)
    {
    $menu = $this->getById($id);
    if($this->subitemCount($id))
      {
      return true;
      }
    else
      {
      return false;
      }
    }
  function hasSubitem($parent_id)
    {
    if($this->subitemCount($parent_id))
      {
      return true;
      }
    else
      {
      return false;
      }
    }
    
  function subitemCount($parent_id)
    {
    $params = array('condition'=>array('menu_parent_id'=>$parent_id));
    return $this->getCount($params);
    }
    
  function updateSubitemCounter($id)
    {
    $data['menu_subitem_counter'] = $this->subitemCount($id);
    $this->update($this->table, $data, "id = '$id'");
    }
 
  function isChild($parent_id = 0, $element_id = 0)
    {
    if(empty($parent_id)) $parent_id =0;
    if(empty($element_id)) $element_id =0;
    
    $conditions = array(
                       'condition'  => "(menu_parent_id = :pid OR menu_path LIKE '%:::pid::%') AND id = :id",
                       'params' => array(':pid'=>$element_id, ':id'=>$parent_id)
                       );
    return ($this->getList($conditions)) ? true : false;
    }
    
  function menuCreate($data)
    {
    //Получим полный путь родителей
    if(!isset($data['menu_parent_id']))
      $data['menu_parent_id'] = '0';
    
    $parent = $this->getById($data['menu_parent_id']);
    if($parent)
      {
      $data['menu_path'] = ($parent['menu_path']) ? $parent['menu_path'].'::'.$data['menu_parent_id'] : '0'.'::'.$data['menu_parent_id'];
      }
    else
      {
      $data['menu_path'] = '0';
      }

    $weight = $this->weightMax("menu_parent_id = '{$data['menu_parent_id']}'");
    $weight++;
    $data['menu_weight'] = $weight;
      
    $this->insert($this->table, $data);
    
    if($parent)
      {
      $this->updateSubitemCounter($data['menu_parent_id']);
      }
    }
    
  function menuUpdate($data, $id)
    {
    if(!is_numeric($id))
      return false;
    
    //Сведенья до момента редактирования
    $old_data = $this->getById($id);
    
    
    //Получим полный путь родителей
    if(!isset($data['menu_parent_id']))
      $data['menu_parent_id'] = '0';
    
    $parent = $this->getById($data['menu_parent_id']);
  
    if($this->isChild($parent['id'], $id))
      $this->errors->setError('Нельзя вложить элемент в дочерний элемент!');
    
    if($parent)
      {
      $data['menu_path'] = ($parent['menu_path']) ? $parent['menu_path'].'::'.$data['menu_parent_id'] : '0'.'::'.$data['menu_parent_id'];
      }
    else
      {
      $data['menu_path'] = '0';
      }
        
    $this->update($this->table, $data, "id = '$id'");
    
    if($old_data['menu_path'] != $data['menu_path'])
      {
      $sql = "UPDATE {$this->table} SET menu_path = REPLACE(menu_path, '{$old_data['menu_path']}::{$id}', '{$data['menu_path']}::{$id}') WHERE menu_path LIKE '{$old_data['menu_path']}::{$id}%'";
      $this->query($sql);

      $this->updateSubitemCounter($old_data['menu_parent_id']);
      }
      
    if($parent)
      {
      $this->updateSubitemCounter($data['menu_parent_id']);
      }
    }
    
  function menu_delete($id)
    {
    if(!is_numeric($id))
      return false;

    $menu = $this->getById($id);
    $this->query("DELETE FROM $this->table WHERE id='$id'");
    $this->updateSubitemCounter($menu['menu_parent_id']);
    }
    
  function tree_items($parent_id = 0, $active = true)
    {
    $this->query("SELECT * FROM $this->table ORDER BY {$this->table}_parent_id, {$this->table}_weight");
    $menus = $this->fetchArray();
      
    return appTreeBuild($menus, $parent_id);
    }
  }
?>
