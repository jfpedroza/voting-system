<?php
/**
 * Created by PhpStorm.
 * User: johnf
 * Date: 14/10/2017
 * Time: 8:31 PM
 */

namespace DAO;


use Monolog\Logger;

class DAOManager {

    /** @var  UsuarioDAO */
    public $usuario;

    /** @var EleccionDAO  */
    public $eleccion;

    public function __construct(\PDO $db, Logger $logger) {
        $this->usuario = new UsuarioDAO($db, $logger);
        $this->eleccion = new EleccionDAO($db, $logger);
    }
}