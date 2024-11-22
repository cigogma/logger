## Logger Example

### Installation
#Install the latest version with

first you have to set up the repository in your composer.json
```json
{
  "repositories": [
    {
      "type": "vcs",
      "url": "https://github.com/cigogma/logger.git"
    }
  ]
}
```
Then we can install the package using the following command.

```bash
composer require plentymarkets/logger
```

### Example

Basic Stdout Usage
```php
$logger = new \PlentyMarkets\Logger\Logger([new PlentyMarkets\Logger\Handler\StreamHandler('php://stdout')]);

$logger->info('Hello World');
```

Custom Format
```php
$streamHandler = new PlentyMarkets\Logger\Handler\StreamHandler('php://stdout');
$streamHandler->setFormatter(new \PlentyMarkets\Logger\Formatter\JsonFormatter())
$logger = new \PlentyMarkets\Logger\Logger([$streamHandler]);
$logger->info('Hello World');
```