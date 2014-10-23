<?php
namespace Modules\Welcome\Plugins;

use Project\Phalcon\Plugins\Security as SecurityBase;

/**
 * @author      Zeki Unal <zekiunal@gmail.com>
 * @description
 *
 * @package     Modules\Welcome\Plugins
 * @name        Security
 * @version     0.1
 */
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