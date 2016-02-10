<?php

namespace Rioter\Logger\Adapters;

use Psr\Log\LogLevel;


class NullAdapter extends AbstractAdapter
{
    public function save($level, $message, array $context = array())
    {
    }
}