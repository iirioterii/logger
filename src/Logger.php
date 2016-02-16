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
     * Adapters array
     *
     * @var array
     */
    private $adapters = [];

    /**
     * Counts of adapters
     *
     * @var int
     */
    private $adaptersCount = 0;

    /**
     * Logger name
     *
     * @var
     */
    private $loggerName;

    /**
     * Log levels array with number
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
     * Set adapter for save logs
     *
     * @param AbstractAdapter $adapter
     */
    public function setAdapter(AbstractAdapter $adapter)
    {
        $adapterName = $adapter->getAdapterName() ?: $this->adaptersCount;
        $this->adapters[$adapterName] = $adapter;
        $this->adaptersCount++;
    }

    /**
     * Check if adapter is set
     *
     * @param $adapterName
     * @return bool
     */
    public function hasAdapter($adapterName)
    {
        return array_key_exists($adapterName, $this->adapters);
    }

    /**
     * Unset adapter
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
     * Get all set adapters
     *
     * @return array
     */
    public function getAdapters()
    {
        return $this->adapters;
    }


    /**
     * Set logger name
     *
     * @param $loggerName
     */
    public function setLoggerName($loggerName)
    {
        $this->loggerName = $loggerName;
    }

    /**
     * Get logger name
     *
     * @return mixed
     */
    public function getLoggerName()
    {
        return $this->loggerName;
    }

    /**
     * check if log level exist
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
        // iterate all adapters and if is handling save
        foreach($this->adapters as $adapter) {
            if ($adapter->isHandling($level)) {
                $adapter->save($level, $message, $context);
            }
        }

    }

}