<!DOCTYPE html>
<html>
  <head>
    {literal}
      <meta charset="utf-8">
      <title>elFinder 2.0</title>

      <!-- jQuery and jQuery UI (REQUIRED) -->
      <link rel="stylesheet" type="text/css" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.23/themes/smoothness/jquery-ui.css">
      <script src="/public/js/jQuery/jQuery.js"></script>
      <script src="/public/js/jQueryUI/jQueryUI.js"></script>
      <script type="text/javascript" src="/public/js/tinymce/tiny_mce_popup.js"></script>

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
            var win = tinyMCEPopup.getWindowArg('window');

            // pass selected file path to TinyMCE
            win.document.getElementById(tinyMCEPopup.getWindowArg('input')).value = URL;

            // are we an image browser?
            if (typeof (win.ImageDialog) != 'undefined') {
              // update image dimensions
              if (win.ImageDialog.getImageData) {
                win.ImageDialog.getImageData();
              }
              // update preview if necessary
              if (win.ImageDialog.showPreviewImage) {
                win.ImageDialog.showPreviewImage(URL);
              }
            }
            // close popup window
            tinyMCEPopup.close();
          }
        }

        tinyMCEPopup.onInit.add(FileBrowserDialogue.init, FileBrowserDialogue);


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