<?php

namespace Rioter\Logger\Adapters;


interface AdapterInterface
{
    /**
     * метод который будет вызываться логгером для сохранения лога
     *
     * @param $level
     * @param $message
     * @param array $context
     * @return mixed
     */
    public function save($level, $message, array $context = array());
}