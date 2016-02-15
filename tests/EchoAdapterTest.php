<?php

namespace Rioter\Tests;


use Rioter\Logger\Adapters\EchoAdapter;
use Psr\Log\LogLevel;

class EchoAdapterTest extends \PHPUnit_Framework_TestCase
{

    public function testCustomEchoPattern()
    {
        $this->expectOutputRegex("/\\d{4}-\\d{2}-\\d{2} \\d{2}:\\d{2}:\\d{2}.\\d{6} INFO: some info/");
        $echoAdaptor = new EchoAdapter('info', "{date} {level}: {message}");
        $echoAdaptor->save(LogLevel::INFO, 'some info');
    }

    public function testSave()
    {
        $this->expectOutputString("INFO: some info");
        $echoAdapter = new EchoAdapter(LogLevel::DEBUG, '{level}: {message}');
        $echoAdapter->save(LogLevel::INFO, 'some info');
    }

}