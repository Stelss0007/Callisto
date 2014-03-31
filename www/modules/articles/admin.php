<?php
class AdminController extends Controller
  {
  public $defaultAction = 'article_list';
  
  function articleList()
    {
    $this->viewCachedPage();
    
    $this->usesModel('articleCategory');

    $this->articles_list = $this->articles->article_list(true);
    $this->article_category_list = $this->articleCategory->category_list(false);
    
    $browsein[] =array('url'=>"/admin/main", 'displayname'=>'Dashboard');
    $browsein[] =array('url'=>'/admin/articles', 'displayname'=>'Articles'); 
    
    $this->assign('module_browsein', $browsein);
    
    $this->viewPage();
    }
    
  function articleManage($id=0)
    {
    $data = $this->input_vars;
    $this->article_category_list = $this->articleCategory->category_list(false);
    //appDebug($data);exit;
    if($data['submit'])
      {
      $data['article_add_time']   = strtotime($data['article_add_time']);
      $data['article_start_time'] = strtotime($data['article_start_time']);
      $data['article_end_time']   = strtotime($data['article_end_time']);
      
      if($id)
        {
        $this->articles->article_update($data, $id);
        }
      else
        {
        $data['article_user_id']    = $this->session->userId();
        
        $this->articles->article_create($data);
        }
      $this->deleteCache();
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
      $article['article_start_time'] = $article['article_add_time'] = time();
      $this->assign($article);
      
      $browsein[] =array('url'=>'', 'displayname'=>'Add');
      }
    
    $this->assign('module_browsein', $browsein);
    $this->viewPage();
    }
    
  function categoryList()
    {
    $this->categories_list = $this->articleCategory->getList();
    //appDebug($this->articleCategory->getList());exit;   
    $browsein[] =array('url'=>"/admin/main", 'displayname'=>'Dashboard');
    $browsein[] =array('url'=>'/admin/articles', 'displayname'=>'Articles'); 
    $browsein[] =array('url'=>'/admin/articles/ctegory_list', 'displayname'=>'Categories'); 
    
    $this->assign('module_browsein', $browsein);
    
    $this->viewPage();
    }
    
  function categoryManage($id=0)
    {
    $data = $this->input_vars;
    //appDebug($data);exit;
    $this->usesModel('articleCategory');
    if($data['submit'])
      {
      if($id)
        {
        $this->articleCategory->category_update($data, $id);
        }
      else
        {
        $this->articleCategory->category_create($data);
        }
        
      $this->deleteCache();
      $this->redirect('/admin/articles/category_list');
      }
      
    ////////////////////////////////////////////////////////////////////////////
    $browsein[] =array('url'=>"/admin/main", 'displayname'=>'Dashboard');
    $browsein[] =array('url'=>'/admin/articles', 'displayname'=>'Articles');  
    $browsein[] =array('url'=>'/admin/articles/category_list', 'displayname'=>'Categories');  
 
      
    $article = $this->articleCategory->getById($id);
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
