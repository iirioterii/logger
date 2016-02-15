<?php

namespace Rioter\Tests;


use Rioter\Logger\Adapters\FileAdapter;
use Psr\Log\LogLevel;

class FileAdapterTest  extends \PHPUnit_Framework_TestCase
{

    public function testLevelSetGetMethodLogLevelFile()
    {
        $fileAdapter = new FileAdapter('/logs/log.txt');

        $fnBeforeSetMethodLogLevelFile = array(
            LogLevel::EMERGENCY => '',
            LogLevel::ALERT     => '',
            LogLevel::CRITICAL  => '',
            LogLevel::ERROR     => '',
            LogLevel::WARNING   => '',
            LogLevel::NOTICE    => '',
            LogLevel::INFO      => '',
            LogLevel::DEBUG     => ''
        );

        $levelFiles = $fileAdapter->getMethodsLogLevelFiles();
        $fileAdapter->setMethodLogLevelFile(LogLevel::INFO, 'info.txt');
        $fileAdapter->setMethodLogLevelFile(LogLevel::DEBUG, 'debug.txt');
        $fileAdapter->setMethodLogLevelFile(LogLevel::NOTICE, 'notice.txt');
        $fileAdapter->setMethodLogLevelFile(LogLevel::WARNING, 'warning.txt');
        $fileAdapter->setMethodLogLevelFile(LogLevel::ERROR, 'error.txt');
        $fileAdapter->setMethodLogLevelFile(LogLevel::CRITICAL, 'critical.txt');
        $fileAdapter->setMethodLogLevelFile(LogLevel::ALERT, 'alert.txt');
        $fileAdapter->setMethodLogLevelFile(LogLevel::EMERGENCY, 'emergency.txt');
        $this->assertEquals($fnBeforeSetMethodLogLevelFile, $levelFiles);

        $fnAfterSetMethodLogLevelFile = array(
            LogLevel::EMERGENCY => 'emergency.txt',
            LogLevel::ALERT     => 'alert.txt',
            LogLevel::CRITICAL  => 'critical.txt',
            LogLevel::ERROR     => 'error.txt',
            LogLevel::WARNING   => 'warning.txt',
            LogLevel::NOTICE    => 'notice.txt',
            LogLevel::INFO      => 'info.txt',
            LogLevel::DEBUG     => 'debug.txt'
        );
        $levelFiles = $fileAdapter->getMethodsLogLevelFiles();
        $this->assertEquals($fnAfterSetMethodLogLevelFile, $levelFiles);
    }

    public function testSave()
    {
        $fileAdapter = new FileAdapter(__DIR__.'/logs/log.txt', LogLevel::INFO, '{message}');
        $fileAdapter->save(LogLevel::INFO, 'some info');
        $lastLine = 'some info';
        $logFile = file(__DIR__.'/logs/log.txt', FILE_SKIP_EMPTY_LINES);
        $this->assertEquals($lastLine, $logFile[count($logFile)-1]);
        unlink(__DIR__.'/logs/log.txt');
    }

}