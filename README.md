ITCourses framework logger component README
==

**ITCourses framework logger component**


## Installation

Package is available on [Packagist](http://packagist.org/packages/rioter/logger),
you can install it using [Composer](http://getcomposer.org).

```shell
composer require rioter/logger
```

[PHP](https://php.net) 5.5+ 


## Basic Usage


Logging to file.
Create object of FileAdapter class and set path and name to log file.

```php

$fileAdapter = new \Rioter\Logger\Adapters\FileAdapter(__DIR__ . '/logs.log');
```

Set minimal level of logging
```php
$fileAdapter->setMinLevel(Psr\Log\LogLevel::ERROR);
```
Create object of main logger, and set logger;
```php
$logger = new Rioter\Logger\Logger();
$logger->setLogger($fileAdapter);

```
Set log levels, context, use placeholder how in example
```php
$logger->debug('debug');
$logger->error('Error at {filename} at line {line} and var = {id}', array('id' => '10', 'filename' => __FILE__, 'line' => __LINE__));
$logger->emergency('emergency!');

```

Output:
```no-highlight
[2016-02-05 11:06:22.386600] [error] Error at /home/iirioterii/server/logger/index.php at line 12 and var = 10
[2016-02-05 11:06:22.386905] [emergency] emergency!

```
