<?php
/**
 * Created by PhpStorm.
 * User: johnf
 * Date: 15/10/2017
 * Time: 10:40 PM
 */

namespace models;


class Candidato {

    /** @var  int */
    public $id;

    /** @var  int */
    public $idPersona;

    /** @var  Persona */
    public $persona;

    /** @var  string */
    public $foto;

    /** @var int */
    public $numero;
}