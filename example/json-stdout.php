<?php

include './../vendor/autoload.php';

$streamHandler = new PlentyMarkets\Logger\Handler\StreamHandler('php://stdout');
$streamHandler->setFormatter(new \PlentyMarkets\Logger\Formatter\JsonFormatter());
$logger = new \PlentyMarkets\Logger\Logger([$streamHandler]);
$logger->info('Hello World');