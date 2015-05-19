<div class="row-fluid">
  <div class="box span12">
    <div class="box-header well" data-original-title>
      <h2><i class="icon-picture"></i> File Manager</h2>
    </div>
    <div class="box-content">
      <div class="file-manager"></div>
    </div>
  </div><!--/span-->

</div><!--/row-->

{literal}
    <script>
        $('document').ready(function(){
            $(".file-manager").css('opacity', '0');
            
            var screenHeight = $(window).height();
            var contentHeight = $('.main-content').height();
            var fileManagerHeight = $('.file-manager').height();
           
            var delta = contentHeight - fileManagerHeight;
            
            fileManagerHeight = screenHeight - delta - 40;
            
            /*$(".file-manager").animate({ 
                height: fileManagerHeight+'px',
                opacity: 1
            }, 200);*/
            $('.file-manager').height(fileManagerHeight+'px');
            $(".file-manager").css('opacity', '1');
            
        });
    </script>
{/literal}