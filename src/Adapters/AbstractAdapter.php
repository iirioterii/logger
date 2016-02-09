<?php

namespace Rioter\Logger\Adapters;

use Psr\Log\AbstractLogger;
use Psr\Log\LogLevel;


abstract class AbstractAdapter extends AbstractLogger
{
    /**
     * Default loglevel
     *
     * @var string
     */
    private $level = LogLevel::DEBUG;

    /**
     *
     * @param $level
     */
    public function setMinLevel($level)
    {
        $this->level = $level;
    }

    /**
     * @return string
     */
    public function getMinLevel()
    {
        return $this->level;
    }

    /**
     * Interpolates context values into the message placeholders.
     *
     * @param $message
     * @param array $context
     * @return string
     */
    protected function interpolate($message, array $context = array())
    {
        $replace = array();
        foreach ($context as $key => $val) {
            $replace['{' . $key . '}'] = $val;
        }
        return strtr($message, $replace);
    }

}