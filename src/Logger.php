<?php

namespace Rioter\Logger;

use Psr\Log\LoggerInterface;
use Psr\Log\LogLevel;
use Psr\Log\InvalidArgumentException;
use Rioter\Logger\Adapters\NullAdapter;

use Rioter\Logger\Adapters\AbstractAdapter;

class Logger implements LoggerInterface
{

    /**
     * массив с адаптерами
     *
     * @var array
     */
    private $adapters = [];

    /**
     * подсчет количества адаптеров, во время выполнения
     *
     * @var int
     */
    private $adaptersCount = 0;

    /**
     * имя логгера
     *
     * @var
     */
    private $loggerName;

    /**
     * массив с log levels с цифрами, для удобства сравнения
     *
     * @var array
     */
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

    /**
     * Logger constructor.
     * @param AbstractAdapter $adapter
     * @param string $loggerName
     */
    public function __construct(AbstractAdapter $adapter = null, $loggerName='DefaultLogger')
    {
        if (!$adapter) {
            $adapter = new NullAdapter();
        }
        $this->setAdapter($adapter);
        $this->setLoggerName($loggerName);
    }

    /**
     * установка адаптера для записи логов
     *
     * @param AbstractAdapter $adapter
     */
    public function setAdapter(AbstractAdapter $adapter)
    {
        $adapterName = $adapter->getAdapterName() ?: $this->adaptersCount;
        $this->adapters[$adapterName] = $adapter;
        $this->adaptersCount++;
    }

    public function hasAdapter($adapterName)
    {
        return array_key_exists($adapterName, $this->adapters);
    }

    /**
     * ансеттит адаптер
     *
     * @param $adapterName
     */
    public function unsetAdapter($adapterName)
    {
        if ($this->hasAdapter($adapterName)) {
            unset($this->adapters[$adapterName]);
        }
    }

    /**
     *получаем все установленые адаптеры
     *
     * @return array
     */
    public function getAdapters()
    {
        return $this->adapters;
    }


    /**
     *устаналивает имя логгера
     *
     * @param $loggerName
     */
    public function setLoggerName($loggerName)
    {
        $this->loggerName = $loggerName;
    }

    /**
     * получает имя логгера
     *
     * @return mixed
     */
    public function getLoggerName()
    {
        return $this->loggerName;
    }

    /**
     *проверка на то есть ли такой logLevel
     *
     * @param $logLevel
     * @return bool
     */
    public static function isLogLevel($logLevel)
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
        $this->log(LogLevel::EMERGENCY, $message, $context);
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
        $this->log(LogLevel::ALERT, $message, $context);
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
        $this->log(LogLevel::CRITICAL, $message, $context);
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
        $this->log(LogLevel::ERROR, $message, $context);
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
        $this->log(LogLevel::WARNING, $message, $context);
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
        $this->log(LogLevel::NOTICE, $message, $context);
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
        $this->log(LogLevel::INFO, $message, $context);
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
        $this->log(LogLevel::DEBUG, $message, $context);
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
        if (!self::isLogLevel($level)) {
           throw new InvalidArgumentException('Unknown level, check it');
        }
        //перебераем все адаптеры, если адаптер соотвествует уровню записываем
        foreach($this->adapters as $adapter) {
            if ($adapter->isHandling($level)) {
                $adapter->save($level, $message, $context);
            }
        }

    }

}