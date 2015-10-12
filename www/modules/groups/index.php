<?php
class IndexController extends Controller
  {
  public $defaultAction = 'groups_list';
  
  function actionGroupsList()
    {
    $this->redirect('/admin/groups');
    }
  }

