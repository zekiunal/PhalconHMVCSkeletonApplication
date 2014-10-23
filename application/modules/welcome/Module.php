<?php
namespace Modules\Welcome;

use Modules\Welcome\Plugins\Security;
use Project\Phalcon\Mvc\Module as ModuleBase;

use Phalcon\DI\FactoryDefault;
use Phalcon\Loader;
use Phalcon\Mvc\Dispatcher;
use Phalcon\Mvc\View;

/**
 * @author      Zeki Unal <zekiunal@gmail.com>
 * @description
 *
 * @package     Modules\Welcome
 * @name        Module
 * @version     0.1
 */
class Module extends ModuleBase
{
    public function __construct()
    {
        parent::__construct();
        $this->path = __DIR__;
        $this->namespace = array(
            'Modules\Welcome\Controllers' => $this->path . '/controllers/',
            'Modules\Welcome\Models'      => $this->path . '/models/',
            'Modules\Welcome\Plugins'     => $this->path . '/plugins/',
            'Modules\Users\Models'        => '../application/modules/users/models/',
            'Modules\Products\Models'     => '../application/modules/products/models/',
            'Modules\Categories\Models'   => '../application/modules/categories/models/'
        );
        $this->default_namespace = 'Modules\Welcome\Controllers';
    }

    /**
     * @param \Phalcon\DI\FactoryDefault $di
     */
    public function registerServices($di)
    {
        parent::registerServices($di);
        parent::registerSecurityEvent($di, new Security($di));
    }
}
