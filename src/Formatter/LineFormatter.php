<?php

namespace PlentyMarkets\Logger\Formatter;

use PlentyMarkets\Logger\LogLevel;
use PlentyMarkets\Logger\LogRecord;

class LineFormatter implements FormatterInterface
{
    public const DEFAULT_FORMAT = "[%timestamp%] %level%: %message% %context% \n";

    protected string $format;

    /**
     * @param string|null $format Format structure
     */
    public function __construct(?string $format = null)
    {
        $this->format = $format === null ? static::DEFAULT_FORMAT : $format;
    }

    /**
     * @inheritDoc
     */
    public function format(LogRecord $record): string
    {
        $result = $this->format;
        foreach($record->toArray() as $key => $value){
            $result = str_replace("%$key%", $this->stringify($value), $result);
        }
        return $result;
    }


    /**
     * @param mixed $value
     */
    public function stringify($value): string
    {
        return $this->convertToString($value);
    }

    /**
     * @param mixed $data
     */
    protected function convertToString($data): string
    {
        if($data instanceof \DateTimeImmutable){
            return $data->format('Y-m-d H:i:s');
        }
        if($data instanceof LogLevel){
            return $data->toName();
        }
        if(\is_string($data)){
            return $data;
        }
        if (\is_scalar($data)) {
            return (string) $data;
        }
        if (null === $data || \is_bool($data)) {
            return $data?"true":"false";
        }
        return json_encode($data);
    }

}