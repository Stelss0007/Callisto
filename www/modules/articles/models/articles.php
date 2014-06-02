<?php

class articles extends Model
  {
  var $table = 'article';
  
  function article_list($full=false, $filter = array(), $limit = false, $sort = '')
    {
    $where = '';
    if($filter)
      {
      //Уберем с фильтра все ненужное
      foreach($filter as $key=>$value)
        {
        if($value == '0' && $key != 'article_active')
          {
          unset($filter[$key]);
          }
        elseif($key == 'article_active' && $value == '-1')
          {
          unset($filter[$key]);
          }
        else
          {
          $filter[$key] = "$key = '$value'";
          }
        }

      $filter_str = implode(' AND ', $filter);
      if($filter_str)
        {
        $where = 'WHERE '.$filter_str;
        }
      }
      
    //Формируем строку лимитов для sql запроса
    $limit['page'] = $this->getInput('page', 1);
    $limit['element_at_page'] = '3';
      
    $sql_limit = '';
    $this->preparePagination($where, $sql_limit);
    
    $result = array();
    $sql = " 
              SELECT a.*, u.login FROM `{$this->table}` a 
              LEFT JOIN {$this->getModelTable('users')} u ON (u.id=a.article_user_id)
              $where
              ORDER BY article_add_time
              $sql_limit
            ";
    //appDebug($sql);exit;
    $this->query($sql);
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
    return $this->insert($this->table, $data);
    }
    
  function article_update($data, $id)
    {
    if(!is_numeric($id))
      return false;
   
    $this->update($this->table, $data, "id = '$id'");
    }
  }
