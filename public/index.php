<?php
require_once 'setup.php';

use Phalcon\Mvc\Application;

try {

    $configuration_path = dirname(dirname(__FILE__)).'/application/config/';
    require_once $configuration_path."namespaces.php";

    $di             = require_once $configuration_path.'services.php';
    $modules        = require_once $configuration_path.'modules.php';
    $di['router']   = require_once $configuration_path.'routers.php';

    /**
     * Handle the request
     */
    $application = new Application($di);

    /**
     * Register application modules
     */
    $application->registerModules($modules);

    /**
     * The core of all the work of the controller occurs when handle() is invoked:
     */
    echo $application->handle()->getContent();

} catch (\Phalcon\Exception $e) {
    echo get_class($e), ": ", $e->getMessage(), "\n";
    echo " File=", $e->getFile(), "\n";
    echo " Line=", $e->getLine(), "\n";
    echo $e->getTraceAsString();
} catch (\Exception $e) {
    echo get_class($e), ": ", $e->getMessage(), "\n";
    echo " File=", $e->getFile(), "\n";
    echo " Line=", $e->getLine(), "\n";
    echo $e->getTraceAsString();
}
