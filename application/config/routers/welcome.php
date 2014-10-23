<?php
/**
 * @author      Zeki Unal <zekiunal@gmail.com>
 * @description
 *
 * @package
 * @name        routers/welcome.php
 * @version     0.1
 */
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
