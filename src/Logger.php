<?php

namespace Rioter\Logger;

use Psr\Log\AbstractLogger;
use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerInterface;
use Psr\Log\LogLevel;


class Logger extends AbstractLogger implements LoggerAwareInterface

{
    /**
     * @var array
     */
    private $loggers = array();

    /**
     * @param $level
     * @return int
     */
    public function getLevelPriority($level)
    {
        switch ($level) {
            case LogLevel::EMERGENCY:
                return 600;
            case LogLevel::ALERT:
                return 550;
            case LogLevel::CRITICAL:
                return 500;
            case LogLevel::ERROR:
                return 400;
            case LogLevel::WARNING:
                return 300;
            case LogLevel::NOTICE:
                return 250;
            case LogLevel::INFO:
                return 200;
        }
        return 100;
    }

    /**
     * @param LoggerInterface $logger
     */
    public function setLogger(LoggerInterface $logger)
    {
        $this->loggers[] = $logger;
    }

    /**
     * Proxy method to Adapters
     *
     * @param mixed $level
     * @param string $message
     * @param array $context
     */
    public function log($level, $message, array $context = array())
    {
        foreach ($this->loggers as $logger) {
            if ($this->getLevelPriority($level) >= $this->getLevelPriority($logger->getMinLevel())) {
                $logger->log($level, $message, $context);
            }
        }
    }

}