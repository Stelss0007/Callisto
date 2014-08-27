$(document).ready(function(){
  $('body').append('<div id="dialog-box" title="&nbsp;"></div>');
  
  var dialog = $('#dialog-box').dialog({
                  autoOpen: false,
                  position: { my: "center top", at: "center top"},
                  width: 750,
                  modal: true
                });
    
    
  //admin blocks sortable
  $(".block-item-admin-panel").parent().sortable({
      //connectWith: ".column",
      handle: ".block-toolbar",
      cancel: ".portlet-toggle",
      placeholder: "block-placeholder ui-corner-all",
      items: '.block-item-admin-panel',
      start: function(e, ui){
        ui.placeholder.height(ui.item.height());
      },
      update: function (event, ui) {
                //db id of the item sorted
                var position_block = ui.item.attr('data-position');
                var positionOld = ui.item.attr('data-weight');
                var positionNew = ui.item.index() + 1;
                var id = ui.item.attr('data-id');

                $.ajax('/admin/blocks/weightSet/'+id+'/'+positionOld+'/'+positionNew+'/'+position_block, {
                    cache: false,
                    success: function(html){
                      showAppMessage(html);
                    }
                 });
                 
                $(".block-item-admin-panel").each(function(){
                  var $this = $(this);
                  $this.attr('data-weight', $this.index() + 1);
                });
                
                ui.item.attr('data-weight', positionNew);
                //make ajax call
            }
    });
   
   $('.block-edit').click(function(){
     
     $.ajax($(this).attr('href'), {
        cache: false,
         beforeSend: function(){
            $('#dialog-box').html('<div style="margin: 20px auto; text-align: center;"><img id="imgcode" src="/public/images/system/preloader/preloader1.gif"></div>');
            dialog.dialog('open');
        },
        success: function(html){
          $('#dialog-box').html(html);
        }
     });
     
     return false;
   });
   
   $('.block-delete').click(function(){
     return confirm(message.app_confirm_delete);
   });
   
   $(window).keypress(function(event) {
      if ((event.which == 115 && event.ctrlKey))
        {
        $("form input[name=submit]").click();
        $("form button[name=submit]").click();
        event.preventDefault();
        }
      return true;
    });
});


//$(window).load(function(){loadPlugins()});


function loadPlugins()
  {
  if(typeof tinyMCE == "undefined") 
    {
      $.getScript('/public/js/tinymce/tinymce.js', function() {
      tinyMCE.init();
      });
    }
  
  }
