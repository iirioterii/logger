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
Create object of FileAdapter class and set path and name to log file, and if you want set min level (default 'debug')

```php

$fileAdapter = new \Rioter\Logger\Adapters\FileAdapter('logs/log.txt', 'info');
```

Create object of main logger, and set adapter;
```php
$logger = new \Rioter\Logger\Logger($fileAdapter);
```

Set logs, context, use placeholder how in example
```php
$logger->error('message of errors');
$logger->critical('critical of errors);
$logger->debug('debug of errors {id} {line} {file}', array('id'=>1, 'line'=>__LINE__, 'file' => __FILE__));
$logger->warning('warning', array('id'=>1));

```

Output:
```no-highlight
2016-02-10 23:54:40.436207: [ERROR] Message: message of errors 1
2016-02-10 23:54:40.436633: [CRITICAL] Message: critical of errors 1
2016-02-10 23:54:40.436866: [DEBUG] Message: debug of errors 1 22 /home/iirioterii/server/logger/index.php
2016-02-10 23:54:40.437079: [WARNING] Message: warning
```
