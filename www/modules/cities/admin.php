<?php
class AdminController extends Controller
  {
  public $defaultAction = 'cityList';
  
  function actionCityList($parent_id = 0)
    {
    $this->getAccess(ACCESS_ADMIN);
    
    $this->usesModel('countries');
    $countries = $this->countries->getList(['fields'=>['id', 'name_ru']]);
    
    $countryList =[];
    foreach($countries as $country) {
        $countryList[$country['id']] = $country['name_ru'];
    }
    
    $this->assign('countries', $countryList);
    $this->assign('cities', $this->cities->getList());
    
    $browsein =  [
                    ['url'=>"/admin/main", 'displayname'=>$this->t('dashboard')],
                    ['url'=>"/admin/main/cities", 'displayname'=>$this->t('cities')],
                    //['url'=>"/admin/main/cities", 'displayname'=>'ffff']
                 ];

    $this->assign('module_browsein', $browsein);
    
    $this->viewPage();
    }
    
  function actionCreate()
    {
    $this->getAccess(ACCESS_ADMIN);
    $city = $this->cities->getById(0);
    
    $this->usesModel('countries');
    $countries = $this->countries->getList(['fields'=>['id', 'name_ru']]);
    
    $countryList =[];
    foreach($countries as $country) {
        $countryList[$country['id']] = $country['name_ru'];
    }
    
    $this->assign('id', 0);
    $this->assign('city', $city);
    $this->assign('countries', $countryList);
    
    $browsein =  [
                    ['url'=>"/admin/main", 'displayname'=>$this->t('dashboard')],
                    ['url'=>"/admin/cities", 'displayname'=>$this->t('cities')],
                    ['url'=>"/admin/cities/create", 'displayname'=>'Создание'],
                    //['url'=>"/admin/main/countries", 'displayname'=>'ffff']
                 ];

    $this->assign('module_browsein', $browsein);
    
    $this->viewPage();
    }
    
  function actionModify($id)
    {
    $this->getAccess(ACCESS_ADMIN);
    $city = $this->cities->getById($id);
    
    $this->usesModel('countries');
    $countries = $this->countries->getList();
    
    $countryList =[];
    foreach($countries as $country) {
        $countryList[$country['id']] = $country['name_ru'];
    }
    
    $this->assign('id', $id);
    $this->assign('city', $city);
    $this->assign('countries', $countryList);
    
    $browsein =  [
                    ['url'=>"/admin/main", 'displayname'=>$this->t('dashboard')],
                    ['url'=>"/admin/cities", 'displayname'=>$this->t('cities')],
                    ['url'=>"/admin/cities/modify", 'displayname'=>$city['name_ru'] . ' Редактирование'],
                    //['url'=>"/admin/main/cities", 'displayname'=>'ffff']
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
      
      $this->arrayToModel($this->cities, $post);
      
      if($id)
        {
        $this->cities->save($id);
        }
      else
        {
        $this->cities->created_at = time();  
        $this->cities->save();
        }
      
      $this->deleteCache();
      $this->redirect('/admin/cities');
      }
    }
    

  function actionDelete($id=0)
    {
    $this->getAccess(ACCESS_ADMIN);
    
    if(empty($id))
      $this->errors->setError("ID of menu is missing!");
   
    $this->cities->delete($id);
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

