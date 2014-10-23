<?php
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
