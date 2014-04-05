<?php
use \Phalcon\Loader;
/**
 * @author Zeki UNAL <zekiunal@gmail.com>
 * @created 2014-03-24 04:00
 * @name namespaces.php
 */
$loader = new Loader();
$loader->registerNamespaces(
    array(
        'Project' => '../library/Project',
        'Phalcon' => '../vendor/Phalcon',
    )
);
$loader->registerDirs(
    array(
       '../application/plugins',
    )
);

$loader->register();

require_once "functions.php";