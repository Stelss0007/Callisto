<?php
class Index extends Controller
  {
  function view_list()
    {
    $this->errors->setError("Index not Exist!!!");
    $this->type = 'user';
    $this->view();
    }

  function view_list1()
    {
    $_SESSION['user_gid'] = 1;
    $this->smarty->caching = true;
    $this->type = 'admin';
    //$this->getAccess(ACCESS_ADMIN);
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
    //echo $this->test->sum(6,8);
    
    $this->test->arg1 = 1;
    $this->test->arg2 = 2;
    $this->test->save();
    
    $this->modelInit('test2');
    //echo $this->test2->getName($a);
            
    //echo $a.$b.$c.$n;
    }
    
  function view_object($guid=0)
    {
    print_r($this->test->getObject($guid));
    }
  
  function view_objects($offset=0)
    {
    print_r($this->test->getObjectsList(array('arg1'=>'1'), array('arg2'=>'asc'), $offset));
    }
    
  function delete_object($id=0)
    {
    $this->test->deleteObject($id);
    }
    
  function update_object($a='1', $b=2, $c=4, $n='0')
    {
    //echo $this->test->sum(6,8);
    
    $this->test->arg2 = 55;
    $this->test->save(7);
    
    $this->modelInit('test2');
    //echo $this->test2->getName($a);
            
    //echo $a.$b.$c.$n;
    }
  function test_bug($a)
    {
    $this->a = $a;
    $this->c = 45;
    $this->help = "hhjsdahfjsdhjfhsjdhfjhfjhasjhfjshdgjhsdf";
    $this->viewPage();
    //$this->session->setVar('rus', 'hello');
    
    echo $this->session->getVar('rus', '22');
    }
  }
?>
