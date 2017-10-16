<?php
/**
 * Created by PhpStorm.
 * User: johnf
 * Date: 14/10/2017
 * Time: 7:52 PM
 */

namespace DAO;


use Monolog\Logger;
use PDO;

abstract class BaseDAO {

    /** @var  PDO */
    protected $db;

    /** @var Logger  */
    protected $logger;

    public function __construct(PDO $db, Logger $logger) {
        $this->db = $db;
        $this->logger = $logger;
    }
}