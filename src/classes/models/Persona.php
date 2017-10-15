<?php
/**
 * Created by PhpStorm.
 * User: johnf
 * Date: 14/10/2017
 * Time: 7:45 PM
 */

namespace models;


class Persona {

    /** @var  int */
    public $id;

    /** @var  string */
    public $nombre;

    /** @var  string */
    public $segundoNombre;

    /** @var  string */
    public $apellido;

    /** @var  string */
    public $segundoApellido;

    /** @var  string */
    public $tipoDocumento;

    /** @var  string */
    public $numeroDocumento;

    /** @var  string */
    public $genero;

    /** @var  string */
    public $fechaNacimiento;
}