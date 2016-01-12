<?php

class ErrorHandler
  {
  static $instance;
  
  var $error_array = array();
  var $notice_array = array();
  var $warning_array = array();
  var $user_error_array = array();
  var $backTrace = [];
  

  public static function getInstance()
   {
     if (empty(self::$instance))
      {
      self::$instance = new self;
      }
     return self::$instance;
   }

  public function __construct()
    {
    ini_set('display_errors',"1");
    error_reporting(E_ALL);
//    print_r(debug_backtrace());exit;
    // регистрация ошибок
    set_error_handler([$this, 'otherErrorCatcher']);
    set_exception_handler([$this, 'exeptionCatcher']);

    // перехват критических ошибок
    register_shutdown_function([$this, 'fatalErrorCatcher']);

    // создание буфера вывода
    ob_start();
    }

  public function otherErrorCatcher($errno, $errstr, $errfile, $errline)
    {
    // контроль ошибок:
    // - записать в лог
    
    switch ($errno) {
    case E_USER_ERROR:
      //echo "array('type' => $errno, 'message' => $errstr, 'file' => $errfile, 'line' => $errline);";
        $this->user_error_array[] = array('type' => $errno, 'message' => $errstr, 'file' => $errfile, 'line' => $errline);
        $this->__destruct();
        //тут лучше сформировать пиьсмо и отправить администратору сайты
        break;

    case E_USER_WARNING:
    case E_WARNING:
        //обрабатываем варнинги
        $this->warning_array[] = array('type' => $errno, 'message' => $errstr, 'file' => $errfile, 'line' => $errline);
        break;

    case E_USER_NOTICE:
    case E_NOTICE:
        //обрабатываем нотисы
        $this->notice_array[] = array('type' => $errno, 'message' => $errstr, 'file' => $errfile, 'line' => $errline);
        break;

    default:
        //обрабатываем остальные сообщения о неполадках
        //$this->error_array[] = array('type' => $errno, 'message' => $errstr, 'file' => $errfile, 'line' => $errline);
        break;
    }
    
    return true;
    }

  public function fatalErrorCatcher()
    {
    $error = error_get_last();

    if (isset($error))
      {
      if ($error['type'] == E_ERROR || $error['type'] == E_PARSE || $error['type'] == E_COMPILE_ERROR || $error['type'] == E_CORE_ERROR)
        {
        $trace = debug_backtrace();
       
        array_shift($trace);
        $error['trace']  = $trace;
        $this->error_array[] = $error;
        ob_end_clean(); // сбросить буфер, завершить работу буфера
        $this->__destruct();
        // контроль критических ошибок:
        // - записать в лог
        // - вернуть заголовок 500
        // - вернуть после заголовка данные для пользователя
        }
      else
        {
        $this->user_error_array[] = $error;
        ob_end_flush(); // вывод буфера, завершить работу буфера
        $this->__destruct();
        }
      }
    else
      {
      ob_end_flush(); // вывод буфера, завершить работу буфера
      }
      
    return true;
    }

  function __destruct()
    {
    if (isset($this->error_array) && !empty($this->error_array))
      {
      ob_end_clean();
      $this->showErrors();
      //exit;
      }
      
    if (isset($this->user_error_array) && !empty($this->user_error_array))
     {
      ob_end_clean();  
      $this->showErrors();
      //exit;
      }
      
    if(!empty($this->notice_array))
      {
      $this->showWarnings();
      }
    }
  function isSerial($s) 
    {
    if( stristr($s, '{' ) != false &&
        stristr($s, '}' ) != false &&
        stristr($s, ';' ) != false &&
        stristr($s, ':' ) != false
        )
      {
      return true;
      }
    else
      {
      return false;
      }
    }  
  function setError($error_message = 'User Error')
    {
    $callee = debug_backtrace();
    $callee = $callee[0];
    $error_array = array('message'=>$error_message, 'file'=>$callee['file'], 'line'=>$callee['line']);
    $error_array = serialize($error_array);
    trigger_error($error_array, E_USER_ERROR);
    }
    
    
  public function renderCallStackItem($file, $line, $class, $method, $args, $index)
    {
        $lines = [];
        $begin = $end = 0;
        if ($file !== null && $line !== null) {
            $line--; // adjust line number from one-based to zero-based
            $lines = @file($file);
            if ($line < 0 || $lines === false || ($lineCount = count($lines)) < $line + 1) {
                return '';
            }

            $half = (int) (($index == 1 ? $this->maxSourceLines : $this->maxTraceSourceLines) / 2);
            $begin = $line - $half > 0 ? $line - $half : 0;
            $end = $line + $half < $lineCount ? $line + $half : $lineCount - 1;
        }

//        return $this->renderFile($this->callStackItemView, [
//            'file' => $file,
//            'line' => $line,
//            'class' => $class,
//            'method' => $method,
//            'index' => $index,
//            'lines' => $lines,
//            'begin' => $begin,
//            'end' => $end,
//            'args' => $args,
//        ]);
    }
  function exeptionCatcher($exception)
    {
    //var_dump($exception->getTrace());exit;
    $this->error_array[] = [
        'message' => $exception->getMessage(),
        'file' => $exception->getFile(),
        'line' => $exception->getLine(),
        'trace' => $exception->getTrace(),
      ];
    
    ob_end_clean(); // сбросить буфер, завершить работу буфера
    $this->__destruct();
    }
    
  function showErrors()
    {
    global $appConfig;
    if(empty($appConfig['debug.enabled']))
      {
      header('HTTP/1.1 404 Page Not Found');
      echo 'Page Not Found!';
      die();
      }
    header('HTTP/1.1 500 Internal Server Error');
    ?>
    <head>
        <meta charset="UTF-8">
    </head>
    <body style="background-color: #DDB000;">
      <style>
        .hidden {
            display: none;
        }
        .thead td
        {
          padding: 10px;
          text-align: center;
          font-weight: bold;
        }
        .tr_error td
        {
          border-bottom: 1px solid red;
          padding: 5px;
          vertical-align: top;
        }
        
        #trace-table tr td {
            font-family: sans-serif;
            vertical-align: top;
            padding: 10px;
        }
        
        #trace-table tr:hover td {
            background-color: #B99300;
        } 
        
        #trace-table tr td .params {
            font-weight: 100; 
            color: #333;
        }
        
        .arg-detail {
            font-weight: bolder;
            cursor: pointer;
        }
        .arg-detail:hover {
            text-decoration: underline;
            color: #000;
        }
        .global-var {
            font-weight: bold;
            font-size: 16px;
        }
      </style>
      <script type="text/javascript">
          function showArgument(param1, param2) {
              var w = window.open('','_blank','width=450,height=430,resizable=1');
              var paramDetail = document.getElementById('param_detail_'+param1+'_'+param2);
              w.document.body.innerHTML = paramDetail.innerHTML;
          }
      </script>
      <table width="100%" cellspacing="1">
        <tr>
          <td colspan="3" align="center">
            <h1>Callisto Error Reporting</h1>
          </td>
        </tr>
        <tr style="background-color: red; color: #fff;" class="thead">
          <td>
            Error Message
          </td>
          <td>
            File
          </td>
          <td>
            Line
          </td>
        </tr>
        <?php foreach($this->error_array as $verror):?>
        <tr class="tr_error">
          <td>
            <b>
              <?=$verror['message'];?>
            </b>
          </td>
          <td>
            <?=$verror['file'];?>
          </td>
          <td>
            <?=$verror['line'];?>
          </td>
        </tr>
        <?php endforeach;?>
    
        <?php foreach($this->user_error_array as $verror):
          
          if(!empty($verror['message']) && $this->isSerial($verror['message']))
            $verror = unserialize($verror['message']);
        ?>
        <tr class="tr_error">
          <td>
            <b>
              <?=$verror['message'];?>
            </b>
          </td>
          <td>
            <?=$verror['file'];?>
          </td>
          <td>
            <?=$verror['line'];?>
          </td>
        </tr>
        <?php endforeach;?>
        <tr>
            <td colspan="3">
                <br><br>
                <table width="100%" id="trace-table">
                <?php
                //Trace error
                if($this->error_array[0]['trace']):
                    $currentTraceFile = '';
                    foreach($this->error_array[0]['trace'] as $key => $traceValue):
                        $currentTraceFile = (isset($traceValue['file'])) ? $traceValue['file'] : $currentTraceFile;
                ?>
                    <tr>
                        <td>
                            <?php echo $key + 1;?>.
                        </td>
                        <td>
                            in <?php echo $currentTraceFile?> 
                            - 
                            <b>
                            <?php 
                                if($traceValue['class']) echo $traceValue['class']; 
                                if($traceValue['type']) echo $traceValue['type'];
                                if($traceValue['function']) echo $traceValue['function'].'(<span class="params">';
                                
                                if($traceValue['args'])
                                    {
                                    $argsCount = sizeof($traceValue['args']);
                                    foreach ($traceValue['args'] as $key2=>$arg) 
                                        {
                                        if(is_string($arg))
                                            {
                                            echo "'$arg'";
                                            }
                                        elseif(is_object($arg))
                                            {
                                            echo '<span class="arg-detail" onClick="showArgument('.$key.','.$key2.');">'.get_class($arg).'</span>';
                                            echo '<div class="hidden" id="param_detail_'.$key.'_'.$key2.'"><pre>';
                                            var_dump($arg);
                                            echo '</pre></div>';
                                            }
                                        elseif(is_array($arg))
                                            {
                                            echo '<span class="arg-detail" onClick="showArgument('.$key.','.$key2.');">Array('.sizeof($arg).')</span>';
                                            echo '<div class="hidden" id="param_detail_'.$key.'_'.$key2.'"><pre>';
                                            var_dump($arg);
                                            echo '</pre></div>';
                                            }
                                        elseif(is_bool($arg))
                                            {
                                            echo 'Bool(';  echo ($arg) ? 'TRUE' : 'FALSE' ; ')';
                                            }
                                        else
                                            {
                                            echo $arg;
                                            }
                                            
                                        if($key2 + 1 < $argsCount)
                                            {
                                            echo ', ';
                                            }
                                        }
                                    }
                                
                                echo '</span>);';
                            ?>
                            </b>
                        </td>
                        <td style="width: 70px;">
                            at line 
                        </td>
                        <td>
                            <?php echo $traceValue['line']?>
                        </td>
                    </tr>
                <?php
                    endforeach;
                endif;
                ?>
                </table>
            </td>
        <tr>
        
        <?php //echo  $handler->renderCallStackItem($exception->getFile(), $exception->getLine(), null, null, [], 1) ?>
        <?php /*for ($i = 0, $trace = $exception->getTrace(), $length = count($trace); $i < $length; ++$i): ?>
                <?php echo  $handler->renderCallStackItem(@$trace[$i]['file'] ?: null, @$trace[$i]['line'] ?: null,
                    @$trace[$i]['class'] ?: null, @$trace[$i]['function'] ?: null, $trace[$i]['args'], $i + 2) ?>
        <?php endfor;*/ ?>
      </table>
      <hr>
      <div class="global-vars">
          <pre><span class="global-var">$_POST</span> = <?php print_r($_POST)?></pre>
          <pre><span class="global-var">$_SERVER</span> = <?php print_r($_SERVER)?><pre>
          <pre><span class="global-var">$_COOKIE</span> = <?php print_r($_COOKIE)?><pre>
      </div>
    </body>
    <?php
    $this->error_array = null;
    $this->user_error_array = null;
    die();
    }
    
  function showWarnings()
    {
    global $appConfig;
  
    if(empty($appConfig['debug.enabled']))
      return true;
    
    $debug = Debuger::getInstance();
    
    foreach($this->warning_array as $verror)
      {
      $debug->warnings[] = "PHP WARNING:".$verror['message'].' ('.str_replace('\\',"/", $verror['file']).' in line '.$verror['line'].')';
      //$debug->debug("PHP WARNING:".$verror['message'].' ('.str_replace('\\',"/", $verror['file']).' in line '.$verror['line'].')', null,WARN);
      }
        
    foreach($this->notice_array as $verror)
      {
      $debug->notices[] = "PHP NOTICE:".$verror['message'].' ('.str_replace('\\',"/", $verror['file']).' in line '.$verror['line'].')';
      //$debug->debug("PHP NOTICE:".$verror['message'].' ('.str_replace('\\',"/", $verror['file']).' in line '.$verror['line'].')', null, INFO);
      }
    }
  }
