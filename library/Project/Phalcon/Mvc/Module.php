<?php
namespace Project\Phalcon\Mvc;

use Mustache_Loader_FilesystemLoader;
use Phalcon\DI\FactoryDefault;
use Phalcon\DI;
use Phalcon\Loader;
use Phalcon\Mvc\Dispatcher;
use Phalcon\Mvc\View;
use Phalcon\Mvc\View\Engine\Mustache;

/**
 * @property mixed config
 * @package Mvc
 * @author Zeki UNAL <zekiunal@gmail.com>
 * @created 2014-03-24 03:12
 * @name Controller
 */
class Module
{
    /**
     * @var string;
     */
    protected $path;

    /**
     * @var string;
     */
    protected $default_namespace;

    /**
     * @var string;
     */
    protected $view_dir = '/views/';

    /**
     * @var string;
     */
    protected $template;

    /**
     * @var array;
     */
    protected $namespace;

    public function __construct()
    {
        $this->namespace = array();
    }

    public function registerAutoloaders()
    {
        $loader = new Loader();
        $loader->registerNamespaces($this->namespace);
        $loader->register();
    }

    /**
     * @param \Phalcon\DI\FactoryDefault $di
     */
    public function registerServices($di)
    {
        /**
         * @return Dispatcher
         */
        $di->set('dispatcher', function() use ($di) {
            $dispatcher = new Dispatcher();
            $dispatcher->setDefaultNamespace($this->default_namespace);
            return $dispatcher;
        });

        /**
         * Setting up the view component
         */
        $di['view'] = function() use ($di) {
            $view = new View();
            $view->setViewsDir($this->path.$this->view_dir);
            $view->setLayoutsDir('../../../../public/layouts/'.$di->get('config')->project->layout.'/');
            $view->setTemplateAfter($this->template);
            $view->setVar('project-setting', $di->get('config')->project->toArray());
            // Set the engine
            $view->registerEngines(
                array(
                    ".mustache" => function ($view, DI $di) {
                            /**
                             * Mustache loading
                             */
                            require_once "../vendor/Mustache/Autoloader.php";
                            \Mustache_Autoloader::register();

                            $partial_url = '../public/layouts/'.$di->get('config')->project->layout.'/partials';
                            $partial_loader = new Mustache_Loader_FilesystemLoader($partial_url);

                            $config = $di->get('config')->cache->frontend;

                            if($config->active == 0) {
                                $options = array(
                                    'partials_loader' => $partial_loader
                                );
                            } else {
                                $options = array(
                                    'cache'            => $config->path,
                                    'cache_file_mode'  => $config->mode,
                                    'partials_loader'  => $partial_loader,
                                    'strict_callables' => $config->callables,
                                );
                            }

                            $mustache = new Mustache($view, $di, $options);
                            return $mustache;
                        },
                    '.phtml'    => 'Phalcon\Mvc\View\Engine\Php'
                )
            );

            return $view;
        };
    }
}