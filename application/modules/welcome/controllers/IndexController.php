<?php
namespace Modules\Welcome\Controllers;

use \Project\Phalcon\Mvc\Controller;

/**
 * @author      Zeki Unal <zekiunal@gmail.com>
 * @description
 *
 * @package     Modules\Welcome\Controllers
 * @name        IndexController
 * @version     0.1
 */
class IndexController extends Controller
{
    public function initialize()
    {
        parent::initialize();
        //$this->session->set('auth',1);
        //$this->session->destroy();
    }

    public function indexAction()
    {

    }

    public function privateAction()
    {
    }

    public function aboutAction()
    {
        echo "Hello About Us";
    }
}
