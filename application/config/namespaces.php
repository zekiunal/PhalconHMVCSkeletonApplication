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

/** Composer Autoload */
require_once '../vendor/autoload.php';

$loader = new Loader();
$loader->registerNamespaces(
    array(
        'Project' => '../application/library/Project'
    )
);
$loader->registerDirs(
    array(
        '../application/plugins',
    )
);

$loader->register();
