<?php

namespace Rioter\Logger\Adapters;

use Rioter\Logger\Logger;
use Rioter\Logger\Formatters\AbstractFormatter;
use Psr\Log\LogLevel;


abstract class AbstractAdapter implements AdapterInterface
{

    /**
     * Min log level | LogLevel::DEBUG
     *
     * @var int
     */
    private $minLevel = 7;

    /**
     * Max log level | LogLevel::EMERGENCY
     *
     * @var int
     */
    private $maxLevel = 0;


    /**
     * Formatter
     *
     * @var
     */
    protected $formatter;

    /**
     * Adapter name
     *
     * @var string
     */
    private $adapterName = '';


    /**
     * Checks the log level is handled with adaptor
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
     * Set min and max log levels for this adapter
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
     * Set formatter
     *
     * @param AbstractFormatter $formatter
     */
    protected function setFormatter(AbstractFormatter $formatter)
    {
        $this->formatter = $formatter;
    }

    /**
     * Get formatting message
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
     * Set dateformat
     *
     * @param $format
     */
    public function setDateFormat($format)
    {
        $this->formatter->setDateFormat($format);
    }

    /**
     * Get dateformat
     *
     * @return mixed
     */
    public function getDateFormat()
    {
        return $this->formatter->getDateFormat();
    }

    /**
     * Set adapter name
     *
     * @param $adapterName
     */
    public function setAdapterName($adapterName)
    {
        $this->adapterName = $adapterName;
    }

    /**
     * Get adapter name
     *
     * @return string
     */
    public function getAdapterName()
    {
        return $this->adapterName;
    }

    /**
     * Abstract method to save log
     *
     * @param $level
     * @param $message
     * @param array $context
     * @return mixed
     */
    abstract public function save($level, $message, array $context = array());

}