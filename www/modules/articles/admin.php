<?php
class AdminController extends Controller
  {
  public $defaultAction = 'article_list';
  
  function articleList()
    {
    $this->viewPage();
    }
    
  function articleManage()
    {
    $data = $this->input_vars;

    if($data['submit'])
      {
      if($id)
        {
        $this->articles->group_update($data, $id);
        }
      else
        {
        $this->articles->group_create($data);
        }
      $this->redirect('/admin/articles/article_list');
      }
    ////////////////////////////////////////////////////////////////////////////
    $browsein[] =array('url'=>"/admin/main", 'displayname'=>'Dashboard');
    $browsein[] =array('url'=>'/admin/articles', 'displayname'=>'Articles');  
   
      
    $article = $this->articles->getById($id);
    if($article)
      {
      $this->assign($article);
      $browsein[] =array('url'=>'', 'displayname'=>'Edit');
      }
    else
      {
      $browsein[] =array('url'=>'', 'displayname'=>'Add');
      }
    
    $this->assign('module_browsein', $browsein);
    $this->viewPage();
    }
  }
