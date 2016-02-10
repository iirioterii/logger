<?php

namespace Rioter\Logger;

use Psr\Log\LoggerInterface;
use Psr\Log\LogLevel;
use Psr\Log\InvalidArgumentException;

use Rioter\Logger\Adapters\AbstractAdapter;
use Rioter\Logger\Adapters\NullAdapter;

class Logger implements LoggerInterface
{
    // массив с адаптерами для того чтобы сохранять логи
    protected $adapters = [];

    // подсчет количества адаптеров, во время выполнения
    protected $adapterCount = 0;

    // имя логгера
    protected $loggerName;

    // массив с log levels с цифрами
    public static $levels = array(
        LogLevel::EMERGENCY => 0,
        LogLevel::ALERT     => 1,
        LogLevel::CRITICAL  => 2,
        LogLevel::ERROR     => 3,
        LogLevel::WARNING   => 4,
        LogLevel::NOTICE    => 5,
        LogLevel::INFO      => 6,
        LogLevel::DEBUG     => 7
    );

    public function __construct(AbstractAdapter $adapter, $loggerName)
    {
        if(empty($adapter)) {
            $adapter = new NullAdapter();
        }
        $this->setAdapter($adapter);
        $this->setLoggerName($loggerName);
    }

    // установка адаптера для записи логов
    public function setAdapter(AbstractAdapter $adapter)
    {
        $this->adapter = $adapter;
    }

    // получаем все установленые адаптеры
    public function getAdapters()
    {
        return $this->adapters;
    }

    // устаналивает имя логгера
    public function setLoggerName($loggerName)
    {
        $this->loggerName = $loggerName;
    }

    // получает имя логгера
    public function getLoggerName()
    {
        return $this->loggerName;
    }

    // проверка на то правильный ли logLEvel
    public function isLogLevel($logLevel)
    {
        return array_key_exists($logLevel, self::$levels);
    }


    /**
     * System is unusable.
     *
     * @param string $message
     * @param array $context
     * @return null
     */
    public function emergency($message, array $context = array())
    {
        // TODO: Implement emergency() method.
    }

    /**
     * Action must be taken immediately.
     *
     * Example: Entire website down, database unavailable, etc. This should
     * trigger the SMS alerts and wake you up.
     *
     * @param string $message
     * @param array $context
     * @return null
     */
    public function alert($message, array $context = array())
    {
        // TODO: Implement alert() method.
    }

    /**
     * Critical conditions.
     *
     * Example: Application component unavailable, unexpected exception.
     *
     * @param string $message
     * @param array $context
     * @return null
     */
    public function critical($message, array $context = array())
    {
        // TODO: Implement critical() method.
    }

    /**
     * Runtime errors that do not require immediate action but should typically
     * be logged and monitored.
     *
     * @param string $message
     * @param array $context
     * @return null
     */
    public function error($message, array $context = array())
    {
        // TODO: Implement error() method.
    }

    /**
     * Exceptional occurrences that are not errors.
     *
     * Example: Use of deprecated APIs, poor use of an API, undesirable things
     * that are not necessarily wrong.
     *
     * @param string $message
     * @param array $context
     * @return null
     */
    public function warning($message, array $context = array())
    {
        // TODO: Implement warning() method.
    }

    /**
     * Normal but significant events.
     *
     * @param string $message
     * @param array $context
     * @return null
     */
    public function notice($message, array $context = array())
    {
        // TODO: Implement notice() method.
    }

    /**
     * Interesting events.
     *
     * Example: User logs in, SQL logs.
     *
     * @param string $message
     * @param array $context
     * @return null
     */
    public function info($message, array $context = array())
    {
        // TODO: Implement info() method.
    }

    /**
     * Detailed debug information.
     *
     * @param string $message
     * @param array $context
     * @return null
     */
    public function debug($message, array $context = array())
    {
        // TODO: Implement debug() method.
    }

    /**
     * Logs with an arbitrary level.
     *
     * @param mixed $level
     * @param string $message
     * @param array $context
     * @return null
     */
    public function log($level, $message, array $context = array())
    {
        // TODO: Implement log() method.
    }

}