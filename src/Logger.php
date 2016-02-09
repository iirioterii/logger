<?php

namespace Rioter\Logger;

use Psr\Log\AbstractLogger;
use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerInterface;
use Psr\Log\LogLevel;


class Logger extends AbstractLogger implements LoggerAwareInterface

{

    private $loggers = array();

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

    public function setLogger(LoggerInterface $logger)
    {
        $this->loggers[] = $logger;
    }

    public function log($level, $message, array $context = array())
    {
        foreach ($this->loggers as $logger) {
            if ($this->getLevelPriority($level) >= $this->getLevelPriority($logger->getLevel())) {
                $logger->log($level, $message, $context);
            }
        }
    }

}