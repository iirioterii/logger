<?php

namespace Rioter\Logger\Adapters;


interface AdapterInterface
{

    /**
     * Save log
     *
     * @param $level
     * @param $message
     * @param array $context
     * @return mixed
     */
    public function save($level, $message, array $context = array());

}