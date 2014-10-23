<?php
namespace Project\Phalcon\Event\Database;

use Phalcon\Db\Adapter\Pdo\Mysql;
use Phalcon\Logger\Adapter\File as Logger;

/**
 * @author      Zeki Unal <zekiunal@gmail.com>
 * @description
 *
 * @package     Project\File\Downloader\Method
 * @name        Listener
 * @version     0.1
 */
class Listener
{
    /**
     * @var Logger
     */
    protected $_logger;

    /**
     * class constructor
     */
    public function __construct()
    {
        if (!file_exists("db.log")) {
            @touch("db.log");
        }
        $this->_logger = new Logger("db.log");
    }

    /**
     * @param $event
     * @param Mysql $connection
     */
    public function afterConnect($event, Mysql $connection)
    {

    }

    /**
     * @param $event
     * @param Mysql $connection
     */
    public function beforeQuery($event, Mysql $connection)
    {
        $this->_logger->log($connection->getSQLStatement());
    }

    /**
     * @param $event
     * @param Mysql $connection
     */
    public function afterQuery($event, Mysql $connection)
    {
        $this->_logger->log($connection->getSQLStatement(), \Phalcon\Logger::ERROR);
    }
}
