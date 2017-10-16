<?php
/**
 * Created by PhpStorm.
 * User: johnf
 * Date: 14/10/2017
 * Time: 7:45 PM
 */

namespace models;

/**
 * Representa un rol del sistema
 *
 * Class Rol
 * @package models
 */
class Rol {

    /** Id del rol, es autoincrementable
     * @var  int */
    public $id;

    /** Nombre del rol
     * @var  string */
    public $nombre;
}