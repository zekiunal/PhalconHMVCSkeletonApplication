<?php
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
