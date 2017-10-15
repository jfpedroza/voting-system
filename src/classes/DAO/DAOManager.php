<?php
/**
 * Created by PhpStorm.
 * User: johnf
 * Date: 14/10/2017
 * Time: 8:31 PM
 */

namespace DAO;


class DAOManager {

    /** @var  UsuarioDAO */
    public $usuario;

    public function __construct(\PDO $db) {
        $this->usuario = new UsuarioDAO($db);
    }
}