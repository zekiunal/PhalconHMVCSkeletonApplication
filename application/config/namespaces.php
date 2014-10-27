<?php
use \Phalcon\Loader;

/**
 * @author      Zeki Unal <zekiunal@gmail.com>
 * @description
 *
 * @package
 * @name        namespaces .php
 * @version     0.1
 */
$loader = new Loader();
$loader->registerNamespaces(
    array(
        'Project' => '../application/library/Project',
        'Phalcon' => '../vendor/Phalcon',
    )
);
$loader->registerDirs(
    array(
        '../application/plugins',
    )
);

$loader->register();
