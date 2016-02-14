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
        if ($context['placeholder']) {
            $message = $this->interpolate($message, $context['placeholder']);
        }
        // массив параметров для формирования строки вывода
        $replace = array(
            '{level}' => strtoupper($level),
            '{message}' => $message,
            '{date}' => $this->getDateTime(),
            '{line}' => __LINE__,
            '{file}' => __FILE__
        );
        // меняем паттерн на значения
        return strtr($this->pattern, $replace);
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