<?php
/**
 * Created by PhpStorm.
 * User: johnf
 * Date: 14/10/2017
 * Time: 8:31 PM
 */

namespace DAO;


use Monolog\Logger;

/**
 * Provee instancias de todos los tipos de DAOs existentes
 *
 * Class DAOManager
 * @package DAO
 */
class DAOManager {

    /** Instancia del DAO de Usuario
     * @var  UsuarioDAO */
    public $usuario;

    /** Instancia del DAO de Eleccion
     * @var EleccionDAO  */
    public $eleccion;

    /** Instancia del DAO de Candidato
     * @var CandidatoDAO  */
    public $candidato;

    /**
     * Incializa los DAOs con el objeto PDO y el Logger
     *
     * DAOManager constructor.
     * @param \PDO $db Objeto PDO conectado a la base de datos
     * @param Logger $logger Logger
     */
    public function __construct(\PDO $db, Logger $logger) {
        $this->usuario = new UsuarioDAO($db, $logger);
        $this->eleccion = new EleccionDAO($db, $logger);
        $this->candidato = new CandidatoDAO($db, $logger);
    }
}