<?php
use app\modules\articles\models\Articles;
use app\modules\articles\models\ArticleCategory;

class IndexController extends Controller
  {
  public $defaultAction = 'article_list';
  
  public function actionArticleList()
    {
    /*
    $testArray = [
        'firstName' => 'ru',
        'secondName' => 'rus',
        'birthday' => '2016-10-20',
        'cardNumber' => '5211537422805189',
    ];  
    
    $validationRules = [
        'firstName'=> ['max'=>40, 'min'=>3, 'required'],
        'secondName'=> 'required',
        'birthday'=> ['required', 'date'=>'Y-m-d'],
        'cardNumber' => ['creditCard'],
    ];
    
    $validator  = \Validator::make($testArray, $validationRules);  
    appDebug($validator->hasError());  
    appDebug($validator->getErrors());  
    appDebug($validator->getFirstError('firstName')); 
     */
      
    $browsein[] = ['url'=>"/", 'displayname'=>$this->t('dashboard')];
    $browsein[] = ['url'=>'/articles', 'displayname' => $this->t('articles_header')]; 
    $this->assign('module_browsein', $browsein);

    $this->viewCachedPage();
   
    $this->articles_list = Articles::getList(true, ['active'=>1]);
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
  
    $this->assign($this->getInput('filter', []));
    
    $this->viewPage();
    }
    
  public function actionUser($user_id)
    {
    $browsein[] = ['url'=>"/", 'displayname'=>$this->t('dashboard')];
    $browsein[] = ['url'=>'/articles', 'displayname'=>$this->t('articles_header')]; 
    $this->assign('module_browsein', $browsein);

    $this->viewCachedPage();

    
    $this->articles_list = Articles::getList(true, ['active' => 1, 'article_user_id' => $user_id]);
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
    
    $this->assign($this->getInput('filter', []));
    //\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\
    
    $this->viewPage();
    }
    
  public function actionCategory($categoryId)
    {
    
    //appCanEdit();
    
    //Send Email
    //$this->sendEmailTemplate(array('stelss1986@gmail.com'), 'Test Subject', 'main');
    //appDebugExit($this->getAccessLevel());
    
    $browsein[] = ['url'=>"/", 'displayname' => $this->t('dashboard')];
    $browsein[] = ['url'=>'/articles', 'displayname' => $this->t('articles_header')]; 
    $this->assign('module_browsein', $browsein);

    $this->viewCachedPage();
    
    $this->usesModel('articleCategory');
    $this->usesModel('users');
    
    $this->articles_list = $this->articles->articleList(true, ['article' => 1, 'article_category_id' => $categoryId]);
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
    
    $this->assign($this->getInput('filter', []));
    //\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\
    
    $this->viewPage();
    }
    
  public function actionView($id)
    {
    $browsein[] = ['url'=>"/", 'displayname' => $this->t('dashboard')];
    $browsein[] = ['url'=>'/articles', 'displayname' => $this->t('articles_header')]; 
    $browsein[] = ['url'=>'/articles', 'displayname' => $this->t('sys_view')]; 
    
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
