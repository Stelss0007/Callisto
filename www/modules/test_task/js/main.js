function getUpdate()
  {
  var last_response_len = false;
  
  var element_id = $('#element_id').val();
  var update_time = '';
  data = {element_id: element_id, update_time:update_time}
  
  $.ajax({
          type: "GET",
          url: "/test_task/get_data?element_id="+element_id+"&update_time="+update_time,
          async: true, 
          cache: false,
          timeout:2880000, /* Timeout in ms set to 8 hours */
          //dataType: 'script',
          processData: false,
          //data: data,
          xhrFields: {
                onprogress: function(e)
                {
                    var this_response, response = e.currentTarget.response;
                    if(last_response_len === false)
                      {
                      this_response = response;
                      last_response_len = response.length;
                      }
                    else
                      {
                      this_response = response.substring(last_response_len);
                      last_response_len = response.length;
                      }
                    //$('.contentmain').append(this_response+'<br>');
                    if(this_response)
                      {
                      eval(this_response);
                      }
                    console.log(this_response);
                }
              },
          success: function(data){ 
              setTimeout(
              'getUpdate()', 
              1000 
              );
            }
          });
  }

$('document').ready(function(){
    $('#test_form input').autoSave(function($element){
          element_name  = $element.attr('name');
          element_value  = $element.val();
          element_id = $element.closest('form').find('#element_id').val();
          params = {
                    element_id:element_id, 
                    element_name:element_name, 
                    element_value:element_value
                    }
          $.post("/test_task/save_data", params);
      }, 2000);
      
      
   getUpdate();
});


