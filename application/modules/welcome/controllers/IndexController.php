<?php
namespace Modules\Welcome\Controllers;

use \Project\Phalcon\Mvc\Controller;

/**
 * @package Modules\Welcome\Controllers
 * @author Zeki UNAL <zekiunal@gmail.com>
 * @created 2014-03-24 03:12
 * @name IndexController
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
}
