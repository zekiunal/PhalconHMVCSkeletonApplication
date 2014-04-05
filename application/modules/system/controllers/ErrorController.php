<?php
namespace Modules\System\Controllers;

use \Project\Phalcon\Mvc\Controller;

/**
 * @package Modules\System\Controllers
 * @author Zeki UNAL <zekiunal@gmail.com>
 * @created 2014-03-24 03:12
 * @name ErrorController
 */
class ErrorController extends Controller
{
    public function initialize()
    {
        parent::initialize();
    }

    public function notFoundAction()
    {
        $this->response->setStatusCode(404,'The server has not found anything matching the Request-URI.');
    }

    public function unauthorizedAction()
    {
        $this->response->setStatusCode(401,'The request requires user authentication.');
    }
}
