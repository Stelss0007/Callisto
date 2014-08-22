<?php
class AdminController extends Controller
  {
  public $defaultAction = 'icons';
  function actionIcons()
    {
    $this->getAccess(ACCESS_ADMIN);
    $this->viewPage();
    }
  }

