<?php

namespace Rioter\Logger\Adapters;

use RuntimeException;


class FileAdapter extends AbstractAdapter
{

    public function __construct($filename)
    {
        $this->filename = $filename;
    }

    public function log($level, $message, array $context = array())
    {
        $line = '['.date('Y-m-d H:i:s').'] ['.$level.'] '.$this->interpolate($message, $context).PHP_EOL;
        if (file_put_contents($this->filename, $line, FILE_APPEND | LOCK_EX) === false) {
            throw new RuntimeException('Unable to write to the log file.');
        }
    }

}
