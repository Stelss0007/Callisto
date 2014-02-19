<?php
class IndexController extends Controller
  {
  public $defaultAction = 'config_main';
  
  public function config_main()
    {
    $timeformat_list['g:i a'] = date("g:i a", time());
    $timeformat_list['g:i:s a'] = date("g:i:s a", time());
    $timeformat_list['H:i'] = date("H:i", time());
    $timeformat_list['H:i:s'] = date("H:i:s", time());
    
    $dateformat_list['Y-m-d'] = date("Y-m-d", time());
    $dateformat_list['d-m-Y'] = date("d-m-Y", time());
    $dateformat_list['d/m/Y'] = date("d/m/Y", time());
    $dateformat_list['m/d/Y'] = date("m/d/Y", time());
    $dateformat_list['d.m.Y'] = date("d.m.Y", time());
    $dateformat_list['d.m.y'] = date("d.m.y", time());
    $dateformat_list['d M Y'] = date("d M Y", time());
    $dateformat_list['d F Y'] = date("d F Y", time());
    
    $this->assign('site_timeformat_list', $timeformat_list);
    $this->assign('site_dateformat_list', $dateformat_list);
    
    $this->assign($this->getModVars('kernel'));
    $this->viewPage();
    }
    
  public function config_update()
    {
    $vars = $this->getInput('config');
    foreach($vars as $key=>$value)
      {
      $this->setModVar('kernel', $key, $value);
      }
    $this->showMessage("Saved");
    $this->redirect($this->getInput('referer'));
    }
  }
?>
