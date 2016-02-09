<?php

namespace Rioter\Logger\Adapters;

use DateTime;
use RuntimeException;


class FileAdapter extends AbstractAdapter
{
    /**
     * FileAdapter constructor.
     * @param $filename
     */
    public function __construct($filename)
    {
        $this->filename = $filename;
    }

    /**
     * Get date with microtime
     *
     * @return string
     */
    private function getTimestamp()
    {
        $originalTime = microtime(true);
        $micro = sprintf("%06d", ($originalTime - floor($originalTime)) * 1000000);
        $date = new DateTime(date('Y-m-d H:i:s.'.$micro, $originalTime));
        return $date->format('Y-m-d G:i:s.u');
    }

    /**
     * Log in file
     *
     * @param mixed $level
     * @param string $message
     * @param array $context
     */
    public function log($level, $message, array $context = array())
    {
        $line = '['.$this->getTimestamp().'] ['.$level.'] '.$this->interpolate($message, $context).PHP_EOL;
        if (file_put_contents($this->filename, $line, FILE_APPEND | LOCK_EX) === false) {
            throw new RuntimeException('Unable to write to the log file.');
        }
    }

}
