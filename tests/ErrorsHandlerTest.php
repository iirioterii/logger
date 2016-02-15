<?php

namespace Rioter\Tests;


use Psr\Log\LogLevel;
use Rioter\Logger\ErrorsHandler;
use Rioter\Logger\Logger;
use Rioter\Logger\Adapters\EchoAdapter;

class ErrorsHandlerTest extends \PHPUnit_Framework_TestCase
{

    private $logger;

    public function setUp()
    {
        $echo = new EchoAdapter(LogLevel::DEBUG, '{message}');
        $this->logger = new Logger($echo);
        $this->logger->error('warning');

    }

    public function testLogErrorHandler()
    {
        $this->expectOutputRegex("/warning (.*)/");
        $handler = new ErrorsHandler($this->logger);
        $handler->regErrorHandler();
        trigger_error('warning', E_USER_WARNING);
    }

    public function testLogExceptionHandler()
    {
        $this->expectOutputRegex("/Runtime exception(.*)/");

        $handler = new ErrorsHandler($this->logger);
        var_dump($handler);
        $handler->regExceptionHandler();
        $exception = new \RuntimeException('Runtime exception');
        $handler->logExceptionHandler($exception);
    }

}