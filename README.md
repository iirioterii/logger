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

Require autoload

```php
require_once('vendor/autoload.php');
```

Use namespaces

```php
use  Rioter\Logger\Logger;
use Rioter\Logger\Adapters;
```

Available adapters:
```php
$fileAdapter = new Adapters\FileAdapter('logs/log.txt'); / /logging to files
$echoAdapter = new Adapters\EchoAdapter(); // logging to html
$sysLogAdapter = new Adapters\SysLogAdapter('ITCourses'); // logging to syslog
$nullAdapter = new Adapters\NullAdapter(); // log is not saving
```

To set adapter you can use:
```php
$logger->setAdapter($fileAdapter);
$logger->setAdapter($echoAdapter);
$logger->setAdapter($nullAdapter);
```

All adapters methods:
```php
$fileAdapter->setAdapterName('FileAdapter');
$fileAdapter->setDateFormat('Y-m-d H:i:s');
$fileAdapter->setLevel(LogLevel::DEBUG, LogLevel::INFO);
```

##Errors handlers.

Create object of Errorhandler and give him Logger object
```php
$handler = new \Rioter\Logger\ErrorHandler($logger);
```

and register handlers
```php
$handler->regShutdownHandler(); // register shutdown method(last error);
$handler->regExceptionHandler(); // register exception 
$handler->logExceptionHandler($exception); //give exception
$handler->regErrorHandler() //register php errors
```


##Example. Logging to file.

Create object of FileAdapter class and set path and name to log file, also you can set min level of logging (default 'debug')

```php
$fileAdapter = new Adapters\FileAdapter('logs/log.txt');
```

FileAdapter methods:
$fileAdapter->setMethodLogLevelFile(array('error', 'debug'), 'logs/error_debug.txt'); // or you can use array for multiply setting 
$fileAdapter->setMethodLogLevelFile('warning', 'logs/warning.txt'); // set different pathes for each errors log
$fileAdapter->getMethodsLogLevelFiles(); //get pathes and log levels
```

Create object of logger, and set adapter;

```php
$logger = new Logger($fileAdapter);
```

Set logs, context, use placeholder how in example
```php
$logger->error('message of errors');
$logger->critical('critical of errors);
$logger->debug("debug of errors id = {id} LINE: __LINE__ FILE: __FILE__", array('id'=>1);
$logger->warning('warning', array('id'=>1));
```

Output:
```no-highlight
2016-02-10 23:54:40.436207: [ERROR] Message: message of errors 1
2016-02-10 23:54:40.436633: [CRITICAL] Message: critical of errors 1
2016-02-10 23:54:40.436866: [DEBUG] Message: debug of errors id = 1 LINE: 22 FILE: /home/iirioterii/server/logger/index.php
2016-02-10 23:54:40.437079: [WARNING] Message: warning
```

