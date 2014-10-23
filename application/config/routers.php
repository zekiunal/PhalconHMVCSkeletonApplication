<?php
use \Phalcon\Mvc\Router;

/**
 * @created 2014-03-24 03:50
 * @author  Zeki UNAL <zekiunal@gmail.com>
 * @return \Phalcon\Mvc\Router\Annotations
 * @name routers
 */
$di['router'] = function () {
    $router = new \Phalcon\Mvc\Router(false);
    $router->removeExtraSlashes(true);
    foreach (glob(__DIR__ . "/routers/*.php") as $filename) {
        include_once $filename;
    }
    return $router;
};
return $di['router'];
