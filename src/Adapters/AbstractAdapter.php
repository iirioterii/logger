<?php

namespace Rioter\Logger\Adapters;

use Rioter\Logger\Logger;
use Rioter\Logger\Formatters\AbstractFormatter;
use Psr\Log\LogLevel;


abstract class AbstractAdapter implements AdapterInterface
{

    /**
     * минимальный уровень логирования
     *
     * @var int
     */
    private $minLevel = 7;

    /**
     * максимальный уровень логирования
     *
     * @var int
     */
    private $maxLevel = 0;


    /**
     * форматтер используемый адаптером
     *
     * @var
     */
    protected $formatter;

    /**
     * имя адептера используемый адаптером
     *
     * @var string
     */
    private $adapterName = '';


    /**
     * проверка уровня журнала, обрабатываемая адаптером
     *
     * @param $level
     * @return bool
     */
    public function isHandling($level)
    {
        $min = $this->minLevel;
        $max = $this->maxLevel;
        $level = Logger::$levels[$level];
        return ($min >= $level && $level >= $max);
    }

    /**
     * Установка минимального уровня логирования для адаптера
     *
     * @param null $minLevel
     * @param null $maxLevel
     */
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

    /**
     * устанавливаем форматтер
     *
     * @param AbstractFormatter $formatter
     */
    protected function setFormatter(AbstractFormatter $formatter)
    {
        $this->formatter = $formatter;
    }

    /**
     * получаем форматированную строку
     *
     * @param $level
     * @param $message
     * @param array $context
     * @return mixed
     */
    protected function format($level, $message, $context = array())
    {
        return $this->formatter->format($level, $message, $context);
    }

    /**
     * установка формата даты
     *
     * @param $format
     */
    public function setDateFormat($format)
    {
        $this->formatter->setDateFormat($format);
    }

    /**
     * получить формат даты
     *
     * @return mixed
     */
    public function getDateFormat()
    {
        return $this->formatter->getDateFormat();
    }

    /**
     * установка имени адаптера
     *
     * @param $adapterName
     */
    public function setAdapterName($adapterName)
    {
        $this->adapterName = $adapterName;
    }

    /**
     * получить имя адаптера
     *
     * @return string
     */
    public function getAdapterName()
    {
        return $this->adapterName;
    }

    /**
     * абстрактный метод для записи в лог
     *
     * @param $level
     * @param $message
     * @param array $context
     * @return mixed
     */
    abstract public function save($level, $message, array $context = array());

}