<?php

namespace Rioter\Logger\Formatters;


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