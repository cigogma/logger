<?php

include './../vendor/autoload.php';

$logger = new \PlentyMarkets\Logger\Logger([new PlentyMarkets\Logger\Handler\StreamHandler('php://stdout')]);

$logger->info('Hello World');
