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

/**
 * Clase base para los DAOs del sistema,
 * provee a los daos con un objeto PDO para conectarse a la base de datos
 * y un objeto logger para realizar los logs necesarios.
 *
 * Class BaseDAO
 * @package DAO
 */
abstract class BaseDAO {

    /** Objeto PDO conectado a la base de datos del sistema
     * @var  PDO */
    protected $db;

    /**Objeto Logger con el que se hacen los logs
     * @var Logger  */
    protected $logger;

    /**
     * BaseDAO constructor.
     * @param PDO $db PDO conectado a la base de datos
     * @param Logger $logger Logger al que hacer log
     */
    public function __construct(PDO $db, Logger $logger) {
        $this->db = $db;
        $this->logger = $logger;
    }
}