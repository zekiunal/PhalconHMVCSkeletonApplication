<?php
namespace Modules\Welcome;
use Modules\Welcome\Plugins\Security;
use Project\Phalcon\Mvc\Module as ModuleBase;

use Phalcon\DI\FactoryDefault;
use Phalcon\Loader;
use Phalcon\Mvc\Dispatcher;
use Phalcon\Mvc\View;

/**
 * @package Modules\Welcome
 * @author Zeki UNAL <zekiunal@gmail.com>
 * @created 2014-03-24 03:08
 * @name Module
 */
class Module extends ModuleBase
{
    public function __construct()
    {
        $this->path = __DIR__;

        $this->namespace = array(
            'Modules\Welcome\Controllers' => $this->path . '/controllers/',
            'Modules\Welcome\Models'      => $this->path . '/models/',
            'Modules\Welcome\Plugins'     => $this->path . '/plugins/'
        );
        $this->default_namespace = 'Modules\Welcome\Controllers';
        $this->template = 'welcome';
    }

    /**
     * @param \Phalcon\DI\FactoryDefault $di
     */
    public function registerServices($di)
    {
        parent::registerServices($di);
        /**
         * @return Dispatcher
         */
        $di->set('dispatcher', function() use ($di) {
            //Obtain the standard eventsManager from the DI
            $eventsManager = $di->getShared('eventsManager');

            //Instantiate the Security plugin
            $security = new Security($di);

            //Listen for events produced in the dispatcher using the Security plugin
            $eventsManager->attach('dispatch', $security);

            $dispatcher = new Dispatcher();
            $dispatcher->setDefaultNamespace($this->default_namespace);

            //Bind the EventsManager to the Dispatcher
            $dispatcher->setEventsManager($eventsManager);

            return $dispatcher;
        });
    }
}
