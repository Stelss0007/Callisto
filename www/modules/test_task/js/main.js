 var updater = null;
  
(function($) {
    $.fn.autoSave = function(callback, ms) {
        return this.each(function() {
            var timer = 0, 
                $this = $(this),
                delay = ms || 1000,
                tagType = $this.prop('tagName');
                
                if((tagType == 'INPUT' && ($this.attr('type') == 'text')) || tagType == 'TEXTAREA')
                  {
                  $this.keyup(function() {
                      clearTimeout(updater);
                      clearTimeout(timer);
                      var $context = $this.val();
                      if(localStorage) {
                          localStorage.setItem("autoSave", $context);
                      }
                      timer = setTimeout(function() {
                          callback($this);
                      }, delay);
                    });
                  }
                else 
                  {
                  $this.change(function() {callback($this);});
                  }

        });
    };
})(jQuery);

function updateField(id, value)
  {
  var $element = $(document.getElementsByName(id));
  $element.val(value);
 
  }

function getUpdate()
  {
  var element_id = $('#element_id').val();
  var update_time = $('#update_time').val();
  data = {element_id: element_id, update_time:update_time}
  
  $.ajax({
          type: "GET",
          url: "/test_task/get_data?element_id="+element_id+"&update_time="+update_time,
          async: true, 
          cache: false,
          timeout:2880000, /* Timeout in ms set to 8 hours */
          success: function(data){ 
              eval(data);
              updater = setTimeout(
                                  'getUpdate()', 
                                  1500 
                                  );
            }
          });
  }

$('document').ready(function(){
    $('#test_form input, #test_form select').autoSave(function($element){
          element_name  = $element.attr('name');
          element_value  = $element.val();
          element_id = $element.closest('form').find('#element_id').val();
          params = {
                    element_id:element_id, 
                    element_name:element_name, 
                    element_value:element_value
                    }
          $.post("/test_task/save_data", params, function(){getUpdate()});
      }, 1000);
 
   getUpdate();
});


