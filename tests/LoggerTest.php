<?php

namespace Rioter\Tests;


use Psr\Log\LogLevel;
use Rioter\Logger\Adapters\EchoAdapter;
use Rioter\Logger\Adapters\FileAdapter;
use Rioter\Logger\Adapters\SysLogAdapter;
use Rioter\Logger\Logger;

class LoggerTest  extends \PHPUnit_Framework_TestCase
{

    public function testGetLoggerName()
    {
        $logger = new Logger();
        $logger->setLoggerName('logger');
        $this->assertEquals('logger' , $logger->getLoggerName());
    }

    public function testIsLogLevel()
    {
        $logger = new Logger();
        $this->assertTrue($logger->isLogLevel(LogLevel::EMERGENCY));
        $this->assertTrue($logger->isLogLevel(LogLevel::ALERT));
        $this->assertTrue($logger->isLogLevel(LogLevel::CRITICAL));
        $this->assertTrue($logger->isLogLevel(LogLevel::ERROR));
        $this->assertTrue($logger->isLogLevel(LogLevel::WARNING));
        $this->assertTrue($logger->isLogLevel(LogLevel::NOTICE));
        $this->assertTrue($logger->isLogLevel(LogLevel::INFO));
        $this->assertTrue($logger->isLogLevel(LogLevel::DEBUG));
    }

    public function testDefaultAdapterToLogger()
    {
        $logger = new Logger();
        $adapters = $logger->getAdapters();
        $this->assertInstanceOf('Rioter\Logger\Adapters\NullAdapter', $adapters[0]);
    }

    public function testSetUnsetAdapter()
    {
        $echoAdapter = new EchoAdapter();
        $echoAdapter->setAdapterName('echo');
        $logger = new Logger($echoAdapter);
        $this->assertTrue($logger->hasAdapter('echo'));
        $logger->unsetAdapter('echo');
        $this->assertFalse($logger->hasAdapter('echo'));
    }

    public function testSetMultiAdapters()
    {
        $fileAdapter = new FileAdapter('logs/test.txt');
        $sysLogAdapter = new SysLogAdapter('ITcourses');

        $logger = new Logger();
        $logger->setAdapter($fileAdapter);
        $logger->setAdapter($sysLogAdapter);
        $adapters = $logger->getAdapters();

        $this->assertEquals(3, count($adapters));
        $this->assertInstanceOf('Rioter\Logger\Adapters\NullAdapter', $adapters[0]);
        $this->assertInstanceOf('Rioter\Logger\Adapters\FileAdapter', $adapters[1]);
        $this->assertInstanceOf('Rioter\Logger\Adapters\SysLogAdapter', $adapters[2]);
    }

    public function testEmergency()
    {
        $this->expectOutputString('emergency');
        $echo = new EchoAdapter(LogLevel::EMERGENCY, '{message}' );
        $logger = new Logger($echo);
        $logger->emergency('emergency');
    }

    public function testAlert()
    {
        $this->expectOutputString('alert');
        $echo = new EchoAdapter(LogLevel::ALERT, '{message}' );
        $logger = new Logger($echo);
        $logger->alert('alert');
    }

    public function testCritical()
    {
        $this->expectOutputString('critical');
        $echo = new EchoAdapter(LogLevel::CRITICAL, '{message}' );
        $logger = new Logger($echo);
        $logger->critical('critical');
    }

    public function testError()
    {
        $this->expectOutputString('error');
        $echo = new EchoAdapter(LogLevel::ERROR, '{message}' );
        $logger = new Logger($echo);
        $logger->error('error');
    }

    public function testWarning()
    {
        $this->expectOutputString('warning');
        $echo = new EchoAdapter(LogLevel::WARNING, '{message}' );
        $logger = new Logger($echo);
        $logger->warning('warning');
    }

    public function testNotice()
    {
        $this->expectOutputString('notice');
        $echo = new EchoAdapter(LogLevel::NOTICE, '{message}' );
        $logger = new Logger($echo);
        $logger->notice('notice');
    }

    public function testInfo()
    {
        $this->expectOutputString('info');
        $echo = new EchoAdapter(LogLevel::INFO, '{message}' );
        $logger = new Logger($echo);
        $logger->info('info');
    }

    public function testDebug()
    {
        $this->expectOutputString('debug');
        $echo = new EchoAdapter(LogLevel::DEBUG, '{message}' );
        $logger = new Logger($echo);
        $logger->debug('debug');
    }

    /**
     * @expectedException \Psr\Log\InvalidArgumentException
     */
    public function testUndefinedLogLevel()
    {
        $logger = new Logger();
        $logger->log('myLvl', 'myLvl');
    }

}