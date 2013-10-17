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

    $this->query("SELECT * FROM $this->table WHERE menu_parent_id = '%d'", $parent_id);
    $menu = $this->fetch_array();
    
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
      
    $parrents = $this->fetch_array();
    
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
      
    $parrents = $this->fetch_array();
    $browsein[] = array('url'=>'/menu/menu_list/', 'displayname'=>'Menu');
    foreach($parrents as $value)
      {
      $browsein[] = array('url'=>'/menu/menu_list/'.$value['id'], 'displayname'=>$value['menu_title']);
      }
    
    return $browsein;
    }
 
    
  function hasSubitemById($id)
    {
    $menu = $this->getById($id);
    if($this->subitemCount($menu['menu_path']))
      {
      return true;
      }
    else
      {
      return false;
      }
    }
  function hasSubitem($id)
    {
    if($this->subitemCount($path))
      {
      return true;
      }
    else
      {
      return false;
      }
    }
    
  function subitemCount($path)
    {
    $params = array('condition'=>array('menu_path'=>"like '$path::%'"));
    return $this->getCount($params);
    }
    
  function updateSubitemCounter($path)
    {
    $parents = $this->getParents($path);
    foreach($parents as $parent)
      {
      $data['menu_subitem_counter'] = $this->subitemCount($parent['menu_path']);
      $this->update($this->table, $data, "id = '{$parent['id']}'");
      }
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

      
    $this->insert($this->table, $data);
    
    if($parent)
      {
      $this->updateSubitemCounter($data['menu_path']);
      }
    }
    
  function menuUpdate($data, $id)
    {
    if(!is_numeric($id))
      return false;
    
    //Получим полный путь родителей
    if(!isset($data['menu_parent_id']))
      $data['menu_parent_id'] = '0';
    
    $parent = $this->getById($data['menu_parent_id']);
    if($parent)
      {
      $data['menu_path'] = ($parent['menu_path']) ? $parent['menu_path'] : '0'.'::'.$data['menu_parent_id'];
      }
    else
      {
      $data['menu_path'] = '0';
      }
    
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
    $this->query("SELECT * FROM $this->table ORDER BY {$this->table}_parent_id, {$this->table}_weight");
    $menus = $this->fetch_array();
      
    return appTreeBuild(&$menus, $parent_id);
    }
  }
?>
