<?php

namespace PlentyMarkets\Logger\Handler;

use PlentyMarkets\Logger\FormattedLogRecord;
use PlentyMarkets\Logger\Formatter\FormatterInterface;
use PlentyMarkets\Logger\Formatter\LineFormatter;
use PlentyMarkets\Logger\LogLevel;
use PlentyMarkets\Logger\LogRecord;

abstract class Handler implements HandlerInterface
{
    protected LogLevel $level = LogLevel::DEBUG;

    protected FormatterInterface|null $formatter = null;

    /**
     * @param int|string|LogLevel $level The minimum logging level at which this handler will be triggered
     */
    public function __construct(int|string|LogLevel $level = LogLevel::DEBUG)
    {
        $this->setLevel($level);
    }

    public function close():void
    {
    }

    /**
     * @inheritDoc
     */
    public function isHandling(LogRecord $record): bool
    {
        return $record->level->value >= $this->level->value;
    }


    public function setLevel(int|string|Level $level): self
    {
        $this->level = LogLevel::parse($level);

        return $this;
    }

    public function getLevel(): LogLevel
    {
        return $this->level;
    }

    public function handle(LogRecord $record): bool
    {
        if (!$this->isHandling($record)) {
            return false;
        }

        $formattedRecord = FormattedLogRecord::fromRecord($record,$this->getFormatter()->format($record));
        $this->write($formattedRecord);

        return true;
    }

    /**
     * Write
     */
    abstract protected function write(FormattedLogRecord $record): void;

    public function __destruct()
    {
        trY{
            $this->close();
        } catch (\Exception $e) {
            // do nothing
        }
    }



    /**
     * @inheritDoc
     */
    public function setFormatter(FormatterInterface $formatter): HandlerInterface
    {
        $this->formatter = $formatter;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getFormatter(): FormatterInterface
    {
        if (null === $this->formatter) {
            $this->formatter = $this->getDefaultFormatter();
        }

        return $this->formatter;
    }

    /**
     * Gets the default formatter.
     */
    private function getDefaultFormatter(): FormatterInterface
    {
        return new LineFormatter();
    }
}