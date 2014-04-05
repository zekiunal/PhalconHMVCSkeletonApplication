<?php
defined('APPLICATION_ENV') || define('APPLICATION_ENV', (getenv('APPLICATION_ENV') ? getenv('APPLICATION_ENV') : 'stage'));
try {
    $configuration_path = dirname(dirname(__FILE__)).'/application/config/';
    include $configuration_path."namespaces.php";

    $di             = include $configuration_path.'services.php';
    $modules        = include $configuration_path.'modules.php';
    $di['router']   = include $configuration_path.'routers.php';

    /**
     * Handle the request
     */
    $application = new \Phalcon\Mvc\Application($di);

    /**
     * Register application modules
     */
    $application->registerModules($modules);

    /**
     * The core of all the work of the controller occurs when handle() is invoked:
     */
    echo $application->handle()->getContent();

} catch(\Exception $e) {
    echo get_class($e), ": ", $e->getMessage(), "\n";
    echo " File=", $e->getFile(), "\n";
    echo " Line=", $e->getLine(), "\n";
    echo $e->getTraceAsString();
}
