<?php

use Psr\Log\LogLevel;
use Rioter\Logger\Logger;
use Rioter\Logger\Adapters;
use Rioter\Logger\ErrorHandler;

require_once('vendor/autoload.php');

$fileAdapter = new Adapters\FileAdapter('logs/log.txt');
$fileAdapter->setDateFormat('Y-m-d H:i:s');
$fileAdapter->setLevel(LogLevel::DEBUG, LogLevel::INFO);
$fileAdapter->setMethodLogLevelFile(array(LogLevel::ERROR, LogLevel::DEBUG), 'logs/error_debug.txt');
$fileAdapter->setMethodLogLevelFile(LogLevel::WARNING, 'logs/warning.txt');


$echoAdapter = new Adapters\EchoAdapter();
$echoAdapter->setLevel(LogLevel::ERROR, LogLevel::CRITICAL);


$sysLogAdapter = new Adapters\SysLogAdapter('ITCourses');
$sysLogAdapter->setLevel(null, LogLevel::ERROR);


$logger = new Logger($sysLogAdapter);
$logger->setAdapter($fileAdapter);
$logger->setAdapter($echoAdapter);
$logger->error('message of errors {id}', array('id'=>1));
$logger->debug('debug of errors {id} {line} {file}', array('id'=>1, 'line'=>__LINE__, 'file' => __FILE__));
$logger->warning('warning', array('id'=>1));


$handler = new ErrorHandler($logger);
$exception = new \RuntimeException('Runtime exception');
$handler->regExceptionHandler();
$handler->logExceptionHandler($exception);
$handler->regErrorHandler();
