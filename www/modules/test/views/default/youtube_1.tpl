<span id="signinButton" class="pre-sign-in">
    <span
        class="g-signin"
        data-callback="oauth2Callback"
        data-clientid="698320483112-a262nb4rl15008safll6pjk0qfvv8q8b.apps.googleusercontent.com"
        data-cookiepolicy="single_host_origin"
        data-scope="https://www.googleapis.com/auth/youtube.readonly https://www.googleapis.com/auth/youtube.upload">
    </span>
</span>

    <div class="post-sign-in">
      <div id='yt-share-close'>X</div>
      <div>
        <img id="channel-thumbnail">
        <span id="channel-name"></span>
      </div>

      <form id="upload-form">
        <div class="yt-share-info-status">
        </div>
        <div class="yt-share-info-block">
          <div>
            <label for="title">Title:</label>
            <input id="title" type="text" value="Default Title">
          </div>
          <div>
            <label for="description">Description:</label>
            <textarea id="description">Default description.</textarea>
          </div>
        </div>
        
        <div class="during-upload">
          <p><span id="percent-transferred"></span>% done (<span id="bytes-transferred"></span>/<span id="total-bytes"></span> bytes)</p>
          <progress id="upload-progress" max="1" value="0"></progress>
        </div>
        
        <div class="post-upload">
          <p>Uploaded video with id <b><span id="video-id"></span></b>.</p>
          <div id="post-upload-status"></div>
          <div id="player"></div>
        </div>
        
        <div class="yt-share-btnGroup">
          <div>
            <input id="file" type="file">
          </div>
          <div>
            <input id="submit" type="submit" value="Upload">
          </div>
        </div>
        
        <div class="yt-share-btnOk-div">
          <input id="yt-share-ok" type="button" value="OK">
        </div>
        
      </form>

    </div>


<div id='file_content'></div>

<span class='st_sharethis_large' displayText='ShareThis'></span>
<span class='st_facebook_large' displayText='Facebook'></span>
<span class='st_twitter_large' displayText='Tweet'></span>
<span class='st_linkedin_large' displayText='LinkedIn'></span>
<span class='st_pinterest_large' displayText='Pinterest'></span>
<span class='st_email_large' displayText='Email'></span>
<span class='st_youtube_large' displayText='Youtube Subscribe'></span>

{literal} 
<script type="text/javascript">var switchTo5x=true;</script>
<script type="text/javascript" src="http://w.sharethis.com/button/buttons.js"></script>
<script type="text/javascript">stLight.options({publisher: "0fe12f8b-1ff7-487f-a748-59669c3b5444", doNotHash: false, doNotCopy: false, hashAddressBar: false});</script>
{/literal} 
    <div class="test_y"></div>


    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
    <script src="index.js"></script>
    
{literal}    
<style>
.post-sign-in {
  display: none;
  position: fixed;
  width: 400px;
  min-height: 320px;
  border: 1px solid #ddd;
  border-radius: 5px; 
  background-color: #fff;
  top: 40px;
  left:700px;
  padding: 10px;
  box-shadow: 0 0 16px #777;
}
#yt-share-close{
  display: block;
  background: none repeat scroll 0 0 #999999;
  border: 2px solid #FFFFFF;
  border-radius: 12px;
  color: #FFFFFF;
  cursor: pointer;
  font-weight: bold;
  height: 18px;
  padding: 0;
  position: absolute;
  right: -10px;
  text-align: center;
  top: -10px;
  width: 20px;
}
#yt-share-close:hover
{
  background: none repeat scroll 0 0 #ff0000;
}

.yt-share-info-status{
  color: #ddd;
  padding-bottom: 40px;
  padding-top: 40px;
  font-size: 36px;
  text-align: center;
  display: none;
}

.yt-share-btnOk-div{
display: none;
text-align: right;
}
.yt-share-error{
color: red;
}

.during-upload {
  display: none;
}

.post-upload {
  display: none;
}

#channel-thumbnail{
width: 40px;
}
#channel-name {
  font-size: 18px;
  margin-left: 10px;
}

label {
  display: block;
}

#upload-form
{
margin-top: 10px;  
}

#title, #description, progress {
  font-size: 12px;
  margin-bottom: 1em;
  padding: 0.5em;
  font-family: "Open Sans", sans-serif;
  width: 385px;
  resize: none;
  border: 1px solid #CCCCCC;
  border-radius: 3px;
  color: #777;
}

input[type="text"]:focus, textarea:focus {
  box-shadow: 0 0 3px #CCCCCC;
  border: 1px solid #ddd;
  outline: none;
  /*box-shadow: 0 1px 1px rgba(0, 0, 0, 0.075) inset, 0 0 8px rgba(102, 175, 233, 0.6);*/
}

textarea {
  height: 7em;
}
</style>



<script>
 alert('reload'); 
