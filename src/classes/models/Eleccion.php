<?php
/**
 * Created by PhpStorm.
 * User: johnf
 * Date: 15/10/2017
 * Time: 8:05 PM
 */

namespace models;


class Eleccion {

    /** @var  int */
    public $id;

    /** @var  string */
    public $nombre;

    /** @var  \DateTime */
    public $fechaInicio;

    /** @var  \DateTime */
    public $fechaFin;
}