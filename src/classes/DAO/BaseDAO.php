<?php
/**
 * Created by PhpStorm.
 * User: johnf
 * Date: 14/10/2017
 * Time: 7:52 PM
 */

namespace DAO;


use PDO;

abstract class BaseDAO {

    /** @var  PDO */
    protected $db;

    public function __construct(PDO $db) {
        $this->db = $db;
    }
}