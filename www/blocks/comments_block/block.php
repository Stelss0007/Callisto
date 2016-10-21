<?php
use app\modules\comments\models\Comments;

class comments_block extends Block
  {
  function display(&$blockinfo)
    {
    //$this->viewCached();
    $config = unserialize(stripcslashes($blockinfo->content));
    //$this->usesModel('comments');
    //appDebugExit($blockinfo); 
    $this->assign('module_object', $blockinfo->module_object);
    $this->assign('module_name', $blockinfo->module_name);
    
    $commentList = Comments::find()
                    ->where(['comment_module_object' => $blockinfo->module_object])
                    ->orderBy(['comment_addtime' => 'asc'])
                    ->with('all')
                    ->all()
                   ;

    $this->assign('commentList', $commentList);

    return $this->view();
    }
    
  function modify(&$blockinfo)
    {
    //$this->usesModel('comments');
    //$this->assign('toolbar', $this->getBlockContent('toolbar', array()));
    //$this->menutypes_list = array (1=>'Всегда развернуто',2=>'Разварачиваюшееся');
    return $this->view();
    }
    
  function update(&$blockinfo)
    {
    //echo $blockinfo['id'].' ';print_r($_REQUEST);exit;
    //echo $this->toolbar;exit;
    $this->setBlockContent('toolbar', $this->input_vars['toolbar']);
    $this->save($blockinfo->id);
    }
  }