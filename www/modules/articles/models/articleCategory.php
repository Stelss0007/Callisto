<?php

class articleCategory extends Model
  {
  var $table = 'article_category';
  
  function categoryList($full=false)
    {
    
    $result = array();
    $this->query(" 
                  SELECT * FROM `{$this->table}`  
                  ORDER BY article_category_title
                ");
    $articles = $this->fetchArray();
   
    if($full)
      return $articles;
    
    foreach ($articles as $article)
      {
      $result[$article['id']] = $article['article_category_title'];
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
