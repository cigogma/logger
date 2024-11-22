<?php

namespace Tests\Unit\Formatter;

use PlentyMarkets\Logger\Formatter\LineFormatter;
use PlentyMarkets\Logger\LogLevel;
use PlentyMarkets\Logger\LogRecord;
use Tests\Unit\TestCase;

class LineFormatterTest extends TestCase {
    public function test_it_formats_with_default_format(){
        $timestamp = new \DateTimeImmutable('2024-11-20 22:07:05');
        $record = new LogRecord(LogLevel::DEBUG, 'test', ['user_id'=>'1'], $timestamp);
        $formatter = new LineFormatter();
        $this->assertEquals("[2024-11-20 22:07:05] DEBUG: test {\"user_id\":\"1\"} \n", $formatter->format($record));
    }

    public function test_it_formats_with_custom_format(){
        $timestamp = new \DateTimeImmutable('2024-11-20 22:07:05');
        $record = new LogRecord(LogLevel::DEBUG, 'test', ['user_id'=>'1'], $timestamp);
        $formatter = new LineFormatter("abc %level% %message% def");
        $this->assertEquals("abc DEBUG test def", $formatter->format($record));
    }
}