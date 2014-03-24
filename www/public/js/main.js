/*
 * Autosave form function
 * Example:
 * 
 * //Автосохраняемся, после окончания ввода
 *   $('#modify_diary input, #modify_diary textarea').autoSave(function($element){
 *     $.post("/memorials/modify_diary_autosave", $( "#modify_diary" ).serialize());
 *   }, 2000);
 *
 */
//(function($) {
//    $.fn.autoSave = function(callback, ms) {
//        return this.each(function() {
//            var timer = 0, 
//                $this = $(this),
//                delay = ms || 1000;
//            $this.keyup(function() {
//                clearTimeout(timer);
//                var $context = $this.val();
//                if(localStorage) {
//                    localStorage.setItem("autoSave", $context);
//                }
//                timer = setTimeout(function() {
//                    callback($this);
//                }, delay);
//            });
//        });
//    };
//})(jQuery);

function showAppMessage(message)
  {
  if($('#appMessage_').html() || message)
    {
    var close_btn = '<button data-dismiss="alert" class="close" type="button">x</button>'; 
    if(message) 
      {
      $('#appMessage_msg_text').html($('#appMessageText').val()+close_btn).attr('class', 'alert alert-'+$('#appMessageType').val());
      }
    else
      {
      $('#appMessage_msg_text').html($('#appMessageText').val()+close_btn).attr('class', 'alert alert-'+$('#appMessageType').val());
      }
    
    $('#appMessage_conteiner').stop().show().animate({"opacity": "1"}, "fast").delay(3000).stop().animate({"opacity": "0"}, "slow", function(){$(this).hide()});
    $('#appMessage_msg_text').on('click', function() {
        $('#appMessage_conteiner').stop().animate({"opacity": "0"}, "fast");
     });
    //$('#appMessage_').remove();
    }
  
  }

$('document').ready(function(){
  $('body').prepend("<div id='appMessage_conteiner'><div class='alert alert-success' id='appMessage_msg_text'></div></div>");
  $('#appMessage_msg_text').on('click', function() {
     $('#appMessage_conteiner').stop().animate({"opacity": "0"}, "fast");
  });
  showAppMessage();
});


// $(window).ready(function(){
//    var hasChanged =1;  
//    $(window).bind("beforeunload",function(event) {
//        if(hasChanged) return "You have unsaved changes";
//    });
//    
//    window.onblur = function () {document.title='документ неактивен'}
//    window.onunload = function () {return "1111";}
// });