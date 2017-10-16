<?php
/**
 * Created by PhpStorm.
 * User: johnf
 * Date: 15/10/2017
 * Time: 10:40 PM
 */

namespace models;

/**
 * Representa un candidato del sistema
 *
 * Class Candidato
 * @package models
 */
class Candidato {

    /** Id del candidato, es autoincrementable
     * @var  int */
    public $id;

    /** Llave foránea a la tabla persona
     * @var  int */
    public $idPersona;

    /** Objeto de tipo Persona con la información personal del candidato
     * @var  Persona */
    public $persona;

    /** String donde se almacena la foto
     * @var  string */
    public $foto;

    /** Número del candidato en alguna elección
     * @var int */
    public $numero;

    /** Número de votos que ha recibido el candidato en una elección
     * @var  int */
    public $votos;

    /**
     * Devuelve los ganadores de la elección, más de uno en caso de empate
     *
     * @param array $candidatos Array de candidatos de una elección
     * @return array Array de ganadores
     */
    public static function getGanadores(array $candidatos): array {
        $ganadores = [];

        /** @var Candidato $candidato */
        foreach ($candidatos as $candidato) {
            if (count($ganadores) == 0) {
                array_push($ganadores, $candidato);
            } else if ($candidato->votos > $ganadores[0]) {
                $ganadores = [];
                array_push($ganadores, $candidato);
            } else if ($candidato->votos == $ganadores[0]) {
                array_push($ganadores, $candidato);
            }
        }

        return $ganadores;
    }
}