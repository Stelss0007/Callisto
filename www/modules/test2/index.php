<?php
class IndexController extends Controller
  {
  function view_list()
    {
    $this->type = 'user';
    $this->view();
    }

  function view_list1()
    {
    $_SESSION['user_gid'] = 1;
    $this->smarty->caching = true;
    $this->type = 'admin';
    $this->getAccess(ACCESS_ADMIN);
    $this->a = 'Hello World';
    $this->b = 'Hello World2';
    
    $this->blockAdd('left', array('block_displayname'=>'Block From Code1', 'block_content'=>'hello block1'));
    $this->blockAdd('left', array('block_displayname'=>'Block From Code2', 'block_content'=>'hello block2'));
    $this->blockAdd('left', array('block_displayname'=>'Block From Code3', 'block_content'=>'hello block3'));
    
    $this->blockAdd('right', array('block_displayname'=>'Block From Code4', 'block_content'=>'hello block4'));
    $this->blockAdd('right', array('block_displayname'=>'Block From Code5', 'block_content'=>'hello block5'));
    $this->blockAdd('bottom', array('block_displayname'=>'Block From Code6', 'block_content'=>'hello block6'));
    //$this->print_vars();
    $this->viewPage();
    }

  function view_arg($a='1', $b=2, $c=4, $n='0')
    {
    echo $this->test2->sum(6,8);
    echo $a.$b.$c.$n;
    }
  }
?>
