<?php

namespace Rioter\Logger\Adapters;

use Rioter\Logger\Logger;
use Rioter\Logger\Formatters\AbstractFormatter;
use Psr\Log\LogLevel;


abstract class AbstractAdapter implements AdapterInterface
{
    // минимальный уровень логирования
    private $minLevel = 7;

    // максимальный уровень логирования
    private $maxLevel = 0;

    // Формтер используемый адпетором
    protected $formatter;

    // Имя адаптера
    protected $adapterName = '';

    // Проверка уровня журнала, обрабатываемая адаептером
    public function isHandling($level)
    {
        $min = $this->minLevel;
        $max = $this->maxLevel;
        $level = Logger::$levels[$level];
        return ($min >= $level && $level >= $max);
    }

    // Установка минимального уровня лоигрования для адаптера
    public function setLevel($minLevel = null, $maxLevel = null)
    {
        if (!$minLevel || !Logger::isLoglevel($minLevel)) {
            $minLevel = LogLevel::DEBUG;
        }

        if (!$maxLevel || !Logger::isLoglevel($maxLevel)) {
            $maxLevel = LogLevel::EMERGENCY;
        }

        $this->minLevel = Logger::$levels[$minLevel];
        $this->maxLevel = Logger::$levels[$maxLevel];
    }

    // Устанавливаем форматтер
    protected function setFormatter(AbstractFormatter $formatter)
    {
        $this->formatter = $formatter;
    }

    // получаем ф
    protected function format($level, $message, $context = array())
    {
        return $this->formatter->format($level, $message, $context);
    }

    // Установка формата даты
    public function setDateFormat($format)
    {
        if ($this->formatter) {
            $this->formatter->setDateFormat($format);
        }
    }

    // Получить формат даты
    public function getDateFormat()
    {
        if ($this->formatter) {
            return $this->formatter->getDateFormat();
        }
    }

    // Устанвоить имя для адаптера
    public function setAdapterName($adapterName)
    {
        $this->adapterName = $adapterName;
    }

    // Получить имя для адаптера
    public function getAdapterName()
    {
        return $this->adapterName;
    }

    // сохраняем лог
    abstract public function save($level, $message, array $context = array());

}