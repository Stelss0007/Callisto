/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
;(function ($, window, undefined) {
  $(document).ready(function(){
      $('#myTab').tab();
      
      $(".switch").bootstrapSwitch({
            size: 'mini'
        });
      
      //group checkbox
      $(".td_entiies_group").on('click', function(){
        if($(this).attr('checked') == 'checked') {
          $(this).closest('table').find('.td_entities').prop('checked', true);
          $(this).closest('table').find('.td_entities').parent().addClass('checked');
          $(this).closest('table').find("tr").toggleClass("highlight", this.checked);
        }
        else {
          $(this).closest('table').find('.td_entities').prop('checked', false);
          $(this).closest('table').find('.td_entities').parent().removeClass('checked');
          $(this).closest('table').find("tr").toggleClass("highlight", this.checked);
        }
      });
      
      $(":checkbox").change(function() {
            $(this).closest("tr").toggleClass("highlight", this.checked);
       });
      
      //list panel
      $(".btn-toolbar a").on('click', function(event){
        var $this = $(this),
          confirm_result = false,
          message = '',
          selected_item_count = $('.td_entities:checked').length
        ; 

        if($this.hasClass('disabled'))
            {
            return false;
            }

        if($this.attr('href') == '#') {
          if(selected_item_count < 1){
             bootbox.alert(sys_confirm_group_not_selected);
          return false;
          }

          event.preventDefault();
          switch($this.attr('rel')){
            case 'delete':
              message += sys_confirm_group_delete
              break;
            case 'activate':
              message += sys_confirm_group_activate
              break;
            case 'deactivate':
              message += sys_confirm_group_deactivate
              break;
            case 'install':
              message += sys_confirm_group_install
              break;
            default:
              message += sys_confirm
          }
          bootbox.confirm(message, function(result) {
            if(result) {
              var form = $this.closest('form')
                data = form.serializeArray();
              ;
              data.push({name: 'action_name', value: $this.attr('rel')});
              $.post(form.attr('action'), data)
                .done(function(data) {
                  //alert( "ok" );
                  location.reload();
                })
                .fail(function() {
                  alert( "error" );
                });
            }

          });

        }
      });

      $('a.btn-delete, a.delete').on('click', function(event){
        event.preventDefault();
        var $this = $(this);
        bootbox.confirm(sys_confirm_delete, function(result) {
          if(result)
            {
            window.location.href = $this.attr('href');
            }
        });
      });

      $('.app-filter select').on('change', function(){
        $(this).closest('form').submit();
      });
      
      //hide/show body contrnt (opacity)
//      window.onbeforeunload = function(){
//        $('.page-container').removeClass('body-show').addClass('body-hide');
//      };
      $('.page-container').removeClass('body-hide').addClass('body-show');
  }); 
  
})(jQuery, window);



