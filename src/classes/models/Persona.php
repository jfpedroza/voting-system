<?php
/**
 * Created by PhpStorm.
 * User: johnf
 * Date: 14/10/2017
 * Time: 7:45 PM
 */

namespace models;

/**
 * Representa una persona del sistema, como un usuario o un candidato.
 *
 * Class Persona
 * @package models
 */
class Persona {

    /** Id de la persona, es autoincrementable
     * @var  int */
    public $id;

    /** Primer nombre de la persona
     * @var  string */
    public $nombre;

    /** Segundo nombre de la persona
     * @var  string */
    public $segundoNombre;

    /** Primer apellido de la persona
     * @var  string */
    public $apellido;

    /** Segundo apellido de la persona
     * @var  string */
    public $segundoApellido;

    /** Tipo de documento de la persona
     * @var  string */
    public $tipoDocumento;

    /** Número de documento de la persona
     * @var  string */
    public $numeroDocumento;

    /** Género de la persona puede ser: M, F, O
     * @var  string */
    public $genero;

    /** Fecha de nacimiento de la persona, se maneja como string pues no se hacen operaciones sobre ella
     * @var  string */
    public $fechaNacimiento;

    /**
     * Retorna el nombre completo de la persona
     *
     * @return string Nombre completo
     */
    public function getNombre() {
        return "$this->nombre $this->segundoNombre $this->apellido $this->segundoApellido";
    }
}