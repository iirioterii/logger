<?php

namespace Rioter\Logger\Formatters;


interface FormatterInterface
{
    /**
     * метод для форматирования
     *
     * @param $level
     * @param $message
     * @param array $context
     * @return mixed
     */
    public function format($level, $message, array $context = array());
}