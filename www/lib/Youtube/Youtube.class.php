<?php
/**
 * https://developers.google.com/youtube/developers_guide_php?hl=ru
 */
class Youtube
  {
  private $_yuotube = null;
  private $_video = null;
  
  function __construct()
    {
    $dir = dirname(__FILE__);

    set_include_path($dir.'/');
    require_once 'Zend/Loader.php';
    Zend_Loader::loadClass('Zend_Gdata_YouTube');
    Zend_Loader::loadClass('Zend_Gdata_AuthSub');
    Zend_Loader::loadClass('Zend_Gdata_App_Exception');
    Zend_Loader::loadClass('Zend_Gdata_ClientLogin');
    }
    
  function youtubeGetIdByURL($url)
    {
    preg_match('#(?<=(?:v|i)=)[a-zA-Z0-9-]+(?=&)|(?<=(?:v|i)\/)[^&\n]+|(?<=embed\/)[^"&\n]+|(?<=??(?:v|i)=)[^&\n]+|(?<=youtu.be\/)[^&\n]+#', $url, $matches);
    return isset($matches[1]) ? $matches[1] : false;
    }
    
  function youtubeGetIdByEMBED($embed)
    {
    preg_match('#<object[^>]+>.+?http://www.youtube.com/v/([A-Za-z0-9\-_]+).+?</object>#s', $embed, $matches);

    return isset($matches[1]) ? $matches[1] : false;
    }
    
  function connect($settings)
    {
    error_reporting(E_ALL);
    set_time_limit(0);
    
    $API_KEY = $settings['youtube_api_key'];
    $API_NAME = $settings['youtube_api_name'];
    $YOUTUBE_PASS = $settings['youtube_pass'];
    $YOUTUBE_EMAIL = $settings['youtube_mail'];
    $YOUTUBE_USERNAME = $settings['youtube_login'];
    $authenticationURL = 'https://www.google.com/youtube/accounts/ClientLogin';
    
    $YOUTUBE_EMAIL = "totsdiary@gmail.com";
    $YOUTUBE_PASS = "7eI6ZiG9";
    $API_NAME = "totsdiary_test";
    
    $API_KEY = "AI39si7AxJTq28lX0rWT5-80qosEuR0XH7XeDb-wRgydnieybG9_es6GKI07SK1UEIdeJUYQAbi003bFHOVIhpEEz-Dc7TqUDA";
    
    $httpClient = Zend_Gdata_ClientLogin::getHttpClient($YOUTUBE_EMAIL, 
                                                        $YOUTUBE_PASS, 
                                                        'youtube', 
                                                        null, 
                                                        $API_NAME, // a short string identifying your application
                                                        null,
                                                        null, 
                                                        $authenticationURL);



    $httpClient->setHeaders('X-GData-Key', "key={$API_KEY}");
    $this->_yuotube = new Zend_Gdata_YouTube($httpClient);
    }
    
  function youtubeUpload($file)
    {
    $myVideoEntry = new Zend_Gdata_YouTube_VideoEntry();

    $filesource = $this->_yuotube->newMediaFileSource($file['tmp_name']);
 
    $filesource->setContentType($file['type']);
    $filesource->setSlug($file['name']);

    $myVideoEntry->setMediaSource($filesource);
    $myVideoEntry->setVideoTitle($title);
    $myVideoEntry->setVideoDescription($description);
    $myVideoEntry->setVideoCategory('People');
    $uploadUrl = 'http://uploads.gdata.youtube.com/feeds/users/default/uploads';

    try
      {
      $newEntry = $this->_yuotube->insertEntry($myVideoEntry, $uploadUrl, 'Zend_Gdata_YouTube_VideoEntry');

      // выдираем айди видео
      preg_match("(^http:\/\/gdata.youtube.com.*\/(.*)$)", $newEntry->id->text, $pregres);
 
      return $pregres[1];
      }
    catch (Zend_Gdata_App_HttpException $httpException)
      {
      echo $httpException->getRawResponseBody();
      return $httpException->getRawResponseBody();
      }
    catch (Zend_Gdata_App_Exception $e)
      {
      echo $e->getMessage();
      return $e->getMessage();
      }
    }
    
  function youtubeGetVideoById($video_id)
    {
    return $this->_video = $this->_yuotube->getVideoEntry($video_id, null, true);
    }
    
  function youtubeGetVideo($video_obj)
    {
    return $this->_video = $video_obj;
    }
    
  function youtubeDeleteVideo()
    {
    if(empty($this->_video))
      return false;
    
    return $this->_yuotube->delete($this->_video);
    }
    
  function printVideoEntry($videoEntry=false, $tabs = "") 
    {
    $videoEntry = $this->_video;
    // the videoEntry object contains many helper functions that access the underlying mediaGroup object
    echo $tabs . 'Video: ' . $videoEntry->getVideoTitle() . "\n";
    echo $tabs . "\tDescription: " . $videoEntry->getVideoDescription() . "\n";
    echo $tabs . "\tCategory: " . $videoEntry->getVideoCategory() . "\n";
    echo $tabs . "\tTags: " . implode(", ", $videoEntry->getVideoTags()) . "\n";
    echo $tabs . "\tWatch page: " . $videoEntry->getVideoWatchPageUrl() . "\n";
    echo $tabs . "\tFlash Player Url: " . $videoEntry->getFlashPlayerUrl() . "\n";
    echo $tabs . "\tDuration: " . $videoEntry->getVideoDuration() . "\n";
    echo $tabs . "\tView count: " . $videoEntry->getVideoViewCount() . "\n";
    echo $tabs . "\tRating: " . $videoEntry->getVideoRatingInfo() . "\n";
    echo $tabs . "\tGeo Location: " . $videoEntry->getVideoGeoLocation() . "\n";

    // see the paragraph above this function for more information on the 'mediaGroup' object
    // here we are using the mediaGroup object directly to its 'Mobile RSTP link' child
   foreach ($videoEntry->mediaGroup->content as $content) {
      if ($content->type === "video/3gpp") {
        echo $tabs . "\tMobile RTSP link: " . $content->url . "\n";
      }
    }

    echo $tabs . "\tThumbnails:\n";
    $videoThumbnails = $videoEntry->getVideoThumbnails();

    foreach($videoThumbnails as $videoThumbnail) {
      echo $tabs . "\t\t" . $videoThumbnail->time . " - " . $videoThumbnail->url;
      echo " height=" . $videoThumbnail->height;
      echo " width=" . $videoThumbnail->width;
      echo "\n";
    }
    }
  }


