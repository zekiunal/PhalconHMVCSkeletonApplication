<?php
namespace Phalcon\Mvc\View\Engine;

use Phalcon\Mvc\View\Engine;

class Mustache extends Engine
{
    /**
     * @var \Mustache_Engine
     */
    protected $_mustache;

    /**
     * @var array
     */
    protected $_params;

    /**
     * Phalcon\Mvc\View\Engine\Mustache constructor
     *
     * @param \Phalcon\Mvc\ViewInterface $view
     * @param \Phalcon\DiInterface       $di
     * @param null                       $options
     */
    public function __construct($view, $di = null, $options = null)
    {
        $this->_mustache = new \Mustache_Engine($options);
        parent::__construct($view, $di);
    }

    /**
     * @param      $path
     * @param      $params
     * @param bool $mustClean
     */
    public function render($path, $params, $mustClean = false)
    {

        if (!isset($params['content'])) {
            $params['content'] = $this->_view->getContent();
        }

        $content = $this->_mustache->render(file_get_contents($path), $params);
        if ($mustClean) {
            $this->_view->setContent($content);
        } else {
            echo $content;
        }
    }
}