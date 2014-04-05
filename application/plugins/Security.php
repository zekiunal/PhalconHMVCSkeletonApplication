<?php
use \Phalcon\Events\Event;
use \Phalcon\Mvc\User\Plugin;
use \Phalcon\Mvc\Dispatcher;
use \Phalcon\Acl;

/**
 * @package Plugins
 * @author Zeki UNAL <zekiunal@gmail.com>
 * @created 2014-03-24 03:12
 * @name Security
 */
class Security extends Plugin
{
    public function __construct($dependencyInjector)
    {
        $this->_dependencyInjector = $dependencyInjector;
    }




} 