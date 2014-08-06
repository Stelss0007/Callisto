$(document).ready(function(){
  $('body').append('<div id="dialog-box" title="&nbsp;"></div>');
  
  var dialog = $('#dialog-box').dialog({
                  autoOpen: false,
                  width: 550,
                  modal: true
                });
    
    
  //admin blocks sortable
  $(".block-item-admin-panel").parent().sortable({
      //connectWith: ".column",
      handle: ".block-toolbar",
      cancel: ".portlet-toggle",
      placeholder: "block-placeholder ui-corner-all",
      start: function(e, ui){
        ui.placeholder.height(ui.item.height());
      },
      update: function (event, ui) {
                //db id of the item sorted
                var position_block = ui.item.attr('data-position');
                var positionOld = ui.item.attr('data-weight');
                var positionNew = ui.item.index() + 1;
                var id = ui.item.attr('data-id');
                
alert(positionOld);
alert(positionNew);

                $.ajax('/admin/blocks/weightSet/'+id+'/'+positionOld+'/'+positionNew+'/'+position_block, {
                    cache: false,
                    success: function(html){
                      alert(html);
                    }
                 });

                ui.item.attr('data-weight', positionNew);
                //make ajax call
            }
    });
   
   $('.block-edit').click(function(){
     
     $.ajax($(this).attr('href'), {
        cache: false,
        success: function(html){
          $('#dialog-box').html(html);
          dialog.dialog('open');
        }
     });
     
     return false;
   });
   
   $('.block-delete').click(function(){
     //alert ('2222');
     confirm(message.app_confirm_delete);
   });
});
