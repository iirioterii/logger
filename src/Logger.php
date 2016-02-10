<?php

namespace Rioter\Logger;

use Psr\Log\LoggerInterface;
use Psr\Log\LogLevel;
use Psr\Log\InvalidArgumentException;

use Rioter\Logger\Adapters\AbstractAdapter;

class Logger
{
    // массив с адаптерами для того чтобы сохранять логи
    protected $adapters = [];

    // подсчет количества адаптеров, во время выполнения
    protected $adapterCount = 0;

    // имя логгера
    protected $name;

    // массив с log levels с цифрами
    public static $levels = array(
        LogLevel::EMERGENCY => 0,
        LogLevel::ALERT     => 1,
        LogLevel::CRITICAL  => 2,
        LogLevel::ERROR     => 3,
        LogLevel::WARNING   => 4,
        LogLevel::NOTICE    => 5,
        LogLevel::INFO      => 6,
        LogLevel::DEBUG     => 7
    );
}