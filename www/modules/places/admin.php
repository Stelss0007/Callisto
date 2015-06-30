<?php
class AdminController extends Controller
  {
  public $defaultAction = 'placeList';
  
  function actionPlaceList($parent_id = 0)
    {
    $this->getAccess(ACCESS_ADMIN);
    
    $this->usesModel('countries');
    $countries = $this->countries->getList(['fields'=>['id', 'name_ru']]);
    
    $countryList =[];
    foreach($countries as $country) {
        $countryList[$country['id']] = $country['name_ru'];
    }
    
    $this->assign('countries', $countryList);
    $this->assign('places', $this->places->getList());
    
    $browsein =  [
                    ['url'=>"/admin/main", 'displayname'=>$this->t('dashboard')],
                    ['url'=>"/admin/main/places", 'displayname'=>$this->t('places')],
                    //['url'=>"/admin/main/places", 'displayname'=>'ffff']
                 ];

    $this->assign('module_browsein', $browsein);
    
    $this->viewPage();
    }
    
  function actionCreate()
    {
    $this->getAccess(ACCESS_ADMIN);
    $place = $this->places->getById(0);
    
    $this->usesModel('countries');
    $countries = $this->countries->getList(['fields'=>['id', 'name_ru']]);
    
    $countryList =[];
    foreach($countries as $country) {
        $countryList[$country['id']] = $country['name_ru'];
    }
    
    $this->assign('id', 0);
    $this->assign('place', $place);
    $this->assign('countries', $countryList);
    
    $browsein =  [
                    ['url'=>"/admin/main", 'displayname'=>$this->t('dashboard')],
                    ['url'=>"/admin/places", 'displayname'=>$this->t('places')],
                    ['url'=>"/admin/places/create", 'displayname'=>'Создание'],
                    //['url'=>"/admin/main/countries", 'displayname'=>'ffff']
                 ];

    $this->assign('module_browsein', $browsein);
    
    $this->viewPage();
    }
    
  function actionModify($id)
    {
    $this->getAccess(ACCESS_ADMIN);
    $place = $this->places->getById($id);
    
    $this->usesModel('countries');
    $countries = $this->countries->getList();
    
    $countryList =[];
    foreach($countries as $country) {
        $countryList[$country['id']] = $country['name_ru'];
    }
    
    $this->assign('id', $id);
    $this->assign('place', $place);
    $this->assign('countries', $countryList);
    
    $browsein =  [
                    ['url'=>"/admin/main", 'displayname'=>$this->t('dashboard')],
                    ['url'=>"/admin/places", 'displayname'=>$this->t('places')],
                    ['url'=>"/admin/places/modify", 'displayname'=>$place['name_ru'] . ' Редактирование'],
                    //['url'=>"/admin/main/places", 'displayname'=>'ffff']
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
      
      $this->arrayToModel($this->places, $post);
      
      if($id)
        {
        $this->places->save($id);
        }
      else
        {
        $this->places->created_at = time();  
        $this->places->save();
        }
      
      $this->deleteCache();
      $this->redirect('/admin/places');
      }
    }
    

  function actionDelete($id=0)
    {
    $this->getAccess(ACCESS_ADMIN);
    
    if(empty($id))
      $this->errors->setError("ID of menu is missing!");
   
    $this->places->delete($id);
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

