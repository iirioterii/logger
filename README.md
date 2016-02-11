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

##Logging to file.

Create object of FileAdapter class and set path and name to log file, also you can set min level of logging (default 'debug')

```php
$fileAdapter = new Adapters\FileAdapter('logs/log.txt', 'info');
```

FileAdapter methods:

```php
$fileAdapter->setAdapterName('fileAdapter'); //set adapter's name
$fileAdapter->setDateFormat('H:i:s');      //set date`s format
$fileAdapter->setLevel('debug', 'emergency'); //set min and max log levels
$fileAdapter->setLogLevelFile(array('error', 'debug'), 'logs/error_debug.txt'); // or you can use array for multiply setting 
$fileAdapter->setLogLevelFile('warning', 'logs/warning.txt'); // set different pathes for each errors log
$fileAdapter->getLogLevelFiles(); //get pathes and log levels
```

Create object of logger, and set adapter;

```php
$logger = new Logger($fileAdapter);
```

Set logs, context, use placeholder how in example
```php
$logger->error('message of errors');
$logger->critical('critical of errors);
$logger->debug('debug of errors id = {id} LINE: {line} FILE: {file}', array('id'=>1, 'line'=>__LINE__, 'file' => __FILE__));
$logger->warning('warning', array('id'=>1));
```

Output:
```no-highlight
2016-02-10 23:54:40.436207: [ERROR] Message: message of errors 1
2016-02-10 23:54:40.436633: [CRITICAL] Message: critical of errors 1
2016-02-10 23:54:40.436866: [DEBUG] Message: debug of errors id = 1 LINE: 22 FILE: /home/iirioterii/server/logger/index.php
2016-02-10 23:54:40.437079: [WARNING] Message: warning
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

