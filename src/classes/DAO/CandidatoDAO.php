<?php
/**
 * Created by PhpStorm.
 * User: johnf
 * Date: 15/10/2017
 * Time: 10:43 PM
 */

namespace DAO;


use models\Candidato;
use models\Eleccion;
use models\Persona;

class CandidatoDAO extends BaseDAO {

    public function getCandidatos(Eleccion $eleccion): array {
        $stmt = $this->db->prepare('SELECT * FROM public.get_candidatos_por_eleccion(:id)');
        $stmt->bindParam(':id', $eleccion->id);
        $stmt->execute();

        $result = $stmt->fetchAll();
        $candidatos = [];
        foreach ($result as $el) {
            $candidato = new Candidato();
            $candidato->id = $el->id_candidato;
            $candidato->numero = $el->numero;
            $candidato->foto = $el->foto;
            $candidato->votos = $el->votos;

            $persona = new Persona();
            $persona->nombre = $el->nombre;
            $persona->segundoNombre = $el->segundo_nombre;
            $persona->apellido = $el->apellido;
            $persona->segundoApellido = $el->segundo_apellido;
            $persona->tipoDocumento = $el->tipo_documento;
            $persona->numeroDocumento = $el->numero_documento;
            $persona->genero = $el->genero;
            $persona->fechaNacimiento = $el->fecha_de_nacimiento;
            $candidato->persona = $persona;

            array_push($candidatos, $candidato);
        }

        return $candidatos;
    }
}