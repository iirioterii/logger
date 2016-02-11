<?php

namespace Rioter\Logger\Formatters;


class LineFormatter extends AbstractFormatter
{
    /**
     * @var
     */
    protected $pattern;

    /**
     * LineFormatter constructor.
     * @param $pattern
     */
    public function __construct($pattern)
    {
        $this->pattern = $pattern;
    }

    /**
     * метод для формирования формата сообщения вывода
     *
     * @param $level
     * @param $message
     * @param array $context
     * @return string
     */
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

    /**
     * Нормализация разных типов данных
     *
     * @param $message
     * @param array $context
     * @return string
     */
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

        return 'Unknown type';

    }

    /**
     * Меняет плейсхолдеры на значения
     *
     * @param $message
     * @param array $context
     * @return string
     */
    protected function interpolate($message, array $context)
    {
        $replace = array();
        foreach ($context as $key => $data) {
            $replace['{'.$key.'}'] = $data;
        }
        return strtr($message, $replace);
    }


}