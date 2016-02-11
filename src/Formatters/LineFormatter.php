<?php

namespace Rioter\Logger\Formatters;


class LineFormatter extends AbstractFormatter
{

    protected $pattern;

    // Задаем паттерн для вывода в строчку
    public function __construct($pattern)
    {
        $this->pattern = $pattern;
    }

    // метод для формирования формата сообщения вывода
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

    // Нормализация разных типов данных
    protected function normalize($message, array $context)
    {
        // проверка скалярная ли перменная
        if (is_scalar($message)) {
            $message = (string) $message;
            if ($context['placeholder']) {
                // делаем интерполяцию сообщения
                $message = $this->interpolate($message, $context['placeholder']);
            }
            return $message;
        }

        if (is_null($message)) {
            return 'null';
        }

        return '[Unknown type]';

    }

    // Меняет плейсхолдеры на значения
    protected function interpolate($message, array $context)
    {
        $replace = array();
        foreach ($context as $key => $data) {
            $replace['{'.$key.'}'] = $data;
        }
        return strtr($message, $replace);
    }


}