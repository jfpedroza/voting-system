<?php
/**
 * Created by PhpStorm.
 * User: johnf
 * Date: 15/10/2017
 * Time: 8:05 PM
 */

namespace models;

/**
 * Representa una elección llevada a cabo en el sistema
 *
 * Class Eleccion
 * @package models
 */
class Eleccion {

    /** Id de la elección, es autoincrementable
     * @var  int */
    public $id;

    /** Nombre de la elección
     * @var  string */
    public $nombre;

    /** Fecha de inicio de la elección
     * @var  \DateTime */
    public $fechaInicio;

    /** Fecha de fin de la elección
     * @var  \DateTime */
    public $fechaFin;

    /** Total de votos que tiene la elección
     * @var  int */
    public $totalVotos;

    /** Número de votos cancelados que tiene la elección
     * @var  int */
    public $votosCancelados;

    /**
     * Devuelve una clase css usada pare colorear las filas en la tabla de elecciones.
     * La devuelve dependiendo de la fecha actual, la fecha de inicio de la elección y la fecha fin.
     * Pseudo-código para determinar la clase.
     *
     * if (now < fechaInicio) {
     *      return "info";
     * } else if (now > fechaFin) {
     *      return "danger";
     * } else {
     *      return "success";
     * }
     *
     * @return string
     */
    public function getClass() {
        $now = new \DateTime;
        if ($now < $this->fechaInicio) {
            return "info";
        } else if ($now > $this->fechaFin) {
            return "danger";
        } else {
            return "success";
        }
    }
}