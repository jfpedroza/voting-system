<?php
/**
 * Created by PhpStorm.
 * User: johnf
 * Date: 14/10/2017
 * Time: 7:41 PM
 */

namespace models;


class Usuario {

    /** @var  int */
    public $id;

    /** @var  string */
    public $usuario;

    /** @var  string */
    public $clave;

    /** @var  int */
    public $idPersona;

    /** @var  Persona */
    public $presona;

    /** @var  int */
    public $idRol;

    /** @var  Rol */
    public $rol;
}