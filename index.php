<?php

require_once('vendor/autoload.php');

$fileAdapter = new \Rioter\Logger\Adapters\FileAdapter('logs/log.txt', 'info');

$fileAdapter->setAdapterName('fileAdapter'); //работает
//$fileAdapter->setDateFormat('H:i:s'); //работает
$fileAdapter->setLevel('debug', 'emergency'); // работает
$fileAdapter->setLogLevelFile(array('error', 'debug'), 'logs/error_debug.txt'); // работает
$fileAdapter->setLogLevelFile('warning', 'logs/warning.txt'); //работает
$fileAdapter->setLogLevelFile('critical', 'logs/critical.txt'); //работает

$nullAdapter = new \Rioter\Logger\Adapters\NullAdapter();
$nullAdapter->setLevel(null, 'error');
echo $fileAdapter->isHandling('error'); //работает

var_dump($fileAdapter->getLogLevelFiles()); //работает

$logger = new \Rioter\Logger\Logger($fileAdapter);
$logger->setAdapter($nullAdapter);
//var_dump($logger);
$logger->error('message of errors {id}', array('id'=>1));
$logger->critical('critical of errors {id}', array('id'=>1));
$logger->debug('debug of errors {id} {line} {file}', array('id'=>1, 'line'=>__LINE__, 'file' => __FILE__));
$logger->warning('warning', array('id'=>1));
var_dump($logger);
function go($a,$b){
    $c=$a+$b;
    return $c;
}


function goe($a,$r){
    $c=$a+$r;
    return $c;
}

$handlers = new \Rioter\Logger\ErrorHandler($logger);
$exception = new \RuntimeException('Runtime exception');
$handlers->LogExceptionHandler($exception);
$handlers->regErrorHandler();
go(2);
goe(2);
