<?php
namespace Modules\Welcome\Plugins;

use Project\Phalcon\Plugins\Security as SecurityBase;

class Security extends SecurityBase
{
    /**
     * @param \Phalcon\DI\FactoryDefault $di
     */
    public function __construct($di)
    {
        parent::__construct($di);
        $this->private_resources = array(
            'index' => array('private'),
        );
        $this->public_resources = array(
            'index' => array('index')
        );
    }
}