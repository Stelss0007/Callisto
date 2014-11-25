<?php
class IndexController extends Controller
  {
  public $defaultAction = 'article_list';
  
  public function actionArticleList()
    {
    
    //appCanEdit();
    
    //Send Email
    //$this->sendEmailTemplate(array('stelss1986@gmail.com'), 'Test Subject', 'main');
    //appDebugExit($this->getAccessLevel());
    
    $browsein[] =array('url'=>"/", 'displayname'=>$this->t('dashboard'));
    $browsein[] =array('url'=>'/articles', 'displayname'=>'Articles'); 
    $this->assign('module_browsein', $browsein);

    $this->viewCachedPage();
    
    $this->usesModel('articleCategory');
    $this->usesModel('users');
    
    $this->articles_list = $this->articles->article_list(true, array('article_active'=>1));
    //$this->paginate($this->articles);
    
    //Подготовим фильтры
    $category_filter_list[0] = $this->t('sys_unknown');
    $category_filter_list    = $category_filter_list + $this->articleCategory->category_list(false);
    
    $user_filter_list[0] = $this->t('sys_unknown');
    $user_filter_list    = $user_filter_list + $this->users->user_list(false);
 
    $status_filter_list['-1']   = $this->t('all_status');
    $status_filter_list['1']    = $this->t('sys_active');
    $status_filter_list['0']    = $this->t('sys_no_active');
        
    $this->article_category_list = $category_filter_list;
    $this->article_user_list     = $user_filter_list;
    $this->article_status_list   = $status_filter_list;
    
    $this->assign($this->getInput('filter', array()));
    //\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\
    
    $this->viewPage();
    }
    
  public function actionView($id)
    {
    $browsein[] =array('url'=>"/", 'displayname'=>$this->t('dashboard'));
    $browsein[] =array('url'=>'/articles', 'displayname'=>'Articles'); 
    //$browsein[] =array('url'=>'/articles', 'displayname'=>$article['article_title']); 
    $browsein[] =array('url'=>'/articles', 'displayname'=>'Просмотр'); 
    
    $this->assign('module_browsein', $browsein);
    $this->viewCachedPage();
    
    $this->usesModel('articleCategory');
    $this->usesModel('users');
    
    $article = $this->articles->getById($id);
    $this->article = $article;
    //$this->paginate($this->articles);
    
    //Подготовим фильтры
    $category_filter_list[0] = $this->t('sys_unknown');
    $category_filter_list    = $category_filter_list + $this->articleCategory->category_list(false);
    
    $user_filter_list[0] = $this->t('sys_unknown');
    $user_filter_list    = $user_filter_list + $this->users->user_list(false);
 
    $status_filter_list['-1']   = $this->t('all_status');
    $status_filter_list['1']    = $this->t('sys_active');
    $status_filter_list['0']    = $this->t('sys_no_active');
        
    $this->article_category_list = $category_filter_list;
    $this->article_user_list     = $user_filter_list;
    $this->article_status_list   = $status_filter_list;

    $this->viewPage();
    }
  }
