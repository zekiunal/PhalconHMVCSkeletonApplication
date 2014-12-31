<?php
namespace Project\Phalcon\Plugins;

use Phalcon\Acl\AdapterInterface;
use Phalcon\Acl\Adapter\Memory;
use Phalcon\Mvc\User\Plugin;
use Phalcon\Mvc\Dispatcher;
use Phalcon\Http\Response;
use Phalcon\Events\Event;
use Phalcon\Acl;
use Project\Phalcon\Plugins\Security\Acl\Helper;

/**
 * @author      Zeki Unal <zekiunal@gmail.com>
 * @description
 *
 * @package     Project\Phalcon\Plugins
 * @name        Security
 * @version     0.1
 */
class Security extends Plugin
{
    /**
     * Private area resources
     * 'controller_name' => array('action_name'),
     * @var array
     */
    protected $private_resources = array();

    /**
     * Public area resources
     * 'controller_name' => array('action_name'),
     * @var array
     */
    protected $public_resources = array('index' => array('index'));

    public function __construct($di)
    {
        $this->_dependencyInjector = $di;
    }

    /**
     * @return AdapterInterface
     */
    public function getAcl()
    {
        /**
         * @todo remove
         */
        $this->persistent->destroy();

        if (!isset($this->persistent->acl)) {

            $acl_adaptor = new Memory();
            $acl_adaptor->setDefaultAction(Acl::DENY);

            $acl_helper = new Helper($acl_adaptor, $this->public_resources, $this->private_resources);

            /**
             * The acl is stored in session, APC would be useful here too
             */
            $this->persistent->acl = $acl_helper->initialize()->getAcl();
        }

        return $this->persistent->acl;
    }

    /**
     * @return string
     */
    protected function getActiveRole()
    {
        if ($this->session->get('auth')) {
            $role = 'Users';
        } else {
            $role = 'Guests';
        }
        return $role;
    }

    /**
     * This action is executed before execute any action in the application
     */
    public function beforeDispatch(Event $event, Dispatcher $dispatcher)
    {
        $role = $this->getActiveRole();

        $allowed = $this->getAcl()->isAllowed($role, $dispatcher->getControllerName(), $dispatcher->getActionName());

        if ($allowed != Acl::ALLOW) {
            $this->flash->error(
                "You don't have access to " . $dispatcher->getActionName() .
                " on " . $dispatcher->getModuleName() . " module"
            );
            /*
            $dispatcher->forward(
                array(
                    'controller' => 'index',
                    'action'     => 'index'
                )
            );
            */
            $dispatcher->setActionName('nonexistaction');
            header('location:/401');
        }
    }
}
