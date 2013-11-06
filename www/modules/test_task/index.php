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
    app_utf8_cp1251($data);
    $this->assign($data);
    $this->viewPage();
    }
    
  function save_data()
    {
    $data= $this->input_vars;
    $this->test_task->$data['element_name'] = $data['element_value'];
    $this->test_task->update_time = time();
    $this->test_task->save($data['element_id']);
    $id = $data['element_id'];
    $data = $this->test_task->getById($id);
    appVarSetCached('test_task', 'time.'.$id, $data);
    }
    
//  function get_data()
//    {
//    $data= $this->input_vars;
//    
////    @ini_set('zlib.output_compression',0);
////    @ini_set('implicit_flush',1);
////    ob_implicit_flush(1);
////    set_time_limit(60);
////    ob_end_flush();
////    ob_start();     
//   
//    for($i=0; $i<30; $i++)
//      {
//      $db = appVarGetCached('test_task', 'time.'.$data['element_id']);
//       
//      if($db['update_time'] == $data['update_time'])
//        {
//        sleep(1);
//        continue;
//        }
//      $execute = '';//'$("#field_1").val("0000000000");$("#field_2").val("0000000000");';
//      foreach($db as $key=>$value)
//        {
//        $execute .= '$("#'.$key.'").val("'.$value.'");';
//        }
//      echo $execute;
//      ob_flush();
//      flush();
//      
//      sleep(1);
//      }
//    }
  function get_data()
    {
    $data= $this->input_vars;
    $db = appVarGetCached('test_task', 'time.'.$data['element_id']);
       
    if($db['update_time'] == $data['update_time'])
      {
      exit;
      }
    $execute = '';
    foreach($db as $key=>$value)
      {
//      $execute .= '$("#'.$key.'").val("'.$value.'");';
      $execute .= 'updateField("'.$key.'", "'.$value.'");';
      }
    echo $execute;
    }
  }
?>