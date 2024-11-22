<?php

namespace PlentyMarkets\Logger;


use DateTimeImmutable;

class LogRecord {

    public function __construct(public LogLevel $level, protected string $message, protected array $context = [], protected $timestamp = new DateTimeImmutable())
    {
    }

    public function toArray()
    {
        return [
            'level' => $this->level->toName(),
            'message' => $this->message,
            'context' => $this->context,
            'timestamp' => $this->timestamp,
        ];
    }
}