<?php
/**
 * Created by PhpStorm.
 * User: iirioterii
 * Date: 10.02.16
 * Time: 10:25
 */

namespace Rioter\Logger\Formatter;


abstract class AbstractFormatter implements FormatterInterface
{

    // формат даты
    protected $dateFormat = 'Y-m-d H:i:s';

    // устанановить формат даты
    public function setDateFormat($dateFormat)
    {
        $this->dateFormat = $dateFormat;
    }

    // получить формат даты
    public function getDateFormat()
    {
        return $this->dateFormat;
    }

    /**
     *
     *
     * @param $level
     * @param $message
     * @param array $context
     * @return mixed
     */
    abstract public function format($level, $message, array $context = array());
}