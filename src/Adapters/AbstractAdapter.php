<?php

namespace Rioter\Logger\Adapters;

use Rioter\Logger\Logger;
use Psr\Log\LogLevel;


abstract class AbstractAdapter implements AdapterInterface
{
    public function save($level, $message, array $context = array())
    {
        // TODO: Implement save() method.
    }

}