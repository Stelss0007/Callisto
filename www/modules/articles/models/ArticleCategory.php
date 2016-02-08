<?php
namespace app\modules\articles\models;

class articleCategory extends \app\db\ActiveRecord\Model
  {
  public static $tableName = 'article_category';
  
  public static function getList($full=false)
    {
    
    $result = array();
    
    $categories = self::find()
                ->orderBy('article_category_title')
                ->all()
            ;
  
    if($full)
      return $categories;
    
    foreach ($categories as $article)
      {
      $result[$article->id] = $article->article_category_title;
      }

    return $result;
    }
  
  function categoryСreate($data)
    {
    $this->insert($this->table, $data);
    }
    
  function categoryUpdate($data, $id)
    {
    if(!is_numeric($id))
      return false;
    
    $this->update($this->table, $data, "id = '$id'");
    }
  }
