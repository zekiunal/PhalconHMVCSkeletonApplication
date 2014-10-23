<?php
namespace Modules\System;

use Project\Phalcon\Mvc\Module as ModuleBase;

/**
 * @package Modules\System
 * @author  Zeki UNAL <zekiunal@gmail.com>
 * @created 2014-03-24 03:08
 * @name Module
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
