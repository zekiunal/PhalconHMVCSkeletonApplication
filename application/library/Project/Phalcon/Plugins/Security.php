<?php
namespace Project\Phalcon\Plugins;

use \Phalcon\Acl\Adapter\Memory;
use Phalcon\Http\Response;
use \Phalcon\Mvc\User\Plugin;
use \Phalcon\Mvc\Dispatcher;
use \Phalcon\Events\Event;
use \Phalcon\Acl\Resource;
use \Phalcon\Acl\Role;
use \Phalcon\Acl;

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
    protected $public_resources = array('index'=> array('index'));

    /**
     * Register roles
     */
    protected $roles;

    public function __construct($di)
    {
        $this->_dependencyInjector = $di;
        $this->roles = array(
            'users' => new Role('Users'),
            'guests' => new Role('Guests')
        );
    }

    public function getAcl()
    {
        /**
         * @todo sil
         */
        $this->persistent->destroy();
        if (!isset($this->persistent->acl)) {
            $acl = new Memory();
            $acl->setDefaultAction(Acl::DENY);
            foreach ($this->roles as $role) {
                $acl->addRole($role);
            }

            foreach ($this->private_resources as $resource => $actions) {
                $acl->addResource(new Resource($resource), $actions);
            }
            //Grant access to private area to role Users
            foreach ($this->private_resources as $resource => $actions) {
                foreach ($actions as $action){
                    $acl->allow('Users', $resource, $action);
                }
            }

            foreach ($this->public_resources as $resource => $actions) {
                $acl->addResource(new Resource($resource), $actions);
            }
            //Grant access to public areas to both users and guests
            foreach ($this->roles as $role) {
                foreach ($this->public_resources as $resource => $actions) {
                    $acl->allow($role->getName(), $resource, $actions);
                }
            }

            //The acl is stored in session, APC would be useful here too
            $this->persistent->acl = $acl;
        }

        return $this->persistent->acl;
    }

    /**
     * This action is executed before execute any action in the application
     */
    public function beforeDispatch(Event $event, Dispatcher $dispatcher)
    {
        if (!$this->session->get('auth')) {
            $role = 'Guests';
        } else {
            $role = 'Users';
        }

        $allowed = $this->getAcl()->isAllowed($role, $dispatcher->getControllerName(), $dispatcher->getActionName());

        if ($allowed != Acl::ALLOW) {
            $this->flash->error("You don't have access to ".$dispatcher->getActionName()." on ".$dispatcher->getModuleName()." module");

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
