<?php
use Phalcon\Mvc\Url;
use Phalcon\Flash\Direct;
use Phalcon\DI\FactoryDefault;
use Phalcon\Config\Adapter\Ini;
use Phalcon\Session\Adapter\Files;

/**
 * The FactoryDefault Dependency Injector automatically register
 * the right services providing a full stack framework
 */
$di = new FactoryDefault();

/**
 * The URL component is used to generate all kind of urls in the application
 */
$di->set(
    'url',
    function () {
        $url = new Url();
        $url->setBaseUri('/');
        return $url;
    }
);


$di->setShared(
    'config',
    function () {
        return new Ini("../application/config/ini/" . APPLICATION_ENV . ".ini");
    }
);

$di->setShared(
    'session',
    function () {
        $session = new Files();
        $session->start();
        return $session;
    }
);

//Register the flash service with custom CSS classes
$di->set(
    'flash',
    function () {
        $flash = new Direct(
            array(
                'error'   => 'alert alert-warning',
                'success' => 'alert alert-success',
                'notice'  => 'alert alert-info',
                'warning' => 'alert alert-danger'
            )
        );
        return $flash;
    }
);

/*******************************************************/

return $di;
