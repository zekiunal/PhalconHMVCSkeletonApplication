<?php
namespace Project\Phalcon\Plugins;

use Phalcon\Acl\AdapterInterface;
use Phalcon\Acl\Adapter\Memory;
use Phalcon\Mvc\User\Plugin;
use Phalcon\Mvc\Dispatcher;
use Phalcon\Http\Response;
use Phalcon\Events\Event;
use Phalcon\Acl\Resource;
use Phalcon\Acl\Role;
use Phalcon\Acl;

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

    /**
     * Register roles
     */
    protected $roles;

    public function __construct($di)
    {
        $this->_dependencyInjector = $di;
    }

    /**
     * @param AdapterInterface $acl
     */
    protected function registerRoles(AdapterInterface $acl)
    {
        /**
         * Register roles
         */
        $this->roles = array(
            'users'  => new Role('Users'),
            'guests' => new Role('Guests')
        );

        array_map(array($acl, 'addRole'), $this->roles);
    }

    /**
     * @param AdapterInterface $acl
     */
    protected function registerPrivateResources(AdapterInterface $acl)
    {
        $add_resource = function ($actions, $resource) use ($acl) {
            $acl->addResource(new Resource($resource), $actions);
        };

        array_walk($this->private_resources, $add_resource);
    }

    /**
     * @param AdapterInterface $acl
     */
    protected function registerPublicResources(AdapterInterface $acl)
    {
        $add_resource = function ($actions, $resource) use ($acl) {
            $acl->addResource(new Resource($resource), $actions);
        };

        array_walk($this->public_resources, $add_resource);
    }

    /**
     * Grant access to private area to role Users
     *
     * @param AdapterInterface $acl
     */
    protected function grandAccessForPrivateResourceToUserRole(AdapterInterface $acl)
    {
        $grant = function ($actions, $resource) use ($acl) {
            $allow = function ($action) use ($acl, $resource) {
                $acl->allow('Users', $resource, $action);
            };
            array_map($allow, $actions);
        };

        array_walk($this->private_resources, $grant);
    }

    /**
     * Grant access to public areas to both users and guests
     *
     * @param AdapterInterface $acl
     */
    protected function grandAccessForPublicResourceToAllUsers(AdapterInterface $acl)
    {
        $grant = function (Role $role) use ($acl, $this) {
            $allow = function ($actions, $resource) use ($acl, $role) {
                $acl->allow($role->getName(), $resource, $actions);
            };
            array_walk($this->public_resources, $allow);
        };

        array_map($grant, $this->roles);
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
            $acl = new Memory();
            $acl->setDefaultAction(Acl::DENY);

            $this->registerRoles($acl);

            $this->registerPrivateResources($acl);
            $this->grandAccessForPrivateResourceToUserRole($acl);

            $this->registerPublicResources($acl);
            $this->grandAccessForPublicResourceToAllUsers($acl);

            /**
             * The acl is stored in session, APC would be useful here too
             */
            $this->persistent->acl = $acl;
        }

        return $this->persistent->acl;
    }

    /**
     * @return string
     */
    protected function getActiveRole()
    {
        $role = 'Guests';
        if ($this->session->get('auth')) {
            return 'Users';
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
