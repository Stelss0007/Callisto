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
    
  function actionCreate()
    {
    $this->getAccess(ACCESS_ADMIN);
    $country = $this->countries->getById(0);
    $this->assign('id', 0);
    $this->assign('country', $country);
    
    $browsein =  [
                    ['url'=>"/admin/main", 'displayname'=>$this->t('dashboard')],
                    ['url'=>"/admin/countries", 'displayname'=>$this->t('countries')],
                    ['url'=>"/admin/countries/create", 'displayname'=>'Создание'],
                    //['url'=>"/admin/main/countries", 'displayname'=>'ffff']
                 ];

    $this->assign('module_browsein', $browsein);
    
    $this->viewPage();
    }
    
  function actionModify($id)
    {
    $this->getAccess(ACCESS_ADMIN);
    $country = $this->countries->getById($id);
    $this->assign('id', $id);
    $this->assign('country', $country);
    
    $browsein =  [
                    ['url'=>"/admin/main", 'displayname'=>$this->t('dashboard')],
                    ['url'=>"/admin/countries", 'displayname'=>$this->t('countries')],
                    ['url'=>"/admin/countries/modify", 'displayname'=>$country['name_ru'] . ' Редактирование'],
                    //['url'=>"/admin/main/countries", 'displayname'=>'ffff']
                 ];

    $this->assign('module_browsein', $browsein);
    
    $this->viewPage();
    }
    
  function actionUpdate()
    {
    $this->getAccess(ACCESS_ADMIN);
    
    $post = Request::getPostParams();
    
    if($post['submit'])
      {
      $post['updated_at']   = time();
      
      $this->arrayToModel($this->countries, $post);
      
      if($id)
        {
        $this->countries->save($id);
        }
      else
        {
        $this->countries->created_at = time();  
        $this->countries->save();
        }
      
      $this->deleteCache();
      $this->redirect('/admin/countries');
      }
    }
    

  function actionDelete($id=0)
    {
    $this->getAccess(ACCESS_ADMIN);
    
    if(empty($id))
      $this->errors->setError("ID of menu is missing!");
   
    $this->countries->delete($id);
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

