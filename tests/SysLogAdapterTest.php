<?php

namespace Rioter\Tests;


use ReflectionClass;
use Rioter\Logger\Adapters\SysLogAdapter;
use Psr\Log\LogLevel;

class SysLogAdapterTest  extends \PHPUnit_Framework_TestCase
{

    protected static function getMethod($name)
    {
        $class = new ReflectionClass('Rioter\Logger\Adapters\SysLogAdapter');
        $method = $class->getMethod($name);
        $method->setAccessible(true);
        return $method;
    }

    public function testGetSysLogLevel()
    {
        $method = self::getMethod('getSysLogLevel');
        $sysLogAdapter = new SysLogAdapter('ITcourses');
        $sysLogLevel = $method->invokeArgs($sysLogAdapter, array(LogLevel::WARNING));
        $this->assertEquals(LOG_WARNING, $sysLogLevel);
    }

}