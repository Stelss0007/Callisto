<?php
class html_block extends Block
  {
  function display(&$blockinfo)
    {
    $content = unserialize($blockinfo->content);
    $content = $content['content'];
    $this->assign('content', $content);
    return $this->view();
    }
    
  function modify(&$blockinfo)
    {
    $content = unserialize($blockinfo->content);
    $content = $content['content'];
    $this->assign('content', $content);
    
    return $this->view();
    }
    
  function update(&$blockinfo)
    {
    $this->setBlockContent('content', $this->input_vars['content']);
    $this->save($blockinfo->id);
    }
  }