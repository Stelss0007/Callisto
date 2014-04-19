<?php
class AdminController extends Controller
  {
  public $defaultAction = 'article_list';
  
  function actionArticleList()
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
    
  function actionArticleManage($id=0)
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
    
  function actionCategoryList()
    {
    $this->categories_list = $this->articleCategory->getList();
    //appDebug($this->articleCategory->getList());exit;   
    $browsein[] =array('url'=>"/admin/main", 'displayname'=>'Dashboard');
    $browsein[] =array('url'=>'/admin/articles', 'displayname'=>'Articles'); 
    $browsein[] =array('url'=>'/admin/articles/ctegory_list', 'displayname'=>'Categories'); 
    
    $this->assign('module_browsein', $browsein);
    
    $this->viewPage();
    }
    
  function actionCategoryManage($id=0)
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
    
  function actionCategoryGroupOperation()
    {
    $data = $this->input_vars;
    
    $model_name = 'articleCategory';
    
    switch($data['action_name'])
      {
      case 'delete':
        $this->$model_name->groupActionDelete($data['entities']);
        $this->showMessage($this->t('sys_elements_is_removed'));
        break;
        
      case 'activate':
        $this->$model_name->groupActionActivate($data['entities']);
        $this->showMessage($this->t('sys_elements_is_actived'));
        break;
      
      case 'deactivate':
        $this->$model_name->groupActionDeactivate($data['entities']);
        $this->showMessage($this->t('sys_elements_is_deactived'));
        break;
      
      case 'install':
        $this->$model_name->groupActionInstall($data['entities']);
        $this->showMessage($this->t('sys_elements_is_installed'));
        break;

      default:
        break;
      }
    }
    
    
  function actionAjaxArticleList()
    {
    $aColumns = array( 'id', 'article_title', 'article_category_id', 'article_user_id', 'article_active', 'article_add_time' );
    
    $offset  = $this->getInput('iDisplayStart', '0');
    $limit   = $this->getInput('iDisplayLength', '0');
    $sEcho   = $this->getInput('sEcho', '0');
    $sSearch = $this->getInput('sSearch', '');
	
    /* Indexed column (used for fast and accurate table cardinality) */
    $sIndexColumn = "id";
    
    $this->usesModel('articleCategory');
    $article_category_list = $this->articleCategory->category_list(false);
    
    $conditions = array(
                        'join'   => "LEFT JOIN {$this->articles->getModelTable('users')} u ON (u.id=t.article_user_id)",
                        'limit'  => $limit,
                        'offset' => $offset
                       );
  
    $totalCount = $this->articles->getCount();
    $result     = $this->articles->getList($conditions);
    
    foreach($result as $key => $value)
      {
      $row = array(
                  '<input type="checkbox" name="entities[]" class="td_entities" value="'.$value['id'].'">',
                  $value['id'],
                  $value['article_title'],
                  $article_category_list[$value['article_category_id']],
                  $value['login'],
                  $value['active'],
                  $value['article_add_time'],
                  '<input type="checkbox" name="entities[]" class="td_entities" value="'.$value['id'].'">'
                  );
            
      $result[$key] = $row;
      }
    
    $output = array(
                    "sEcho" => intval($sEcho),
                    "iTotalRecords" => $totalCount,
                    "iTotalDisplayRecords" => $totalCount,//count($result),
                    "aaData" => array_values($result)
                   );
    
    echo json_encode( $output );
    }
  }
  
  
