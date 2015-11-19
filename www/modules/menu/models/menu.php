<?php
namespace app\modules\menu\models;

/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class Menu extends \app\db\ActiveRecord\Model
  {
  public static $tableName = 'menu';
  
  public static function menuList($parentId = 0)
    {
    $menus = self::find()
              ->orderBy(['weight'])
              ->where(['menu_parent_id' => $parentId])
              ->all()
            ;  
    
    return $menus;
    }
    
  public static function getParents($path = null)
    {
    $parrentIs = str_replace("::", "', '", $path);
    $parrentOrder= str_replace("::", ", ", $path);
    
    if(!$parrentIs)
      {
      return [];
      }
      
    $parrents = self::executeQuery("SELECT * FROM ".self::$tableName." WHERE id IN ('$parrentIs') ORDER BY FIELD(id, $parrentOrder)");
    
    return $parrents;
    }
    
  public static function parentBrowsein($path = null)
    {
    $parrentIs = str_replace("::", "', '", $path);
    $parrentOrder= str_replace("::", ", ", $path);
    
    if(!$parrentIs)
      {
      return [];
      }
      
    $parrents = self::executeQuery("SELECT * FROM ".self::$tableName." WHERE id IN ('$parrentIs') ORDER BY FIELD(id, $parrentOrder)");

    $browsein[] = ['url'=>'/admin/menu/menu_list/', 'displayname'=>'Menu'];
    foreach($parrents as $value)
      {
      $browsein[] = ['url'=>'/admin/menu/menu_list/'.$value->id, 'displayname'=>$value->menu_title];
      }
    
    return $browsein;
    }
 
    
  public static function hasSubitemById($id)
    {
    if(self::subitemCount($id))
      {
      return true;
      }
    else
      {
      return false;
      }
    }
    
  public static function hasSubitem($parent_id)
    {
    if(self::subitemCount($parent_id))
      {
      return true;
      }
    else
      {
      return false;
      }
    }
    
  public static function subitemCount($parent_id)
    {
    return self::find()
            ->where(['menu_parent_id'=>$parent_id])
            ->count()
            ;
    }
    
  public static function updateSubitemCounter($id)
    {
    $menuItem = self::find($id);
    $menuItem->menu_subitem_counter = self::subitemCount($id);
    $menuItem->save();
    }
 
  public static function isChild($parentId = 0, $elementId = 0)
    {
    if(empty($parentId)) $parentId = 0;
    if(empty($elementId)) $elementId = 0;

    return ($parrents = self::executeQuery("SELECT * FROM ".self::$tableName." WHERE (menu_parent_id = :pid OR menu_path LIKE '%:::$elementId::%') AND id = :id", [':pid'=>$elementId, ':id'=>$parentId])) ? true : false;
    }
    
  public static function menuCreate($data)
    {
    //Получим полный путь родителей
    if(!isset($data['menu_parent_id']))
      $data['menu_parent_id'] = '0';
    
    $parent = self::find($data['menu_parent_id']);
    if($parent)
      {
      $data['menu_path'] = ($parent->menu_path) ? $parent->menu_path.'::'.$data['menu_parent_id'] : '0'.'::'.$data['menu_parent_id'];
      }
    else
      {
      $data['menu_path'] = '0';
      }

    $weight = self::weightMax(['menu_parent_id' => $data['menu_parent_id']]);
    $weight++;
    $data['weight'] = $weight;
      
    $menuNew = new self($data);
    $menuNew->save();
    
    if($parent)
      {
      self::updateSubitemCounter($data['menu_parent_id']);
      }
    }
    
  public static function menuUpdate($data, $id)
    {
    if(!is_numeric($id))
      return false;
    
    //Сведенья до момента редактирования
    $oldData = self::find($id);
    
    
    //Получим полный путь родителей
    if(!isset($data['menu_parent_id']))
      $data['menu_parent_id'] = '0';
    
    $parent = self::find($data['menu_parent_id']);
  
    if(self::isChild($parent->id, $id))
        {
        throw new \Exception('Нельзя вложить элемент в дочерний элемент!');
        }
    
    if($parent)
      {
      $data['menu_path'] = ($parent->menu_path) ? $parent->menu_path.'::'.$data['menu_parent_id'] : '0'.'::'.$data['menu_parent_id'];
      }
    else
      {
      $data['menu_path'] = '0';
      }
     
    $oldData->setAttributesByArray($data);
    $oldData->save();
    
    if($oldData->menu_path != $data['menu_path'])
      {
      self::executeQuery("UPDATE ".self::$tableName." SET menu_path = REPLACE(menu_path, '{$oldData['menu_path']}::{$id}', '{$data['menu_path']}::{$id}') WHERE menu_path LIKE '{$oldData['menu_path']}::{$id}%'");

      self::updateSubitemCounter($oldData['menu_parent_id']);
      }
      
    if($parent)
      {
      self::updateSubitemCounter($data['menu_parent_id']);
      }
    }
    
  public static function menuDelete($id)
    {
    if(!is_numeric($id))
      return false;

    $menu = self::find($id);
    $menu->delete();
    self::updateSubitemCounter($menu->menu_parent_id);
    
    }
    
  public static function treeItems($parentId = 0, $active = true)
    {
    $menus = self::find()
             ->orderBy('menu_parent_id, weight')
             ->all()
             ;
      
    return self::appTreeBuild($menus, $parentId);
    }
    
  public static function appTreeBuild(&$inArray, $start)
      {
      $result = array();
      $childMenuList = array();
      foreach($inArray as $key=>$menu)
          {
          $childMenuList[$menu->id] = $menu;
          }

      self::appCreateTree($childMenuList, $start, 0, -1, $result); 

      return $result;
      //exit;
      }

   public static function appCreateTree($array, $curParent, $currLevel = 0, $prevLevel = -1, &$result) 
        {
        foreach ($array as $categoryId => $category) 
          {
          if ($curParent == $category->menu_parent_id) 
            {
            $category->level = $currLevel;
            $result[$categoryId] = $category;
            if ($currLevel > $prevLevel) 
              { 
              $prevLevel = $currLevel;
              }

            $currLevel++;

            self::appCreateTree ($array, $categoryId, $currLevel, $prevLevel, $result);

            $currLevel--;
            }

          }
        }
  }

