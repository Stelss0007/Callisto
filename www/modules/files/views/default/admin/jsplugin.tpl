<!DOCTYPE html>
<html>
  <head>
    {literal}
      <meta charset="utf-8">
      <title></title>

      <!-- jQuery and jQuery UI (REQUIRED) -->
      <link rel="stylesheet" type="text/css" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.23/themes/smoothness/jquery-ui.css">
      <script src="/public/js/jQuery/jQuery.js"></script>
      <script src="/public/js/jQueryUI/jQueryUI.js"></script>

      <!-- elFinder CSS (REQUIRED) -->
      <link href='/themes/admin/css/elfinder.min.css' rel='stylesheet'>
      <link href='/themes/admin/css/elfinder.theme.css' rel='stylesheet'>
      <!-- elFinder JS (REQUIRED) -->
      <script src="/themes/admin/js/jquery.elfinder.min.js"></script>
      <!-- elFinder translation (OPTIONAL) -->
      <script charset="UTF-8" src="/themes/admin/js/lang/elfinder/elfinder.ru.js"></script>

      <!-- elFinder initialization (REQUIRED) -->
      <script type="text/javascript" charset="utf-8">
        var FileBrowserDialogue = {
          init: function() {
            // Here goes your code for setting your custom things onLoad.
          },
          mySubmit: function(URL) {
            // pass selected file path to TinyMCE
            parent.tinymce.activeEditor.windowManager.getParams().setUrl(URL);
            // force the TinyMCE dialog to refresh and fill in the image dimensions
            var t = parent.tinymce.activeEditor.windowManager.windows[0];
            t.find('#src').fire('change');
            // close popup window
            parent.tinymce.activeEditor.windowManager.close();
          }
        };


        // Documentation for client options:
        // https://github.com/Studio-42/elFinder/wiki/Client-configuration-options
        $(document).ready(function() {
          var elf = $('.file-manager').elfinder({
            url: '/admin/files/get_list', // connector URL (REQUIRED),
            lang: 'ru',
            getFileCallback: function(file) { // editor callback
              FileBrowserDialogue.mySubmit(file); // pass selected file path to TinyMCE 
            }
          }).elfinder('instance');



        });
      {/literal}
    </script>
  </head>
  <body>
    <!-- Element where elFinder will be created (REQUIRED) -->
    <div class="file-manager"></div>
  </body>
</html>