<?php

namespace PlentyMarkets\Logger\Handler;

use PlentyMarkets\Logger\LogRecord;

interface HandlerInterface
{
    /**
     * Checks whether the given record will be handled by this handler.
     * @return bool
     */
    public function isHandling(LogRecord $record):bool;

    /**
     * Handles a record.
     * @return bool
     */
    public function handle(LogRecord $record):bool;

    public function close():void;
}