<?php
namespace Modules\System\Controllers;

use \Project\Phalcon\Mvc\Controller;

/**
 * @author      Zeki Unal <zekiunal@gmail.com>
 * @description
 *
 * @package     Modules\System\Controllers
 * @name        ErrorController
 * @version     0.1
 */
class ErrorController extends Controller
{
    public function initialize()
    {
        parent::initialize();
    }

    public function notFoundAction()
    {
        $this->response->setStatusCode(404, 'The server has not found anything matching the Request-URI.');
    }

    public function unauthorizedAction()
    {
        $this->response->setStatusCode(401, 'The request requires user authentication.');
    }
}
