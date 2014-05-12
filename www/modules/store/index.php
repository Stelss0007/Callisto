<?php
class IndexController extends Controller
  {
  function actionIndex()
    {
    $this->redirect('/store/list/');
    }
  function actionList()
    {
    $this->viewPage();
    }
  }
