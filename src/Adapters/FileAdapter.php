<?php

namespace Rioter\Logger\Adapters;

use Psr\Log\LogLevel;
use RuntimeException;
use Rioter\Logger\Formatters\LineFormatter;


class FileAdapter extends AbstractAdapter
{

    /**
     * Default file to logging
     *
     * @var
     */
    private $file;

    /**
     * Default permissions
     *
     * @var int
     */
    private $defaultPermissions = 0777;

    /**
     * Filenames for different log levels
     *
     * @var array
     */
    protected $filenameLevels = array(
        LogLevel::EMERGENCY => '',
        LogLevel::ALERT     => '',
        LogLevel::CRITICAL  => '',
        LogLevel::ERROR     => '',
        LogLevel::WARNING   => '',
        LogLevel::NOTICE    => '',
        LogLevel::INFO      => '',
        LogLevel::DEBUG     => ''
    );

    /**
     * FileAdapter constructor.
     * @param $file
     * @param string $level
     * @param string $pattern
     */
    public function __construct($file, $level = logLevel::DEBUG, $pattern = '' )
    {
        $this->file = $file;
        $this->setLevel($level);
        $pattern = $pattern ?: "{date}: [{level}] Message: {message}\n";

        $formatter = new LineFormatter($pattern);
        $this->setFormatter($formatter);
    }

    /**
     * Set log level and file name for different logging methods
     *
     * @param $level
     * @param $filename
     */
    public function setMethodLogLevelFile($level, $filename)
    {
        if (is_array($level)) {
            foreach($level as $logLevel) {
                $this->filenameLevels[$logLevel] = $filename;
            }
        } else {
            $this->filenameLevels[$level] = $filename;
        }
    }

    /**
     * Get filenames and log levels
     *
     * @return array
     */
    public function getMethodsLogLevelFiles()
    {
        return $this->filenameLevels;
    }

    /**
     * Save log to file
     *
     * @param $level
     * @param $message
     * @param array $context
     * @return bool
     */
    public function save($level, $message, array $context = array())
    {
        // if filenameLevels exist use it, else use default filename to save
        $fileName = $this->filenameLevels[$level] ?: $this->file;
        $context = array('placeholder' => $context);
        $log = $this->format($level, $message, $context);

        $logDirectory = dirname($fileName);

        if (!file_exists($logDirectory)) {
            if (@mkdir($logDirectory, $this->defaultPermissions, true) === false) {
                throw new RuntimeException('Failed to create log directory');
             }
        }

        if (file_put_contents($fileName, $log, FILE_APPEND | LOCK_EX) === false) {
            throw new RuntimeException('Failed to write log file');
        }

        return true;
    }

}

