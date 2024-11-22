<?php

namespace Tests\Unit\Formatter;

use PlentyMarkets\Logger\Formatter\JsonFormatter;
use PlentyMarkets\Logger\LogLevel;
use PlentyMarkets\Logger\LogRecord;
use Tests\Unit\TestCase;

class JsonFormatterTest extends TestCase {
    public function test_it_formats_with_default_format(){
        $timestamp = new \DateTimeImmutable('2024-11-20 22:07:05');
        $record = new LogRecord(LogLevel::DEBUG, 'test', ['user_id'=>'1'], $timestamp);
        $formatter = new JsonFormatter();
        $this->assertArrayIsEqualToArrayIgnoringListOfKeys([
            'level' => 'DEBUG',
            'message' => 'test',
            'context' => ['user_id'=>'1'],
            'timestamp' => '2024-11-20 22:07:05'
        ],json_decode($formatter->format($record),true), []);
    }
}