<?php
class AdminController extends Controller
  {
  public $defaultAction = 'countryList';
  
  function actionCountryList($parent_id = 0)
    {
    $this->getAccess(ACCESS_ADMIN);
    $this->assign('countries', $this->countries->getList());
    
    $browsein =  [
                    ['url'=>"/admin/main", 'displayname'=>$this->t('dashboard')],
                    ['url'=>"/admin/main/countries", 'displayname'=>$this->t('countries')],
                    //['url'=>"/admin/main/countries", 'displayname'=>'ffff']
                 ];

    $this->assign('module_browsein', $browsein);
    
    $this->viewPage();
    }
    
  function actionModify($id)
    {
    $this->getAccess(ACCESS_ADMIN);
    $this->assign('country', $this->countries->getById($id));
    
    $browsein =  [
                    ['url'=>"/admin/main", 'displayname'=>$this->t('dashboard')],
                    ['url'=>"/admin/main/countries", 'displayname'=>$this->t('countries')],
                    //['url'=>"/admin/main/countries", 'displayname'=>'ffff']
                 ];

    $this->assign('module_browsein', $browsein);
    
    $this->viewPage();
    }
    
  function actionUpdate()
    {
    $this->getAccess(ACCESS_ADMIN);
    $post = $this->getPostData(
            [
            'name_ru',
            'name_en',
            ]
            );
    appDebugExit($post);   
    if($data['submit'])
      {
      $data['article_add_time']   = strtotime($data['article_add_time']);
      $data['article_start_time'] = strtotime($data['article_start_time']);
      $data['article_end_time']   = strtotime($data['article_end_time']);
      
      $this->arrayToModel($this->countries, $post);
      
      if($id)
        {
        $this->countries->save($id);
        }
      else
        {
        $this->countries->save();
        }
      
      $this->deleteCache();
      $this->redirect('/admin/articles/article_list');
      }
    }
    

  function actionDelete($id=0)
    {
    $this->getAccess(ACCESS_ADMIN);
    
    if(empty($id))
      $this->errors->setError("ID of menu is missing!");
    
    if($this->menu->hasSubitemById($id))
      {
      $this->showMessage('Элемент меню не может быть удален! Есть дочерние элементы.');
      }
    
    $this->menu->menu_delete($id);
    $this->showMessage('Элемент меню успешно удален!');
    $this->redirect();
    }
    
  function actionActive($id)
    {
    $this->getAccess(ACCESS_ADMIN);
    $this->menu->block_active = '1';
    $this->menu->save($id);
    $this->redirect();
    }
    
  function actionDeactive($id)
    {
    $this->getAccess(ACCESS_ADMIN);
    $this->menu->block_active = '0';
    $this->menu->save($id);
    $this->redirect();
    }
  }

