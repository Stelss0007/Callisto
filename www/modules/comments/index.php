<?php
use app\modules\comments\models\Comments;

class IndexController extends Controller
  {
  public $defaultAction = 'article_list';
  
  public function actionCommentList()
    {
    $this->viewCachedPage();
    
    $this->usesModel('articleCategory');
    $this->usesModel('users');
    
    $this->articles_list = $this->articles->articleList(true, array('article_active'=>1));
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
    
    
    $browsein[] =array('url'=>"/", 'displayname'=>$this->t('dashboard'));
    $browsein[] =array('url'=>'/articles', 'displayname'=>'Comments'); 
    
    $this->assign('module_browsein', $browsein);
    
    $this->viewPage();
    }
    
  public function actionCommentAdd()
    {
    $data = $this->inputVars; 

    $comment = new Comments($data);
    $comment->comment_user_id = $this->session->userId();
    $comment->comment_addtime = time();
    $comment->comment_modtime = time();
    
    $id = $comment->save();
    
    $this->showMessage($this->t('comments_added'), $this->referer.'#comment_'.$id);
    }
  }
