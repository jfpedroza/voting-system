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

    /** @var  int */
    public $votos;

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