<?php
use app\modules\articles\models\Articles;
use app\modules\articles\models\ArticleCategory;

class IndexController extends Controller
  {
  public $defaultAction = 'article_list';
  
  public function actionArticleList()
    {
    $browsein[] =array('url'=>"/", 'displayname'=>$this->t('dashboard'));
    $browsein[] =array('url'=>'/articles', 'displayname'=>'Articles'); 
    $this->assign('module_browsein', $browsein);

    $this->viewCachedPage();
   
    $this->articles_list = Articles::getList(true, ['article_active'=>1]);
    //$this->paginate($this->articles);
  
    //Подготовим фильтры
    $category_filter_list[0] = $this->t('sys_unknown');
    $category_filter_list    = $category_filter_list + ArticleCategory::getList(false);
    
    $user_filter_list[0] = $this->t('sys_unknown');
    $user_filter_list    = $user_filter_list + app\modules\users\models\Users::getList(false);
 
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
    
  public function actionUser($user_id)
    {
    
    //appCanEdit();
    
    //Send Email
    //$this->sendEmailTemplate(array('stelss1986@gmail.com'), 'Test Subject', 'main');
    //appDebugExit($this->getAccessLevel());
    
    $browsein[] =array('url'=>"/", 'displayname'=>$this->t('dashboard'));
    $browsein[] =array('url'=>'/articles', 'displayname'=>'Articles'); 
    $this->assign('module_browsein', $browsein);

    $this->viewCachedPage();

    
    $this->articles_list = Articles::getList(true, array('article_active' => 1, 'article_user_id' => $user_id));
    //$this->paginate($this->articles);
    
    //Подготовим фильтры
    $category_filter_list[0] = $this->t('sys_unknown');
    $category_filter_list    = $category_filter_list + ArticleCategory::getList(false);
    
    $user_filter_list[0] = $this->t('sys_unknown');
    $user_filter_list    = $user_filter_list + app\modules\users\models\Users::getList(false);
 
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
    
  public function actionCategory($categoryId)
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
    
    $this->articles_list = $this->articles->articleList(true, array('article_active' => 1, 'article_category_id' => $categoryId));
    //$this->paginate($this->articles);
    
    //Подготовим фильтры
    $category_filter_list[0] = $this->t('sys_unknown');
    $category_filter_list    = $category_filter_list + $this->articleCategory->categoryList(false);
    
    $user_filter_list[0] = $this->t('sys_unknown');
    $user_filter_list    = $user_filter_list + $this->users->userList(false);
 
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
    
     
    $this->article = Articles::find($id);
    //$this->paginate($this->articles);
    
    //Подготовим фильтры
    $category_filter_list[0] = $this->t('sys_unknown');
    $category_filter_list    = $category_filter_list + ArticleCategory::getList(false);
    
    $user_filter_list[0] = $this->t('sys_unknown');
    $user_filter_list    = $user_filter_list + app\modules\users\models\Users::getList(false);
 
    $status_filter_list['-1']   = $this->t('all_status');
    $status_filter_list['1']    = $this->t('sys_active');
    $status_filter_list['0']    = $this->t('sys_no_active');
        
    $this->article_category_list = $category_filter_list;
    $this->article_user_list     = $user_filter_list;
    $this->article_status_list   = $status_filter_list;

    $this->viewPage();
    }
  }
