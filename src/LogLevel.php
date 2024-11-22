<?php

namespace PlentyMarkets\Logger;

enum LogLevel: int
{
    case DEBUG = 100;
    case INFO = 200;
    case NOTICE = 250;
    case WARNING = 300;
    case ERROR = 400;
    case CRITICAL = 500;
    case ALERT = 550;
    case EMERGENCY = 600;

    public static function parse($level){
        if(gettype($level)==='integer'){
            return static::from($level);
        }
        if($level instanceof \Stringable){
            $stringLevel = strtoupper($level->__toString());
            $level = static::{$stringLevel};
        }
        if(is_string($level)){
            $stringLevel = strtoupper($level);
            $level = static::{$stringLevel};
        }
        if($level instanceof LogLevel){
            return $level;
        }
        throw new \InvalidArgumentException("Invalid log level: $level");
    }

    public function toName(): string
    {
        return match($this){
            LogLevel::DEBUG => 'DEBUG',
            LogLevel::INFO => 'INFO',
            LogLevel::NOTICE => 'NOTICE',
            LogLevel::WARNING => 'WARNING',
            LogLevel::ERROR => 'ERROR',
            LogLevel::CRITICAL => 'CRITICAL',
            LogLevel::ALERT => 'ALERT',
            LogLevel::EMERGENCY => 'EMERGENCY',
        };
    }
}