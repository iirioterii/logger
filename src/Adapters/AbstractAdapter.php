<?php

namespace Rioter\Logger\Adapters;

use Psr\Log\AbstractLogger;
use Psr\Log\LogLevel;


abstract class AbstractAdapter extends AbstractLogger
{

    private $level = LogLevel::DEBUG;

    public function setLevel($level)
    {
        $this->level = $level;
    }

    public function getLevel()
    {
        return $this->level;
    }

    public function dump($variable)
    {
        $this->log(LogLevel::DEBUG, var_export($variable, true));
    }

    protected function interpolate($message, array $context = array())
    {
        $replace = array();
        foreach ($context as $key => $val) {
            $replace['{' . $key . '}'] = $val;
        }
        return strtr($message, $replace);
    }

}