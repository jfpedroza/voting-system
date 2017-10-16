<?php
/**
 * Created by PhpStorm.
 * User: johnf
 * Date: 15/10/2017
 * Time: 8:07 PM
 */

namespace DAO;


use models\Eleccion;

class EleccionDAO extends BaseDAO {

    public function getElecciones(): array {
        $stmt = $this->db->prepare('SELECT * FROM public.elecciones');
        $stmt->execute();

        $result = $stmt->fetchAll();
        $elecciones = [];
        foreach ($result as $el) {
            $eleccion = new Eleccion();
            $eleccion->id = $el->id_eleccion;
            $eleccion->nombre = $el->nombre;
            $eleccion->fechaInicio = new \DateTime($el->fecha_inicio);
            $eleccion->fechaFin = new \DateTime($el->fecha_fin);

            array_push($elecciones, $eleccion);
        }

        return $elecciones;
    }
}