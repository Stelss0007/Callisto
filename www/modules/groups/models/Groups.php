<?php
namespace app\modules\groups\models;
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class Groups extends \app\db\ActiveRecord\Model
  {
  public static $tableName = '`group`';
  
  public static function groupList($full=false)
    {
    $groups = self::findAll();

    if($full)
      return $groups;
    
    $result = array();
    foreach ($groups as $group)
      {
      $result[$group->id] = $group->group_displayname;
      }
 
    return $result;
    }
    
  public static function groupView($id)
    {
    if(!is_numeric($id))
      return false;
    
    
    $group = $this->find($id);
    return $group;
    }
    
  function groupCreate($data)
    {
    $this->insert($this->table, $data);
    }
    
  function group_update($data, $id)
    {
    if(!is_numeric($id))
      return false;
    
    $this->update($this->table, $data, "id = '$id'");
    }
    
  function group_delete($id)
    {
    if(!is_numeric($id))
      return false;

    $this->query("DELETE FROM `group` WHERE id='$id'");
    }
  }

