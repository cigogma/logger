<?php

namespace PlentyMarkets\Logger;


use DateTimeImmutable;

class FormattedLogRecord extends LogRecord {
    
    public function __construct(public LogLevel $level, public string $message, public $formatted, public array $context = [] ,public $timestamp = new DateTimeImmutable())
    {
    }

    public static function fromRecord(LogRecord $record, $formatted){
        return new self($record->level, $record->message, $formatted, $record->context, $record->timestamp);
    }

    public function toArray()
    {
        return array_merge(parent::toArray(), [
            'formatted' => $this->formatted,
        ]);
    }
}