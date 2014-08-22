<?php

class AdminController extends Controller
  {

  public $defaultAction = 'fileList';

  function actionFileList()
    {
    $this->getAccess(ACCESS_ADMIN);
    
    $browsein   = array();
    $browsein[] = array('url' => "/admin/main", 'displayname' => $this->t('dashboard'));
    $browsein[] = array('url' => '', 'displayname' => 'Files');

    $this->module_browsein = $browsein;

    $this->viewPage();
    }

  function actionGetList()
    {
    $this->getAccess(ACCESS_ADMIN);
    
    $opts = array(
        //'debug' => true,
        'roots' => array(
            array(
                'driver' => 'LocalFileSystem', // driver for accessing file system (REQUIRED)
                'path' => 'public/files/', // path to files (REQUIRED)
//                'URL' => dirname($_SERVER['PHP_SELF']) . 'public/', // URL to files (REQUIRED)
                'URL' => '/public/files/', // URL to files (REQUIRED)
                //'accessControl' => 'access', // disable and hide dot starting files (OPTIONAL)
                'attributes' => array(
                    array(
                        'pattern' => '/./', //You can also set permissions for file types by adding, for example, .jpg inside pattern.
                        'read' => true,
                        'write' => true,
                        'locked' => false
                    )
                )
            )
        )
    );
    $this->usesLib('ElFinder');
    // run elFinder
    $connector = new elFinderConnector(new elFinder($opts));
    $connector->run();
    }

  }

