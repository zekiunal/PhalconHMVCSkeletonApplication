<?php
use \Phalcon\Mvc\Router;

/**
 * @created 2014-03-24 03:50
 * @author Zeki UNAL <zekiunal@gmail.com>
 * @return \Phalcon\Mvc\Router\Annotations
 * @name routers
 */
$di['router'] = function() {
    //Use the annotations router
    $router = new \Phalcon\Mvc\Router(false);
    $router->removeExtraSlashes(true);

    $router->add(
        '/',
        array(
            'module'     => 'welcome',
            'controller' => 'index',
            'action'     => 'index'
        )
    );

    $router->add(
        '/private',
        array(
            'module'     => 'welcome',
            'controller' => 'index',
            'action'     => 'private'
        )
    );

    /**********************************************************************************************************************/

    $router->notFound(
        array(
            'module'     => 'system',
            'controller' => 'error',
            'action'     => 'notFound'
        )
    );

    $router->add(
        '/401',
        array(
            'module'        => 'system',
            'controller'    => 'error',
            'action'        => 'unauthorized'
        )
    );

    /**********************************************************************************************************************/

    return $router;
};

return $di['router'];