<?php
class html_block extends Block
  {
  function display(&$blockinfo)
    {
    return $this->view();
    }
    
  function modify(&$blockinfo)
    {
    return $this->view();
    }
    
  function update(&$blockinfo)
    {
    $this->setBlockContent('content', $this->input_vars['content']);
    $this->save($blockinfo['id']);
    }
  }