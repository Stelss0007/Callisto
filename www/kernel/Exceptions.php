<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Extensions
 *
 * @author Ruslan
 */
class WarningException extends \Exception
{
}

class ParseException extends \Exception
{
}

class NoticeException extends \Exception
{
}

class CoreErrorException extends \Exception
{
}

class CoreWarningException extends \Exception
{
}

class CompileErrorException extends \Exception
{
}

class CompileWarningException extends \Exception
{
}

class UserErrorException extends \Exception
{
}

class UserWarningException extends \Exception
{
}

class UserNoticeException extends \Exception
{
}

class StrictException extends \Exception
{
}

class RecoverableErrorException extends \Exception
{
}

class DeprecatedException extends \Exception
{
}

class UserDeprecatedException extends \Exception
{
}

class PHPErrorException extends Exception
{
    private $context = null;

    public function __construct
    (
        $code,
        $message,
        $file,
        $line,
        $context = null
    ) {
        parent::__construct($message, $code);
        $this->file = $file;
        $this->line = $line;
        $this->context = $context;
    }
}

;

class ActiveRecordException extends \Exception
{
}

class RecordNotFound extends \Exception
{
}

class DatabaseException extends ActiveRecordException
{
    public function __construct($adapterOrStringOrMystery)
    {
        if ($adapterOrStringOrMystery instanceof Connection) {
            parent::__construct(
                join(", ", $adapterOrStringOrMystery->connection->errorInfo()),
                intval($adapterOrStringOrMystery->connection->errorCode())
            );
        } elseif ($adapterOrStringOrMystery instanceof \mysqli) {
            parent::__construct(
                join(", ", $adapterOrStringOrMystery->error),
                intval($adapterOrStringOrMystery->errno)
            );
        } else {
            parent::__construct($adapterOrStringOrMystery);
        }
    }
}

class ModelException extends ActiveRecordException
{
}

class ExpressionsException extends ActiveRecordException
{
}

class ConfigException extends ActiveRecordException
{
}

class UndefinedPropertyException extends ModelException
{
    /**
     * Sets the exception message to show the undefined property's name.
     *
     * @param str $property_name name of undefined property
     * @return void
     */
    public function __construct($className, $propertyName)
    {
        if (is_array($propertyName)) {
            $this->message = implode("\r\n", $propertyName);

            return;
        }
        $this->message = "Undefined property: {$className}->{$propertyName} in {$this->file} on line {$this->line}";
        parent::__construct();
    }
}
