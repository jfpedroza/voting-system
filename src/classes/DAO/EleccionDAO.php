<?php
/**
 * Created by PhpStorm.
 * User: johnf
 * Date: 15/10/2017
 * Time: 8:07 PM
 */

namespace DAO;


use models\Eleccion;
use models\Usuario;

class EleccionDAO extends BaseDAO {

    public function getElecciones(Usuario $usuario): array {
        $stmt = $this->db->prepare('SELECT * FROM public.get_elecciones_por_usuario(:id)');
        $stmt->bindParam(':id', $usuario->id);
        $stmt->execute();

        $result = $stmt->fetchAll();
        $elecciones = [];
        foreach ($result as $el) {
            $eleccion = new Eleccion();
            $eleccion->id = $el->id_eleccion;
            $eleccion->nombre = $el->nombre;
            $eleccion->fechaInicio = new \DateTime($el->fecha_inicio);
            $eleccion->fechaFin = new \DateTime($el->fecha_fin);
            $eleccion->totalVotos = $el->total_votos;

            array_push($elecciones, $eleccion);
        }

        return $elecciones;
    }
}