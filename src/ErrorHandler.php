<?php

namespace Rioter\Logger;

use \Psr\Log\LogLevel;


class ErrorHandler
{

    protected $logger;
    protected $shutdownLogLevel = LogLevel::CRITICAL;
    protected $exceptionLogLevel = LogLevel::CRITICAL;

    public function __construct(Logger $logger)
    {
        $this->logger = $logger;
    }

    // установка кастомного обработчика ошибок php
    public function regErrorHandler()
    {
        set_error_handler(array($this, 'LogErrorHandler'));
    }

    // установка кастомного обрботчика при завершении скрипта
    public function regShutdownHandler($loglevel = LogLevel::CRITICAL)
    {
        register_shutdown_function(array($this, 'LogShutdownHandler'));
        $this->shutdownLogLevel = $loglevel;
    }

    // установка кастомного обработчика исключений
    public function regExceptionHandler($loglevel = LogLevel::CRITICAL)
    {
        set_exception_handler(array($this, 'LogExceptionHandler'));
        $this->exceptionLogLevel = $loglevel;
    }

    // кастомный обработчки ошибок php
    public function LogErrorHandler($error, $message, $file, $line)
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

    // кастомный обработчик при завершении скрипта
    public function LogShutdownHandler()
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

    // кастомный обработчик исключений
    public function LogExceptionHandler($exception)
    {
        $message = $exception->getMessage() . ' | File: {file} | Line: {line}';
        $context = array(
            'file' => $exception->getFile(),
            'line' => $exception->getLine(),
        );
        $this->logger->log($this->exceptionLogLevel, $message, $context);
    }

}