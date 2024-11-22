<?php

namespace PlentyMarkets\Logger\Handler;

use PlentyMarkets\Logger\FormattedLogRecord;
use PlentyMarkets\Logger\LogLevel;

class StreamHandler extends Handler
{
    /**
     * @var string file path url
     */
    private $url;
    /**
     * @var resource
     */
    protected $stream;

    protected bool $dirCreated = false;

    protected string $errorMessage;
    public function __construct(
        $stream,
        int|string|LogLevel $level = LogLevel::DEBUG,
        protected ?int $filePermission = null,
        protected string $fileOpenMode = 'a'
    ){
        $this->level = LogLevel::parse($level);
        if (\is_resource($stream)) {
            $this->stream = $stream;

            stream_set_chunk_size($this->stream, 1024 * 1024);
        } elseif (\is_string($stream)) {
            $this->url = $stream;
        } else {
            throw new \InvalidArgumentException('A stream must either be a resource or a string.');
        }

    }
    protected function write(FormattedLogRecord $record): void
    {
        if (!\is_resource($this->stream)) {
            $url = $this->url;
            if (null === $url || '' === $url) {
                throw new \LogicException('Stream is empty or not valid. ');
            }
            $this->createDir($url);

            try {
                $stream = fopen($url, $this->fileOpenMode);
                if ($this->filePermission !== null) {
                    @chmod($url, $this->filePermission);
                }
            } finally {
                restore_error_handler();
            }
            if (!\is_resource($stream)) {
                $this->stream = null;
                throw new \UnexpectedValueException('Stream is not a valid resource.');
            }
            $this->stream = $stream;
        }

        $stream = $this->stream;
        $this->streamWrite($stream, $record);
    }


    /**
     * Write to stream
     * @param resource $stream
     */
    protected function streamWrite($stream, FormattedLogRecord $record): void
    {
        fwrite($stream, (string) $record->formatted);
    }


    private function getDirFromStream(string $stream): ?string
    {
        $pos = strpos($stream, '://');
        if ($pos === false) {
            return \dirname($stream);
        }

        if ('file://' === substr($stream, 0, 7)) {
            return \dirname(substr($stream, 7));
        }

        return null;
    }

    private function createDir(string $url): void
    {
        $dir = $this->getDirFromStream($url);
        if (null !== $dir && !is_dir($dir)) {
            $this->errorMessage = null;

            $status = mkdir($dir, 0777, true);
            restore_error_handler();
            if (false === $status && !is_dir($dir) && strpos((string) $this->errorMessage, 'File exists') === false) {
                throw new \UnexpectedValueException(sprintf('There is no existing directory at "%s" and it could not be created: '.$this->errorMessage, $dir));
            }
        }
        $this->dirCreated = true;
    }
}