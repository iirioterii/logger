<?php

namespace Rioter\Logger\Adapters;

use Psr\Log\LogLevel;
use Rioter\Logger\Formatters\LineFormatter;

class EchoAdapter extends AbstractAdapter
{
    /**
     * EchoAdapter constructor.
     * @param string $level
     * @param string $pattern
     */
    public function __construct($level = logLevel::DEBUG, $pattern = '')
    {
        $this->setLevel($level);
        $pattern = $pattern ?: "{date}: [{level}] Message: {message} <br>";

        $formatter = new LineFormatter($pattern);
        $this->setFormatter($formatter);
    }

    /**
     * @param $level
     * @param $message
     * @param array $context
     * @return mixed
     */
    public function save($level, $message, array $context = array())
    {
        $context = array('placeholder' => $context);
        $log = $this->format($level, $message, $context);
        echo $log;
    }

}