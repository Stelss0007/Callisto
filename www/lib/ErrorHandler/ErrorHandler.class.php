<?php
class ErrorHandler
  {
  static $instance;
  
  var $error_array = array();
  var $notice_array = array();
  var $warning_array = array();
  var $user_error_array = array();
  
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
    error_reporting(0);
    // регистрация ошибок
    set_error_handler(array($this, 'OtherErrorCatcher'));

    // перехват критических ошибок
    register_shutdown_function(array($this, 'FatalErrorCatcher'));

    // создание буфера вывода
    ob_start();
    }

  public function OtherErrorCatcher($errno, $errstr, $errfile, $errline)
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

  public function FatalErrorCatcher()
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
      exit;
      }
    if (isset($this->user_error_array) && !empty($this->user_error_array))
     {
      ob_end_clean();
      $this->showErrors();
      exit;
      }
      
    if(!empty($this->notice_array))
      {
      $this->showWarnings();
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
    
  function showErrors()
    {
    ?>
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
            <h1>Callisto Error Reporter</h1>
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
        <?foreach($this->error_array as $verror):?>
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
        <?endforeach;?>
      
        <?foreach($this->user_error_array as $verror):
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
        <?endforeach;?>
      </table>
    </body>
    <?
    $this->error_array = null;
    $this->user_error_array = null;
    die();
    }
    
  function showWarnings()
    {
    ?>
    <script>
      <?foreach($this->warning_array as $verror):?>
        console.warn("PHP WARNING: <?=$verror['message'].' ('.str_replace('\\',"/", $verror['file']).' in line '.$verror['line'].')';?>");
      <?endforeach;?>
        
      <?foreach($this->notice_array as $verror):?>
        console.warn("PHP NOTICE: <?=$verror['message'].' ('.str_replace('\\',"/", $verror['file']).' in line '.$verror['line'].')';?>");
      <?endforeach;?>
    </script>
    <?
    }

  }

?>
