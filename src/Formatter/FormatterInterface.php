<?php

namespace PlentyMarkets\Logger\Formatter;

use PlentyMarkets\Logger\LogRecord;

interface FormatterInterface
{
    /**
     * @param  LogRecord $record
     * @return mixed   result of formatted record
     */
    public function format(LogRecord $record): mixed;
}