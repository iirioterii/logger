<?php

namespace Rioter\Tests;

use Psr\Log\LogLevel;
use Rioter\Logger\Adapters\AbstractAdapter;
use Rioter\Logger\Formatters\LineFormatter;

class TestAdapter extends AbstractAdapter
{

    public function __construct()
    {
        $this->setFormatter(new LineFormatter(''));
    }

    public function save($level, $message, array $content = array())
    {
    }

}

class AbstractAdapterTest extends \PHPUnit_Framework_TestCase
{

    public function testSetGetAdapterName()
    {
        $adapter = new TestAdapter();
        $adapter->setAdapterName('echo');
        $this->assertEquals('echo', $adapter->getAdapterName());
    }

    public function testSetGetDateFormat()
    {
        $adapter = new TestAdapter();
        $this->assertEquals('Y-m-d H:i:s.u', $adapter->getDateFormat());
        $adapter->setDateFormat('DATE_W3C');
        $this->assertEquals('DATE_W3C', $adapter->getDateFormat());
    }

    public function testDefaultLogLevel()
    {
        $adapter = new TestAdapter();
        $this->assertTrue($adapter->isHandling(LogLevel::DEBUG));
    }

    public function testSetLevel()
    {
        $adapter = new TestAdapter();
        $adapter->setLevel(LogLevel::CRITICAL);
        $this->assertTrue($adapter->isHandling(LogLevel::CRITICAL));
        $this->assertTrue($adapter->isHandling(LogLevel::EMERGENCY));
        $this->assertTrue($adapter->isHandling(LogLevel::ALERT));
        $this->assertFalse($adapter->isHandling(LogLevel::ERROR));
        $this->assertFalse($adapter->isHandling(LogLevel::WARNING));
        $this->assertFalse($adapter->isHandling(LogLevel::NOTICE));
        $this->assertFalse($adapter->isHandling(LogLevel::INFO));
        $this->assertFalse($adapter->isHandling(LogLevel::DEBUG));
        $adapter->setLevel(LogLevel::ERROR, LogLevel::CRITICAL);
        $this->assertTrue($adapter->isHandling(LogLevel::CRITICAL));
        $this->assertTrue($adapter->isHandling(LogLevel::ERROR));
        $this->assertFalse($adapter->isHandling(LogLevel::WARNING));
        $this->assertFalse($adapter->isHandling(LogLevel::NOTICE));
        $this->assertFalse($adapter->isHandling(LogLevel::INFO));
        $this->assertFalse($adapter->isHandling(LogLevel::DEBUG));
        $this->assertFalse($adapter->isHandling(LogLevel::EMERGENCY));
        $this->assertFalse($adapter->isHandling(LogLevel::ALERT));

    }

    public function testSetBadLevel()
    {
        $adapter = new TestAdapter();
        $adapter->setLevel('');
        $this->assertTrue($adapter->isHandling(LogLevel::EMERGENCY));
        $this->assertTrue($adapter->isHandling(LogLevel::DEBUG));
    }

}