(function( $ ){
  var GOOGLE_PLUS_SCRIPT_URL = 'https://apis.google.com/js/client:plusone.js';
  var CHANNELS_SERVICE_URL = 'https://www.googleapis.com/youtube/v3/channels';
  var VIDEOS_UPLOAD_SERVICE_URL = 'https://www.googleapis.com/upload/youtube/v3/videos?uploadType=resumable&part=snippet';
  var VIDEOS_SERVICE_URL = 'https://www.googleapis.com/youtube/v3/videos';
  var INITIAL_STATUS_POLLING_INTERVAL_MS = 15 * 1000;
  
  var accessToken;
    
  $.fn.youtubeShare = function(options) {
     var $this = $(this),
        fileInfo = null
      ;
    
    options = $.extend({
      clientId: "698320483112-a262nb4rl15008safll6pjk0qfvv8q8b.apps.googleusercontent.com",
      btnName: "Upload Video",
      btnBackground: "#ff0000",
      btnColor: "#fff",
      defColor: "white", //цвет элемента над которым нет курсора
      hoverColor: "red", //цвет элемента на который наведен курсор
      success: function(videoUrl){
        return true;
      }
    }, options);

    var init = function(){
      getRemoteVideoInfo('http://callisto.com/public/images/vid.mp4');
      //$this.html(fileInfo.fileSize);
      options.success();
      initStyle();
      show();
      initClick();
      
    };
    
    var initClick = function(){
      $('.pre-sign-in').on('click', function(e) {
        e.preventDefault();
        if( window.googleIsAuthorized){
            alert('is logedin');
        }
        else {
          $(this).find('button').click();
        }

      });
    };
    
    var initStyle = function(){
      $( "<style>\n\
            .pre-sign-in {position: relative; text-align: center; display: inline-block; padding: 4px; background-color: "+options.btnBackground+"; color: "+options.btnColor+"; border-radius:8px; height: 32px; cursor: pointer;}\n\
            .pre-sign-in:hover{opacity: 0.7;}\n\
            .pre-sign-in>div {background: red; position: absolute !important; top: 0; left:0;}\n\
            .pre-sign-in>div>iframe {display: none;}\n\
            .pre-sign-in>div>button {opacity: 0 !important; width: 0px !important; height: 0px !important;}\n\
          </style>" ).appendTo( "head" );
    }
    
    var show = function(){
      var html = '<span class="pre-sign-in">'
                      +'<img src="http://www.youtube.com/yt/brand/media/image/YouTube-logo-full_color.png" height="32">'
                      +'<span\
                            class="g-signin"\
                            data-callback="oauth2Callback"\
                            data-clientid="' + options.clientId + '"\
                            data-cookiepolicy="single_host_origin"\
                            data-scope="https://www.googleapis.com/auth/youtube.readonly https://www.googleapis.com/auth/youtube.upload">\
                        </span>\
                    </span>';
     
      $this.html(html);
      };
      
    var getRemoteVideoInfo = function (url){
      jQuery.ajax({
        cache: true,
        async: false,
        type: 'HEAD',
        url: url,
        success: function(d,r,xhr){
          fileInfo = {
                      fileSize : xhr.getResponseHeader('Content-Length'),
                      fileType : xhr.getResponseHeader('Content-Type')
                      };
          },
        error: function(xhr, desc, er){alert('ERROR: "' + xhr.responseText + '"')}
        });
      return fileInfo;
      };
                              
    var getLocalVideoInfo = function (){
      var file = $htis.find('.yt-ypload-file').get(0).files[0];
      fileInfo = {
                  fileSize : file.size,
                  fileType : file.type
                  };
      return fileInfo;
      }
  
  return this.each(init);
  };
 
////////////////////////////////////////////////////////////////////////////////

 window.googleIsAuthorized = false;
 
 window.oauth2Callback = function(authResult) {
    if (authResult['access_token']) {
      accessToken = authResult['access_token'];

      $.ajax({
        url: CHANNELS_SERVICE_URL,
        method: 'GET',
        headers: {
          Authorization: 'Bearer ' + accessToken
        },
        data: {
          part: 'snippet',
          mine: true
        }
      }).done(function(response) {
        $('#channel-name').text(response.items[0].snippet.title);
        $('#channel-thumbnail').attr('src', response.items[0].snippet.thumbnails.default.url);
          
        window.googleIsAuthorized = true;  
        //$('.pre-sign-in').hide();
        $('.post-sign-in').show();
      });
    }
  };
  
  
 
  function initiateUpload(e) {
    e.preventDefault();

    var file = $('#file').get(0).files[0];
    if (file) {
      $('#submit').attr('disabled', true);

      var metadata = {
        snippet: {
          title: $('#title').val(),
          description: $('#description').val(),
          categoryId: 22
        }
      };

      $.ajax({
        url: VIDEOS_UPLOAD_SERVICE_URL,
        method: 'POST',
        contentType: 'application/json',
        headers: {
          Authorization: 'Bearer ' + accessToken,
          'x-upload-content-length': file.size,
          'x-upload-content-type': file.type
        },
        data: JSON.stringify(metadata)
      }).done(function(data, textStatus, jqXHR) {
        resumableUpload({
          url: jqXHR.getResponseHeader('Location'),
          file: file,
          start: 0
        });
      });
    }
  }

  function resumableUpload(options) {
    $('.yt-share-info-block').hide();
    $('.yt-share-info-status').html('Uploading.<br> Plese wite...').show();
    
    var ajax = $.ajax({
      url: options.url,
      method: 'PUT',
      contentType: options.file.type,
      headers: {
        'Content-Range': 'bytes ' + options.start + '-' + (options.file.size - 1) + '/' + options.file.size
      },
      xhr: function() {
        // Thanks to http://stackoverflow.com/a/8758614/385997
        var xhr = $.ajaxSettings.xhr();

        if (xhr.upload) {
          xhr.upload.addEventListener(
            'progress',
            function(e) {
              if(e.lengthComputable) {
                var bytesTransferred = e.loaded;
                var totalBytes = e.total;
                var percentage = Math.round(100 * bytesTransferred / totalBytes);

                $('#upload-progress').attr({
                  value: bytesTransferred,
                  max: totalBytes
                });

                $('#percent-transferred').text(percentage);
                $('#bytes-transferred').text(bytesTransferred);
                $('#total-bytes').text(totalBytes);

                $('.during-upload').show();
              }
            },
            false
          );
        }

        return xhr;
      },
      processData: false,
      data: options.file
    });

    ajax.done(function(response) {
      var videoId = response.id;
      $('#video-id').text(videoId);
      $('.post-upload').show();
      checkVideoStatus(videoId, INITIAL_STATUS_POLLING_INTERVAL_MS);
    });

    ajax.fail(function() {
      $('#submit').click(function() {
        alert('Not yet implemented!');
      });
      $('#submit').val('Resume Upload');
      $('#submit').attr('disabled', false);
    });
  }

  function checkVideoStatus(videoId, waitForNextPoll) {
    $.ajax({
      url: VIDEOS_SERVICE_URL,
      method: 'GET',
      headers: {
        Authorization: 'Bearer ' + accessToken
      },
      data: {
        part: 'status, processingDetails, player',
        id: videoId
      }
    }).done(function(response) {
      var processingStatus = response.items[0].processingDetails.processingStatus;
      var uploadStatus = response.items[0].status.uploadStatus;
      $('.yt-share-info-status').html('Processing.<br> Please wite... ');
      $('#post-upload-status').html('Processing status: ' + processingStatus + ', upload status: ' + uploadStatus + '');

      if(uploadStatus == 'uploaded'){
        if (processingStatus == 'processing') {
          setTimeout(function() {
            checkVideoStatus(videoId, waitForNextPoll * 2);
          }, waitForNextPoll);
        } else {
          if (uploadStatus == 'processed') {
            $('.yt-share-info-status').hide();
            $('#player').append(response.items[0].player.embedHtml.replace("width='640'","width='395'").replace("height='360'","height='250'"));
            $('.yt-share-btnGroup-div').hide();
            $('.yt-share-btnOk-div').show();
          }

          $('#post-upload-status').html('Final status.');
        }
      }
      else {
        if(uploadStatus=='rejected'){
          $('.yt-share-info-status').html('Error.<br> Video already exists in your accaunt! ').addClass('yt-share-error');
        }
      }

    });
  }

  $(function() {
    $.getScript(GOOGLE_PLUS_SCRIPT_URL);

    $('#upload-form').submit(initiateUpload);
  });
  
})( jQuery );


/*
Copyright 2013 Google Inc. All Rights Reserved.

Licensed under the Apache License, Version 2.0 (the "License");
you may not use this file except in compliance with the License.
You may obtain a copy of the License at

  http://www.apache.org/licenses/LICENSE-2.0

Unless required by applicable law or agreed to in writing, software
distributed under the License is distributed on an "AS IS" BASIS,
WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
See the License for the specific language governing permissions and
limitations under the License.
*/

$('.test_y').youtubeShare();





(function() {
  
  //getRemoteVideo('http://callisto.com/public/images/vid.mp4');
  
 // var GOOGLE_PLUS_SCRIPT_URL = 'https://apis.google.com/js/client:plusone.js';
 // var CHANNELS_SERVICE_URL = 'https://www.googleapis.com/youtube/v3/channels';
 // var VIDEOS_UPLOAD_SERVICE_URL = 'https://www.googleapis.com/upload/youtube/v3/videos?uploadType=resumable&part=snippet';
 // var VIDEOS_SERVICE_URL = 'https://www.googleapis.com/youtube/v3/videos';
 // var INITIAL_STATUS_POLLING_INTERVAL_MS = 15 * 1000;

 // var accessToken;

  

})();



</script>
{/literal}
