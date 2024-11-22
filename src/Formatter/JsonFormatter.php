<?php

namespace PlentyMarkets\Logger\Formatter;

use PlentyMarkets\Logger\LogRecord;

class JsonFormatter implements FormatterInterface
{
    public function __construct()
    {
    }

    /**
     * @inheritDoc
     */
    public function format(LogRecord $record): string
    {
        return json_encode($this->mapFields($record->toArray()));
    }

    /**
     * Method used to map fields for different requirements by extending the class.
     * @param $fields
     * @return array
     */
    public function mapFields($fields): array{
        return array_merge($fields,['timestamp' => $fields['timestamp']->format('Y-m-d H:i:s')]);
    }

}