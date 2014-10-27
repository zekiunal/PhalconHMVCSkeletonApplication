<?php
namespace Project\Phalcon\Plugins\Security\Acl;

use Phalcon\Acl\AdapterInterface;
use Phalcon\Acl\Resource;
use Phalcon\Acl\Role;

/**
 * @author      Zeki Unal <zekiunal@gmail.com>
 * @description
 *
 * @package     Project\Phalcon\Plugins\Security\Acl
 * @name        Helper
 * @version     0.1
 */
class Helper
{
    /**
     * @var AdapterInterface
     */
    protected $adaptor;

    /**
     * Private area resources
     * @var array
     */
    protected $private_resources = array();

    /**
     * Public area resources
     * @var array
     */
    protected $public_resources = array('index' => array('index'));

    /**
     * @var array
     */
    protected $roles;

    /**
     * @param AdapterInterface $acl_adaptor
     * @param array            $public
     * @param array            $private
     */
    public function __construct(AdapterInterface $acl_adaptor, array $public, array $private)
    {
        $this->adaptor = $acl_adaptor;
        $this->private_resources = $private;
        $this->public_resources = $public;

        /**
         * Register roles
         */
        $this->roles = array(
            'users'  => new Role('Users'),
            'guests' => new Role('Guests')
        );
    }

    /**
     * @return Helper
     */
    public function initialize()
    {
        $this->registerRoles();
        $this->registerPrivateResources();
        $this->grandAccessForPrivateResourceToUserRole();
        $this->registerPublicResources();
        $this->grandAccessForPublicResourceToAllUsers();

        return $this;
    }

    /**
     * @return AdapterInterface
     */
    public function getAcl()
    {
        return $this->adaptor;
    }

    public function registerRoles()
    {
        array_map(array($this->adaptor, 'addRole'), $this->roles);
    }

    public function registerPrivateResources()
    {
        $add_resource = function ($actions, $resource) {
            $this->adaptor->addResource(new Resource($resource), $actions);
        };

        array_walk($this->private_resources, $add_resource);
    }

    public function registerPublicResources()
    {
        $add_resource = function ($actions, $resource) {
            $this->adaptor->addResource(new Resource($resource), $actions);
        };
        array_walk($this->public_resources, $add_resource);
    }

    /**
     * Grant access to private area to role Users
     */
    public function grandAccessForPrivateResourceToUserRole()
    {
        $grant = function ($actions, $resource) {
            $allow = function ($action) use ($resource) {
                $this->adaptor->allow('Users', $resource, $action);
            };
            array_map($allow, $actions);
        };

        array_walk($this->private_resources, $grant);
    }

    /**
     * Grant access to public areas to both users and guests
     */
    public function grandAccessForPublicResourceToAllUsers()
    {
        $grant = function (Role $role) {
            $allow = function ($actions, $resource) use ($role) {
                $this->adaptor->allow($role->getName(), $resource, $actions);
            };
            array_walk($this->public_resources, $allow);
        };
        array_map($grant, $this->roles);
    }
}
