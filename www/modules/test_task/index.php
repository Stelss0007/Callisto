<?php
class Index extends Controller
  {
  public $defaultAction = 'test_form';
  
  function test_form($id)
    {
    if(empty($id))
      {
      $id = $this->test_task->save();
      $this->redirect("/test_task/test_form/$id");
      }
    $data = $this->test_task->getById($id);
    $this->assign($data);
    $this->viewPage();
    }
    
  function save_data()
    {
    $data= $this->input_vars;
    $this->test_task->$data['element_name'] = $data['element_value'];
    $this->test_task->update_time = time();
    $this->test_task->save($data['element_id']);
    
    $data = $this->test_task->getById($data['element_id']);
    appVarSetCached('test_task', 'time', $data);
    }
    
  function get_data()
    {
    header("Content-Type: text/event-stream\n\n");
    @ini_set('zlib.output_compression',0);
    @ini_set('implicit_flush',1);
    set_time_limit(60);
    $data= $this->input_vars;
    
    ob_end_flush();
    ob_start();
    
    for($i=0; $i<5; $i++)
      {
      $db = appVarGetCached('test_task', 'time');
      
      echo json_encode($db);
      echo str_repeat( ' ', 1024);
      ob_flush();
      flush();
      
      sleep(2);
      }
    }
  }
?>