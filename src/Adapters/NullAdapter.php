<?php

namespace Rioter\Logger\Adapters;

use Psr\Log\LogLevel;


class NullAdapter extends AbstractAdapter
{
    /**
     * сохраняет в никуда - заглушка
     *
     * @param $level
     * @param $message
     * @param array $context
     */
    public function save($level, $message, array $context = array())
    {
    }
}