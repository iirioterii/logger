<?php

namespace Rioter\Logger\Formatters;
use DateTime;

abstract class AbstractFormatter implements FormatterInterface
{
    /**
     * формат даты по умолчанию
     *
     * @var string
     */
    protected $dateFormat = 'Y-m-d H:i:s.u';

    /**
     * получам дату с микросекундами
     *
     * @return string
     */
    protected function getDateTime()
    {
        $originalTime = microtime(true);
        $micro = sprintf("%06d", ($originalTime - floor($originalTime)) * 1000000);
        $date = new DateTime(date('Y-m-d H:i:s.' . $micro, $originalTime));
        return $date->format($this->dateFormat);
    }

    /**
     * устанановить формат даты
     *
     * @param $dateFormat
     */
    public function setDateFormat($dateFormat)
    {
        $this->dateFormat = $dateFormat;
    }

    /**
     * получить формат даты
     *
     * @return string
     */
    public function getDateFormat()
    {
        return $this->dateFormat;
    }

    /**
     * @param $level
     * @param $message
     * @param array $context
     * @return mixed
     */
    abstract public function format($level, $message, array $context = array());
}