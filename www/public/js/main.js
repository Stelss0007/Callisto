//$.getScript("/public/js/lang/rus.js");

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
    var close_btn = '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>';
    if(message)
      {
      $('#appMessage_msg_text').html(message + close_btn).attr('class', 'alert alert-'+$('#appMessageType').val());
      }
    else
      {
      $('#appMessage_msg_text').html($('#appMessageText').val()+close_btn).attr('class', 'alert alert-'+$('#appMessageType').val());
      }
    //$('#appMessage_conteiner').show();
    $('#appMessage_conteiner').show().delay(5000).fadeOut(400, function(){$('#appMessage_conteiner').hide()});
    //$('#appMessage_conteiner').stop().fadeIn(400, function(){$('#appMessage_conteiner').show().delay(5000).fadeOut(400, function(){$('#appMessage_conteiner').hide()});});
    //$('#appMessage_conteiner').stop().fadeIn(400).show().delay(5000).stop().animate({"opacity": "0"}, "slow", function(){$(this).hide()});
    //$('#appMessage_conteiner').stop().show().animate({"opacity": "1"}, "fast").delay(3000).stop();

    $('#appMessage_msg_text').on('click', function() {
        $('#appMessage_conteiner').stop().fadeOut("fast", function(){$(this).hide()});
        //$('#appMessage_conteiner').stop().animate({"opacity": "0"}, "fast", function(){$(this).hide()});
     });
    //$('#appMessage_').remove();
    }

  }

$('document').ready(function(){
  if (!$("#appMessage_conteiner").length) {
    $('body').prepend("<div id='appMessage_conteiner'><div class='alert alert-warning alert-dismissible' role='alert' id='appMessage_msg_text'></div></div>");
  }
  $('#appMessage_msg_text, #appMessage_msg_text .close').on('click', function() {
     $('#appMessage_conteiner').stop().fadeOut("fast");
     //$('#appMessage_conteiner').stop().animate({"opacity": "0"}, "fast");
     return false;
  });
  showAppMessage();


    //file manager
    if(jQuery().elfinder) {
        var screenHeight = $(window).height();
        var contentHeight = $('.main-content').height();

        var delta = contentHeight ;

        var fileManagerHeight = screenHeight - delta - 40;

        var elf = $('.file-manager').elfinder({
            url : '/admin/files/get_list',  // connector URL (REQUIRED),
            lang : 'ru',
            height: fileManagerHeight
        }).elfinder('instance');

//        $(window).resize(function(){
//            var screenHeight = $(window).height();
//
//            var fileManagerHeight = screenHeight - delta - 40;
//
//            if( elf.options.height != fileManagerHeight ){
//                  elf.resize('auto', fileManagerHeight);
//            }
//         });
    }


    $(window).scroll(function () {
        if ($(this).scrollTop() > 100) {
            $('.scrollup').fadeIn();
        } else {
            $('.scrollup').fadeOut();
        }
    });

    $('.scrollup').click(function () {
        $("html, body").animate({
            scrollTop: 0
        }, 600);
        return false;
    });
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
