<?php

namespace Rioter\Logger\Adapters;


class DBAdapter extends AbstractAdapter
{

    public function __construct()
    {
    }

    /**
     * @param $level
     * @param $message
     * @param array $context
     * @return mixed
     */
    public function save($level, $message, array $context = array())
    {
        // TODO: Implement save() method.
    }

}