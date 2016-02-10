<?php

namespace Rioter\Logger\Formatter;


interface FormatterInterface
{
    /**
     * метод для формата записи в лог
     *
     * @param $level
     * @param $message
     * @param array $context
     * @return mixed
     */
    public function format($level, $message, array $context = array());
}