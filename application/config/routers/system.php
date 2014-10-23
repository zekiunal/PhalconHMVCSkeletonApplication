<?php
/**
 * @author      Zeki Unal <zekiunal@gmail.com>
 * @description
 *
 * @package
 * @name        routers/system.php
 * @version     0.1
 */
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
        'module'     => 'system',
        'controller' => 'error',
        'action'     => 'unauthorized'
    )
);
