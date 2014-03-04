<!doctype html>
<html>
  <head>
    <title>YouTube Uploads Using CORS</title>
    {literal}
    <style type="text/css">
      body {
        font-family: Helvetica, sans;
      }

      #upload-form {
        display: none;
      }

      #login-button {
        display: none;
      }

      label {
        display: block;
      }

      form > div {
        margin-bottom: 10px;
      }

      .wide {
        width: 250px;
      }
    </style>
    <script type="text/javascript">
      // See https://developers.google.com/youtube/2.0/developers_guide_protocol#Developer_Key
      var YT_DEVELOPER_KEY = 'AI39si5mwSg8AxZSqXrBkdesNkAjL355kMTZ3FSUgZou6BbPJB5FwA_pr8NbgLvrKX6Tc-Fb207TpOZfgcFKWADS3fDBF8NcUg';
      var YT_OAUTH2_SCOPE = 'https://gdata.youtube.com';
      var OAUTH2_CLIENT_ID = '698320483112-a262nb4rl15008safll6pjk0qfvv8q8b.apps.googleusercontent.com';
      var OAUTH2_TOKEN_TYPE = 'Bearer';

      // This is called when the JavaScript OAuth 2 library is ready.
      function onAuthReady() {
        if ('withCredentials' in new XMLHttpRequest()) {
          var matches = window.location.href.match(/status=(\d{3})/);
          if (matches) {
            // If the URL has a status= URL parameter, then the upload is complete and we've been redirected back to this page.
            if (matches[1] == 200) {
              // The status will be 200 for a successful upload. We can grab the new video's id from the id= URL parameter.
              var videoId = (window.location.href.match(/id=(.{11})/))[1];
              var videoUrl = 'http://youtu.be/' + videoId;
              showMessage('Sucess! You can find your new video at <a href="' + videoUrl + '">' + videoUrl + '</a>');
            } else {
              // The upload could have failed for a number of reasons.
              // See https://developers.google.com/youtube/2.0/reference#Response_codes_uploading_videos
              var code = (window.location.href.match(/code=(\w+)/))[1];
              showMessage('Your upload failed: ' + code);
            }
          } else {
            // Otherwise, this is a new upload attempt and we should attempt auth and display the upload form.
            attemptAuth();
          }
        } else {
          // If the browser doesn't support CORS then bail.
          showMessage('Your browser does not <a href="http://caniuse.com/cors">support CORS</a>.');
        }
      }

      // First, try to use "immediate" mode OAuth 2.
      // If the user has previously authorized this OAuth 2 client id for this scope,
      // this "immediate" attempt will be silently approved without user interaction.
      function attemptAuth() {
        gapi.auth.init(function() {
          setTimeout(function() {
            gapi.auth.authorize({
              client_id: OAUTH2_CLIENT_ID,
              scope: [ YT_OAUTH2_SCOPE ],
              immediate: true
            }, handleAuthResult);
          }, 1);
        });
      }

      // Deal with either a successful auth or a failed attempt.
      function handleAuthResult(authResult) {
        if (authResult) {
          // If we have a valid auth token, then proceed.
          prepareUploadForm();
        } else {
          alert('www');
          // Otherwise, set things up so that the OAuth 2 flow is started when the user clicks the Auth button.
          $('.share-youtube').unbind('click').click(function() {
            gapi.auth.authorize({
              client_id: OAUTH2_CLIENT_ID,
              scope: [ YT_OAUTH2_SCOPE ],
              immediate: false
            }, handleAuthResult);
          });
          //$('.share-youtube').unbind('click');
        }
      }

      // Helper method to set up all the required headers for making authorized calls to the YouTube API.
      function generateYouTubeApiHeaders() {
        return {
          Authorization: OAUTH2_TOKEN_TYPE + ' ' + gapi.auth.getToken().access_token,
          'GData-Version': 2,
          'X-GData-Key': 'key=' + YT_DEVELOPER_KEY,
          'X-GData-Client': 'CORS Upload Demo'
        };
      }

      // Some basic XML entity escaping. Not meant to be comprehensive.
      function escapeXmlEntities(input) {
        if (input) {
          return input.replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/"/g, '&quot;');
        } else {
          return '';
        }
      }

      // Set the message element's content to tell the user something.
      function showMessage(message) {
        $('#message').html(message);
      }

      // Fetches the YouTube profile of the currently auth'ed account, and populates the display name field in the form.
      function getDisplayName() {
        $.ajax({
          // Other examples deal with XML data, but if you use alt=json|jsonc, you can get JSON data back too.
          dataType: 'json',
          type: 'GET',
          url: 'https://gdata.youtube.com/feeds/api/users/default?alt=json',
          headers: generateYouTubeApiHeaders(),
          success: function(responseJson) {
            var displayName = responseJson['entry']['yt$username']['display'];
            $('#display-name').text(displayName);
          },
          error: function(jqXHR) {
            showMessage('Unable to get display name: ' + jqXHR.responseText);
          }
        });
      }

      function uploadServerToServer(yt_upload_url, token, upload_url){
        $.ajax({
          type: 'POST',
          url: upload_url,
          data: {yt_upload_url: yt_upload_url, yt_upload_token: token},
          success: function(responseData) {
            alert(responseData);
          }
        });
      }
      
      // Wire up all the necessary logic to get the upload form working.
      function prepareUploadForm() {
      
        $('.share-youtube').click(function() {
          
          var $this = $(this),
            title = escapeXmlEntities($this.attr('data-title')),
            description = escapeXmlEntities($this.attr('data-description')),
            category = 'Film',
            upload_url = escapeXmlEntities($this.attr('data-upload-url'))
          ;

          var xmlBody = '<?xml version="1.0"?> <entry xmlns="http://www.w3.org/2005/Atom" xmlns:media="http://search.yahoo.com/mrss/" xmlns:yt="http://gdata.youtube.com/schemas/2007"> <media:group> <media:title type="plain">' + title + '</media:title> <media:description type="plain">' + description + '</media:description> <media:category scheme="http://gdata.youtube.com/schemas/2007/categories.cat">' + category + '</media:category> </media:group> </entry>';

          $.ajax({
            dataType: 'xml',
            type: 'POST',
            url: 'https://gdata.youtube.com/action/GetUploadToken',
            contentType: 'application/atom+xml; charset=UTF-8',
            headers: generateYouTubeApiHeaders(),
            processData: false,
            data: xmlBody,
            success: function(responseXml) {
              var xml = $(responseXml);
              // After the upload, we'll redirect back to the same page.
              var nextUrl = window.location.href;
              // The response to this API call will contain a unique URL that we will POST the form to.
              var submissionUrl = xml.find('url').text() + '?nexturl=' + encodeURIComponent(nextUrl);
              // The response also contains a unique token value that needs to be included in the form POST request.
              var token = xml.find('token').text();

              uploadServerToServer(submissionUrl, token, upload_url);
            },
            error: function(jqXHR) {
              showMessage('Metadata submission failed: ' + jqXHR.responseText);
            }
          });
        });

      }
    </script>
    <script type="text/javascript" src="https://apis.google.com/js/client.js?onload=onAuthReady"></script>
    <script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
    {/literal}
  </head>
  <body>
    <h1>Share File</h1>
    <div id="upload-container">
      <input type="button" class="share-youtube" data-title="my title" data-description="my description" data-upload-url="http://callisto.com/test/youtube_upload" value="Share Youtube"/>
    </div>
    {literal}
    <script>
    </script>
    {/literal}
  </body>
</html>