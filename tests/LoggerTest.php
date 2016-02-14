<?php

namespace Rioter\Tests;


use Psr\Log\LogLevel;
use Rioter\Logger\Logger;

class LoggerTest  extends \PHPUnit_Framework_TestCase
{
    private $logger;

    public function setup()
    {
        $this->logger = new Logger();
        $this->logger->setLoggerName('logger');
    }

    public function testGetLogger()
    {
        $this->assertEquals('logger' , $this->logger->getLoggerName());
    }

    public function testIsLogLevel()
    {
        $this->assertTrue($this->logger->isLogLevel(LogLevel::EMERGENCY));
        $this->assertTrue($this->logger->isLogLevel(LogLevel::ALERT));
        $this->assertTrue($this->logger->isLogLevel(LogLevel::CRITICAL));
        $this->assertTrue($this->logger->isLogLevel(LogLevel::ERROR));
        $this->assertTrue($this->logger->isLogLevel(LogLevel::WARNING));
        $this->assertTrue($this->logger->isLogLevel(LogLevel::NOTICE));
        $this->assertTrue($this->logger->isLogLevel(LogLevel::INFO));
        $this->assertTrue($this->logger->isLogLevel(LogLevel::DEBUG));
    }

}