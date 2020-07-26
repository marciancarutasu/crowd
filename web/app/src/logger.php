<?php
namespace Acme;

class Logger {
    function __construct() {
        $log = new Monolog\Logger('name');
        $log->pushHandler(new Monolog\Handler\StreamHandler('app.log', Monolog\Logger::WARNING));
        $log->addWarning('Foo');
    }

}
