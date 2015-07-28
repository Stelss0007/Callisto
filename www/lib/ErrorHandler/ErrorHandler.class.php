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
        }
      </style>
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
        
        <?php //echo  $handler->renderCallStackItem($exception->getFile(), $exception->getLine(), null, null, [], 1) ?>
        <?php for ($i = 0, $trace = $exception->getTrace(), $length = count($trace); $i < $length; ++$i): ?>
                <?php echo  $handler->renderCallStackItem(@$trace[$i]['file'] ?: null, @$trace[$i]['line'] ?: null,
                    @$trace[$i]['class'] ?: null, @$trace[$i]['function'] ?: null, $trace[$i]['args'], $i + 2) ?>
        <?php endfor; ?>
      </table>
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
