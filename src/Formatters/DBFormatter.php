<?php

namespace Rioter\Logger\Formatters;


class DBFormatter extends AbstractFormatter
{

    public function __construct()
    {

    }


        public function format($level, $message, array $context = array())
    {
        // нормализируем сообщение
        $message = $this->normalize($message, $context);
        // массив параметров для формирования строки вывода
        $replace = array(
            '{level}' => strtoupper($level),
            '{message}' => $message,
            '{date}' => $this->getTimestamp()
        );
        // меняем паттерн на значения
        return strtr($this->pattern, $replace);
    }


}