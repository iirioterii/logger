<?php

namespace Rioter\Logger\Adapters;

use Psr\Log\LogLevel;
use Rioter\Logger\Formatters\LineFormatter;


class SysLogAdapter extends AbstractAdapter
{

    /**
     * @var
     */
    private $ident;

    /**
     * @var int
     */
    private $facility;

    /**
     * @var int
     */
    private $logopts;

    /**
     * SysLogAdapter constructor.
     * @param $ident
     * @param int $facility
     * @param int $logopts
     * @param string $level
     * @param string $pattern
     */
    public function __construct($ident, $facility = LOG_USER, $logopts = LOG_PID, $level = LogLevel::DEBUG, $pattern = '')
    {
        $this->ident = $ident;
        $this->facility = $facility;
        $this->logopts = $logopts;

        $this->setLevel($level);
        $pattern = $pattern ?: "[{level}] Message: {message} \n";

        $formatter = new LineFormatter($pattern);
        $this->setFormatter($formatter);
    }

    /**
     * @param $level
     * @return int
     */
    private function getSysLogLevel($level)
    {
        switch ($level) {
            case LogLevel::EMERGENCY:
                return LOG_EMERG;
            case LogLevel::ALERT:
                return LOG_ALERT;
            case LogLevel::CRITICAL:
                return LOG_CRIT;
            case LogLevel::ERROR:
                return LOG_ERR;
            case LogLevel::WARNING:
                return LOG_WARNING;
            case LogLevel::NOTICE:
                return LOG_NOTICE;
            case LogLevel::INFO:
                return LOG_INFO;
        }
        return LOG_DEBUG;
    }

    /**
     * @param $level
     * @param $message
     * @param array $context
     * @return mixed
     */
    public function save($level, $message, array $context = array())
    {
        $sysLogLevel = $this->getSyslogLevel($level);
        $context = array('placeholder' => $context);
        $log = $this->format($level, $message, $context);

        if (!openlog($this->ident, $this->logopts, $this->facility)) {
            throw new \RuntimeException('Can\'t open syslog');
        }

        syslog($sysLogLevel, (string)$log);
    }

}