<?php

namespace Rioter\Logger\Adapters;

use Psr\Log\LogLevel;
use Rioter\Logger\Models\Log;
use Rioter\Logger\Formatters\LineFormatter;


class DBAdapter extends AbstractAdapter
{
    private $log;

    public function __construct($level = logLevel::DEBUG)
    {
        $this->setLevel($level);
        $formatter = new LineFormatter("Message: {message}");
        $this->setFormatter($formatter);
        $this->log = new Log();

    }

    /**
     * @param $level
     * @param $message
     * @param array $context
     * @return mixed
     */
    public function save($level, $message, array $context = array())
    {

        $context = array('placeholder' => $context);
        $log = $this->format($level, $message, $context);
        var_dump($log);
        $this->log->level = $level;
        $this->log->message = $log;
        //$this->log->save();
        var_dump($this->log->save());
    }

}