<?php
use \Phalcon\Mvc\Router;

$di['router'] = function () {
    $router = new \Phalcon\Mvc\Router(false);
    $router->removeExtraSlashes(true);
    foreach (glob(__DIR__ . "/routers/*.php") as $filename) {
        include_once $filename;
    }
    return $router;
};
return $di['router'];
