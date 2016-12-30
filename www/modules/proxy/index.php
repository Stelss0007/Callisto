<?php
class IndexController extends Controller
  {
  function actionIndex($query)
    {
    //Автоматически заменять относительные ссылки на абсолютные   
    $urlsAutoReplace = true;
    //Автоматически заменять ссылки с добавлением адреса прокси
    $urlsAutoReplaceLinkProxy = true;
            
    $encode = false;
        
    $sourceUrl = parse_url($query);  
    $host = $sourceUrl['host'];
    $protocol = $sourceUrl['scheme'];
    $domain = $protocol.'://'.$host;

    
    $requestHeaders = getallheaders();
    $requestHeaders['Host'] = $host;
    //$requestHeaders['Expect'] = '';
    $headers = [];

    foreach($requestHeaders as $key => $value)
        {
        $headers[] = $key.': '.$value;
        }
         
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_VERBOSE, 0);
    curl_setopt($ch, CURLOPT_HEADER, 1);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_AUTOREFERER, 1);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
//    curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
//    curl_setopt($ch, CURLOPT_REFERER, $_SERVER['HTTP_REFERER']);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_URL, $query);
    
    
    $response = curl_exec($ch);
   
    $header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
    //Headers string
    $header = substr($response, 0, $header_size);
    //Body sring
    $body = substr($response, $header_size);
    
    $headerArray = explode("\r\n", $header);
 //echo $body;exit;
    
    //Set headers for response
    foreach($headerArray as $headerResponse)
        {
        if(!$headerResponse)
            {
            continue;
            }
            
        list($key, $value) = explode(': ', $headerResponse);
        
        if($key == 'Location' || $key == 'Content-Length' || $key == 'Transfer-Encoding')
            {
            continue;
            }
            
        if($key == 'Content-Encoding')
            {
            if($value === 'gzip' || $value === 'deflate')
                {
                $encode = true;
                }
            continue;
            }
       
        header($headerResponse);
        }
    

    if($encode) 
        {
        $body = gzdecode($body);
        }
        
    if($urlsAutoReplace)
        {
        $domainProxy = $domain;
        
        
        //Replase Relative URL to Absolute
        //Replace CSS Style URLs 
        $body = preg_replace("#(<\s*link\s+[^>]*href\s*=\s*[\"'])(?!http|//)([^\"'>]+)([\"'>]+)#", '$1'.$domain.'/$2$3', $body);
        //Replace JS URLs
        $body = preg_replace("#(<\s*script\s+[^>]*src\s*=\s*[\"'])(?!http)([^\"'>]+)([\"'>]+)#", '$1'.$domain.'/$2$3', $body);
        //Replace Link URLs
        $body = preg_replace("#(<\s*a\s+[^>]*href\s*=\s*[\"'])(?!http)([^\"'>]+)([\"'>]+)#", '$1'.$domainProxy.'/$2$3', $body);
        //Replace Image URLs
        $body = preg_replace("#(<\s*img\s+[^>]*src\s*=\s*[\"'])(?!http)([^\"'>]+)([\"'>]+)#", '$1'.$domain.'/$2$3', $body);
        //Replace Forms Actions
        $body = preg_replace("#(<\s*form\s+[^>]*action\s*=\s*[\"'])(?!http)([^\"'>]+)([\"'>]+)#", '$1'.$domain.'/$2$3', $body);
        
        $body = preg_replace("#(<\s*span\s+[^>]*title\s*=\s*[\"'])(?!http)([^\"'>]+)([\"'>]+)#", '$1'.$domain.'/$2$3', $body);
        
        
        if($urlsAutoReplaceLinkProxy)
            {
            $domainProxy = 'http://'.$_SERVER['SERVER_NAME'].'/proxy/?query=';
            $body = preg_replace("#(<\s*a\s+[^>]*href\s*=\s*[\"'])(?)([^\"'>]+)([\"'>]+)#", '$1'.$domainProxy.'$2$3', $body);
            $body = preg_replace("#(<\s*form\s+[^>]*action\s*=\s*[\"'])(?)([^\"'>]+)([\"'>]+)#", '$1'.$domainProxy.'$2$3', $body);
            }
        }
     
        
    header("Content-length: " . strlen($body));
    
    echo $body;
    exit;
    }
  }
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

