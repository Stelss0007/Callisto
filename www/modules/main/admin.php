<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of admin
 *
 * @author Your Name <your.name at your.org>
 */
class AdminController extends Controller
  {
  function actionIndex()
    {
    $browsein[] =array('url'=>"/admin/main", 'displayname'=>  $this->t('dashboard'));
    $this->assign('module_browsein', $browsein);
    
    $this->viewPage();
    }
  }

