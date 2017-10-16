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

    public function getEleccion(int $id): ?Eleccion {
        $stmt = $this->db->prepare('SELECT * FROM public.get_eleccion(:id)');
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        $result = $stmt->fetch();
        if ($result != null) {
            $eleccion = new Eleccion();
            $eleccion->id = $result->id_eleccion;
            $eleccion->nombre = $result->nombre;
            $eleccion->fechaInicio = new \DateTime($result->fecha_inicio);
            $eleccion->fechaFin = new \DateTime($result->fecha_fin);
            $eleccion->totalVotos = $result->total_votos;
            $eleccion->votosCancelados = $result->votos_cancelados;

            return $eleccion;
        }

        return null;
    }

    public function votar(int $idEleccion, int $idCandidato, int $idUsuario): bool {
        $stmt = $this->db->prepare('SELECT public.votar(:idEleccion, :idCandidato, :idUsuario) as success');
        $stmt->bindParam(':idEleccion', $idEleccion);
        $stmt->bindParam(':idCandidato', $idCandidato);
        $stmt->bindParam(':idUsuario', $idUsuario);
        $stmt->execute();

        $result = $stmt->fetch();
        if ($result != null) {
            return $result->success;
        }

        return false;
    }

    public function usuarioVoto(int $idEleccion, int $idUsuario): bool {
        $stmt = $this->db->prepare('SELECT public.usuario_voto(:idEleccion, :idUsuario) as success');
        $stmt->bindParam(':idEleccion', $idEleccion);
        $stmt->bindParam(':idUsuario', $idUsuario);
        $stmt->execute();

        $result = $stmt->fetch();
        if ($result != null) {
            return $result->success;
        }

        return false;
    }

    public function cancelarVoto(int $idEleccion, int $idUsuario): bool {
        $stmt = $this->db->prepare('SELECT public.cancelar_voto(:idEleccion, :idUsuario) as success');
        $stmt->bindParam(':idEleccion', $idEleccion);
        $stmt->bindParam(':idUsuario', $idUsuario);
        $stmt->execute();

        $result = $stmt->fetch();
        if ($result != null) {
            return $result->success;
        }

        return false;
    }
}