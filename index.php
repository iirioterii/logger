<?php

require_once('vendor/autoload.php');

$fileAdapter = new \Rioter\Logger\Adapters\FileAdapter('logs/log.txt', 'info');

$fileAdapter->setAdapterName('fileAdapter'); //работает
//$fileAdapter->setDateFormat('H:i:s'); //работает
$fileAdapter->setLevel('debug', 'emergency'); // работает
$fileAdapter->setLogLevelFile(array('error', 'debug'), 'logs/error_debug.txt'); // работает
$fileAdapter->setLogLevelFile('warning', 'logs/warning.txt'); //работает
$fileAdapter->setLogLevelFile('critical', 'logs/critical.txt'); //работает

//echo $fileAdapter->isHandling('error'); //работает

//print_r($fileAdapter->getLogLevelFiles()); //работает

$logger = new \Rioter\Logger\Logger($fileAdapter);
//var_dump($logger);
$logger->error('message of errors {id}', array('id'=>1));
$logger->critical('critical of errors {id}', array('id'=>1));
$logger->debug('debug of errors {id} {line} {file}', array('id'=>1, 'line'=>__LINE__, 'file' => __FILE__));
$logger->warning('warning', array('id'=>1));
