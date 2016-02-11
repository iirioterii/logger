<?php

namespace Rioter\Logger;

use \Psr\Log\LogLevel;


class ErrorHandler
{
    /**
     * @var Logger
     */
    protected $logger;

    /**
     * @var string
     */

    protected $shutdownLogLevel = LogLevel::CRITICAL;
    /**
     * @var string
     */
    protected $exceptionLogLevel = LogLevel::CRITICAL;

    /**
     * ErrorHandler constructor.
     * @param Logger $logger
     */
    public function __construct(Logger $logger)
    {
        $this->logger = $logger;
    }

    /**
     * установка кастомного обработчика ошибок php
     */
    public function regErrorHandler()
    {
        set_error_handler(array($this, 'logErrorHandler'));
    }

    /**
     * установка кастомного обрботчика при завершении скрипта
     *
     * @param string $loglevel
     */
    public function regShutdownHandler($loglevel = LogLevel::CRITICAL)
    {
        register_shutdown_function(array($this, 'logShutdownHandler'));
        $this->shutdownLogLevel = $loglevel;
    }
    /**
     * установка кастомного обработчика исключений
     *
     * @param string $loglevel
     */
    public function regExceptionHandler($loglevel = LogLevel::CRITICAL)
    {
        set_exception_handler(array($this, 'logExceptionHandler'));
        $this->exceptionLogLevel = $loglevel;
    }

    /**
     * кастомный обработчки ошибок php
     *
     * @param $error
     * @param $message
     * @param $file
     * @param $line
     */
    public function logErrorHandler($error, $message, $file, $line)
    {
        $message = $message . ' | File: {file} | Line: {line}';
        $context = array(
            'file' => $file,
            'line' => $line
        );
        switch ($error) {
            case E_USER_ERROR:
            case E_RECOVERABLE_ERROR:
                $this->logger->error($message, $context);
                break;
            case E_WARNING:
            case E_USER_WARNING:
                $this->logger->warning($message, $context);
                break;
            case E_NOTICE:
            case E_USER_NOTICE:
                $this->logger->notice($message, $context);
                break;
            case E_STRICT:
                $this->logger->debug($message, $context);
                break;
            default:
                $this->logger->warning($message, $context);
        }
        return;
    }

    /**
     * кастомный обработчик при завершении скрипта
     */
    public function logShutdownHandler()
    {
        if ($lasterror = error_get_last()) {
            $message = $lasterror['message'] . ' | File: {file} | Line: {line}';
            $context = array(
                'file' => $lasterror['file'],
                'line' => $lasterror['line']
            );
            $this->logger->log($this->shutdownLogLevel, $message, $context);
        }
    }

    /**
     * кастомный обработчик исключений
     *
     * @param $exception
     */
    public function logExceptionHandler($exception)
    {
        $message = $exception->getMessage() . ' | File: {file} | Line: {line}';
        $context = array(
            'file' => $exception->getFile(),
            'line' => $exception->getLine(),
        );
        $this->logger->log($this->exceptionLogLevel, $message, $context);
    }

}