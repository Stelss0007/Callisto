function getUpdate()
  {
  $.ajax({
          type: "GET",
          url: "/test_task/get_data",
          async: true, 
          cache: false,
          timeout:2880000, /* Timeout in ms set to 8 hours */
          //dataType: 'script',
          processData: false,
          onProgress:function(rsp){ //i know there is no such function like this
              $("body").append(rsp+"<br>");
            },
          success: function(data){ 
              $("body").append(data+"<br>"); 
              setTimeout(
              'getUpdate()', 
              3000 
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


