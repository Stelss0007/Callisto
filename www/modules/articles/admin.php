<?php
use app\modules\articles\models\Articles;
use app\modules\articles\models\ArticleCategory;

class AdminController extends Controller
  {
  public $defaultAction = 'article_list';
  
  function actionArticleList()
    {
    $this->getAccess(ACCESS_READ);
    $this->viewCachedPage();
    
            
    $this->articles_list = Articles::getList(true, $this->getInput('filter', []));
        //$this->paginate($this->articles);
    
    //Подготовим фильтры
    $category_filter_list[0] = $this->t('all_category');
    $category_filter_list    = $category_filter_list + ArticleCategory::getList(false);
    
    $user_filter_list[0] = $this->t('all_user');
    $user_filter_list    = $user_filter_list + \app\modules\users\models\Users::getList(false);
 
    $status_filter_list['-1']   = $this->t('all_status');
    $status_filter_list['1']    = $this->t('sys_active');
    $status_filter_list['0']    = $this->t('sys_no_active');
        
    $this->article_category_list = $category_filter_list;
    $this->article_user_list     = $user_filter_list;
    $this->article_status_list   = $status_filter_list;
    
    $this->assign($this->getInput('filter', array()));
    //\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\
    
    
    $browsein[] =array('url'=>"/admin/main", 'displayname'=>$this->t('dashboard'));
    $browsein[] =array('url'=>'/admin/articles', 'displayname'=>'Articles'); 
    
    $this->assign('module_browsein', $browsein);
    
    $this->viewPage();
    }
    
  function actionArticleManage($id=0)
    {
    $this->getAccess(ACCESS_ADD);
    $data = $this->inputVars;
    $this->article_category_list = $this->articleCategory->categoryList(false);
    //appDebug($data);exit;
    if($data['submit'])
      {
      $data['article_add_time']   = strtotime($data['article_add_time']);
      $data['article_start_time'] = strtotime($data['article_start_time']);
      $data['article_end_time']   = strtotime($data['article_end_time']);
      
      if($id)
        {
        $this->articles->articleUpdate($data, $id);
        }
      else
        {
        $data['article_user_id']    = $this->session->userId();
        $id = $this->articles->articleCreate($data);
        }
      
      //Upload Image and Update article image field  
      if($dataImage['article_image'] = $this->saveImage('post_image', $id))
        {
        $dataImage['article_image'] = serialize( $dataImage['article_image']);
        $this->articles->articleUpdate($dataImage, $id);
        }
      
      $this->deleteCache();
      $this->redirect('/admin/articles/article_list');
      }
    ////////////////////////////////////////////////////////////////////////////
    $browsein[] =array('url'=>"/admin/main", 'displayname'=>$this->t('dashboard'));
    $browsein[] =array('url'=>'/admin/articles', 'displayname'=>'Articles');  
   
      
    $article = $this->articles->getById($id);
    $article['article_image'] = unserialize($article['article_image']);
    
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
    $this->getAccess(ACCESS_READ);
    $this->categories_list = $this->articleCategory->getList();
    //appDebug($this->articleCategory->getList());exit;   
    $browsein[] =array('url'=>"/admin/main", 'displayname'=>$this->t('dashboard'));
    $browsein[] =array('url'=>'/admin/articles', 'displayname'=>'Articles'); 
    $browsein[] =array('url'=>'/admin/articles/ctegory_list', 'displayname'=>'Categories'); 
    
    $this->assign('module_browsein', $browsein);
    
    $this->viewPage();
    }
    
  function actionCategoryManage($id=0)
    {
    $this->getAccess(ACCESS_ADD);
    $data = $this->inputVars;
    //appDebug($data);exit;
    $this->usesModel('articleCategory');
    if($data['submit'])
      {
      if($id)
        {
        $this->articleCategory->categoryUpdate($data, $id);
        }
      else
        {
        $this->articleCategory->categoryСreate($data);
        }
        
      $this->deleteCache();
      $this->redirect('/admin/articles/category_list');
      }
      
    ////////////////////////////////////////////////////////////////////////////
    $browsein[] =array('url'=>"/admin/main", 'displayname'=>$this->t('dashboard'));
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
    $this->getAccess(ACCESS_ADMIN);
    $data = $this->inputVars;
    
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
    $this->getAccess(ACCESS_READ);
    
    $aColumns = array( 'id', 'article_title', 'article_category_id', 'article_user_id', 'article_active', 'article_add_time' );
    
    $offset  = $this->getInput('iDisplayStart', '0');
    $limit   = $this->getInput('iDisplayLength', '0');
    $sEcho   = $this->getInput('sEcho', '0');
    $sSearch = $this->getInput('sSearch', '');
	
    /* Indexed column (used for fast and accurate table cardinality) */
    $sIndexColumn = "id";
    
    $this->usesModel('articleCategory');
    $article_category_list = $this->articleCategory->categoryList(false);
    
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
                  ''
                  .(($value['article_active']) ? "<a href='/admin/articles/activation/{$value['id']}' onclick=\"return confirm('".$this->t('sys_confirm_deactivate')."')\" title='".$this->t('sys_disabled')."' class=\"btn btn-icon btn-pause\"><i class=\"icon-pause\"></i></a>" : 
                  "<a href='/admin/articles/activation/{$value['id']}' onclick=\"return confirm('".$this->t('sys_confirm_activate')."')\" title='".$this->t('sys_enabled')."' class=\"btn btn-icon btn-play\"><i class=\"icon-play\"></i></a>")
                  . "<a href='/admin/articles/article_manage/{$value['id']}' title='{$this->t('sys_edit')}' class='btn btn-icon btn-edit'><i class='icon-edit'></i></a>"
                  . "<a href='/admin/articles/delete/{$value['id']}' title='".$this->t('sys_delete')."' class='btn btn-icon btn-delete'><i class='icon-trash'></i></a>"
                    
                  );
            
      $result[$key] = $row;
      }
    
    $output = array(
                    "sEcho" => intval($sEcho),
                    "iTotalRecords" => $totalCount,
                    "iTotalDisplayRecords" => $totalCount,//count($result),
                    "aaData" => array_values($result)
                   );
    //print_r($output);
    
    echo json_encode( $output, JSON_ERROR_UTF8 );
    }
  }
  
  
