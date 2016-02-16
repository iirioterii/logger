<?php

namespace Rioter\Logger\Adapters;


class NullAdapter extends AbstractAdapter
{

    /**
     * save to anywhere
     *
     * @param $level
     * @param $message
     * @param array $context
     */
    public function save($level, $message, array $context = array())
    {
    }

}