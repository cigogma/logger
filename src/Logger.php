<?php

namespace PlentyMarkets\Logger;

use DateTimeImmutable;
use PlentyMarkets\Logger\Handler\HandlerInterface;
use Psr\Log\LoggerInterface;

/**
 * Class Logger
 * @package PlentyMarkets\Logger

 */
class Logger implements LoggerInterface{
    /**
     * Logger constructor.
     * @param HandlerInterface[] $handlers
     */
    public function __construct(protected $handlers = [])
    {
    }

    public function log($level, $message, $context = []): void
    {
        $level = LogLevel::parse($level);
        $record = new LogRecord($level, $message, $context,$datetime ?? new DateTimeImmutable());
        foreach ($this->handlers as $handle) {
            $handle->handle($record);
        }
    }

    public function emergency(\Stringable|string $message, array $context = []): void
    {
        $this->log(LogLevel::EMERGENCY, $message, $context);
    }

    public function alert(\Stringable|string $message, array $context = []): void
    {
        $this->log(LogLevel::ALERT, $message, $context);
    }

    public function critical(\Stringable|string $message, array $context = []): void
    {
        $this->log(LogLevel::CRITICAL, $message, $context);
    }

    public function error(\Stringable|string $message, array $context = []): void
    {
        $this->log(LogLevel::ERROR, $message, $context);
    }

    public function warning(\Stringable|string $message, array $context = []): void
    {
        $this->log(LogLevel::WARNING, $message, $context);
    }

    public function notice(\Stringable|string $message, array $context = []): void
    {
        $this->log(LogLevel::NOTICE, $message, $context);
    }

    public function info(\Stringable|string $message, array $context = []): void
    {
        $this->log(LogLevel::INFO, $message, $context);
    }

    public function debug(\Stringable|string $message, array $context = []): void
    {
        $this->log(LogLevel::DEBUG, $message, $context);
    }
}