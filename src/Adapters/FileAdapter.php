<?php

namespace Rioter\Logger\Adapters;

use Psr\Log\LogLevel;
use RuntimeException;
use Rioter\Logger\Formatters\LineFormatter;


class FileAdapter extends AbstractAdapter
{
    // файл для использования по умолчанию, если не задан уровень логирования
    protected $file;
    private $defaultPermissions = 0777;

    // Имена файлов для использования различных уровней логирования
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

    //
    public function __construct($file, $level = logLevel::DEBUG, $pattern = '' )
    {
        $this->file = $file;
        $this->setLevel($level);
        $pattern = $pattern ?: "{date}: [{level}] Message: {message}\n";

        $formatter = new LineFormatter($pattern);
        $this->setFormatter($formatter);
    }

    // задать для определнного уровня свой файл для логирования
    public function setLogLevelFile($level, $filename)
    {
        if (is_array($level)) {
            foreach($level as $logLevel) {
                $this->filenameLevels[$logLevel] = $filename;
            }
        } else {
            $this->filenameLevels[$level] = $filename;
        }
    }


    public function getLogLevelFiles()
    {
        return $this->filenameLevels;
    }


    // Записывает лог в файл
    public function save($level, $message, array $context = array())
    {
        //имя файла, сначала смотрим есть ли для опр правила свой путь,
        // если нет берем то что задали при создании обьекта
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

