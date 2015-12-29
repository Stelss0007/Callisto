$(document).ready(function(){
  sortable();

  $('body').append('<div id="dialog-box" title="&nbsp;"></div>');
  
  var dialog = $('#dialog-box').dialog({
                  autoOpen: false,
                  position: { my: "center top", at: "center top"},
                  width: 750,
                  modal: true
                });
                
   var lastSortableReady = '';
   
   var blockPositionsKey = [];
   blockPositionsKey['left']    = 'l';
   blockPositionsKey['right']   = 'r';
   blockPositionsKey['top']     = 't';
   blockPositionsKey['bottom']  = 'b';
   blockPositionsKey['center']  = 'c';

    
  //admin blocks sortable
  function sortable() {
    //$(".block-item-admin-panel").parent()
    $("*[data-block-list-position]")
    .sortable({
        //connectWith: ".column",
        handle: ".block-toolbar",
        cancel: ".portlet-toggle",
        placeholder: "block-placeholder ui-corner-all",
        items: '.block-item-admin-panel',
        revert: true,
        connectWith: ".ui-sortable",
        start: function(e, ui){
          ui.placeholder.height(ui.item.height());
        },
        receive: function(evt, ui) {
//          ui.item.remove();
//          dragable();
        },
        update: function (event, ui) {
                  //db id of the item sorted
                  var position_block = ui.item.attr('data-position');
                  var positionOld = ui.item.attr('data-weight');
                  var positionNew = ui.item.index() + 1;
                  var id = ui.item.attr('data-id');
                  var newPosition = ui.item.parent().attr('data-block-list-position');
                  var newPositionKey = blockPositionsKey[newPosition];
                  
                  if(lastSortableReady === id+'/'+positionOld+'/'+positionNew+'/'+newPositionKey) {
                      return true;
                  }
                  
                  lastSortableReady = id+'/'+positionOld+'/'+positionNew+'/'+newPositionKey;
                  
                  $.ajax('/admin/blocks/weightSet/'+id+'/'+positionOld+'/'+positionNew+'/'+newPositionKey, {
                      cache: false,
                      success: function(html){
                        showAppMessage(html);
                      }
                   });

                  $(".block-item-admin-panel").each(function(){
                    var $this = $(this);
                    $this.attr('data-weight', $this.index() + 1);
                  });


                  //Преобразования вида блока
                  var blockContainer = ui.item.find('.app-block-admin-conteiner');
                  var blockContent   = blockContainer.find('.app-block-content');
                  var blockTitle     = blockContainer.find('.app-block-name');
                  
                  blockContent = blockContent.is('input') ? blockContent.val() : blockContent.html();
                  blockTitle   = blockTitle.is('input') ? blockTitle.val() : blockTitle.html();
                  
                  var newTemplate =  ui.item.parent().find('.app-block-template').clone();
                  
                  var templateBlockTitle = newTemplate.find('.app-block-name');
                  var templateBlockContent = newTemplate.find('.app-block-content');
                  
                  if(templateBlockTitle.is('input'))
                    {
                    templateBlockTitle.val(blockTitle); 
                    }
                  else
                    {
                    templateBlockTitle.html(blockTitle); 
                    }
                    
                  if(templateBlockContent.is('input'))
                    {
                    templateBlockContent.val(blockContent); 
                    }
                  else
                    {
                    templateBlockContent.html(blockContent); 
                    }
                  
                  blockContainer.html(newTemplate.html());
                  
                  ui.item.attr('data-weight', positionNew);
                  //make ajax call
              }
      });
  }

   
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
