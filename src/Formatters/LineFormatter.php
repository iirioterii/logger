<?php

namespace Rioter\Logger\Formatters;


class LineFormatter extends AbstractFormatter
{

    /**
     * Pattern for formatter
     *
     * @var
     */
    protected $pattern;

    /**
     * LineFormatter constructor.
     * @param $pattern
     */
    public function __construct($pattern)
    {
        $this->pattern = $pattern;
    }

    /**
     * format output string message
     *
     * @param $level
     * @param $message
     * @param array $context
     * @return string
     */
    public function format($level, $message, array $context = array())
    {

        // normalize message
        if ($context['placeholder']) {
            $message = $this->interpolate($message, $context['placeholder']);
        }
        // array of placeholder for output string
        $replace = array(
            '{level}' => strtoupper($level),
            '{message}' => $message,
            '{date}' => $this->getDateTime(),
            '{line}' => __LINE__,
            '{file}' => __FILE__
        );
        // replace pattern to values
        return strtr($this->pattern, $replace);
    }

    /**
     * Replace placeholders with context
     *
     * @param $message
     * @param array $context
     * @return string
     */
    protected function interpolate($message, array $context)
    {
        $replace = array();
        foreach ($context as $key => $data) {
            $replace['{'.$key.'}'] = $data;
        }
        return strtr($message, $replace);
    }


}