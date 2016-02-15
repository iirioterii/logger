<?php

namespace Rioter\Tests;

use Psr\Log\LogLevel;
use Rioter\Logger\Adapters\NullAdapter;


class NullAdapterTest extends \PHPUnit_Framework_TestCase
{
    public function testSave()
    {
        $this->expectOutputString('');
        $echoAdapter = new NullAdapter();
        $echoAdapter->save(LogLevel::INFO,'null');
    }
}