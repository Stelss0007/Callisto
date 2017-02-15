<?php

class IndexController extends Controller
{
    public function __construct($mod)
    {
        parent::__construct($mod);

        $this->setTheme('install');
    }

    public function actionIndex()
    {
        $this->viewPage();
    }
}