<?php

namespace Rioter\Logger\Formatters;


interface FormatterInterface
{
    /**
     * Format string
     *
     * @param $level
     * @param $message
     * @param array $context
     * @return mixed
     */
    public function format($level, $message, array $context = array());
}