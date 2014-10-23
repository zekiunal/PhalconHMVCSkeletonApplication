<?php
use \Phalcon\Mvc\User\Plugin;
use \Phalcon\Mvc\Dispatcher;
use \Phalcon\Acl;

/**
 * @author      Zeki Unal <zekiunal@gmail.com>
 * @description
 *
 * @package
 * @name        Security
 * @version     0.1
 */
class Security extends Plugin
{
    public function __construct($dependencyInjector)
    {
        $this->_dependencyInjector = $dependencyInjector;
    }
}
