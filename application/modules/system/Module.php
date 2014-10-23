<?php
namespace Modules\System;

use Project\Phalcon\Mvc\Module as ModuleBase;

/**
 * @author      Zeki Unal <zekiunal@gmail.com>
 * @description
 *
 * @package     MModules\System
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
            'Modules\System\Controllers' => $this->path . '/controllers/',
            'Modules\System\Models'      => $this->path . '/models/'
        );
        $this->default_namespace = 'Modules\System\Controllers';
    }
}
