<?php

class articles extends Model
  {
  var $table = 'article';
  
  function article_list($full=false)
    {
    
    $result = array();
    $this->query(" 
                  SELECT a.*, u.login FROM `{$this->table}` a 
                  LEFT JOIN {$this->getModelTable('users')} u ON (u.id=a.article_user_id)
                  ORDER BY article_add_time
                ");
    $articles = $this->fetch_array();
   
    if($full)
      return $articles;
    
    foreach ($articles as $article)
      {
      $result[$article['id']] = $article['article_title'];
      }

    return $result;
    }
  
  function article_create($data)
    {
    $this->insert($this->table, $data);
    }
    
  function article_update($data, $id)
    {
    if(!is_numeric($id))
      return false;
    
    $this->update($this->table, $data, "id = '$id'");
    }
  }
