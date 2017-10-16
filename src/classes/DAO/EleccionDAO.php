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

/**
 * Permite realizar operaciones relacionadas con las elecciones
 *
 * Class EleccionDAO
 * @package DAO
 */
class EleccionDAO extends BaseDAO {

    /**
     * Devuelve la lista de elecciones a las que puede acceder un usuario, basado en su rol
     *
     * @param Usuario $usuario Usuario al que traerle las elecciones
     * @return array Array de elecciones
     */
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

    /**
     * Devuelve una elección basado en su ID
     *
     * @param int $id Id de la elección a traer
     * @return Eleccion|null Elección encontrada o null si no la encuentra
     */
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

    /**
     * Guarda el voto de un usuario por un candidato en una elección
     *
     * @param int $idEleccion Id de la elección en donde se está votando
     * @param int $idCandidato Id del candidato por el que se está votando
     * @param int $idUsuario Id del usuario que está votando
     * @return bool Si se guardó el voto o no
     */
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

    /**
     * Devuelve si un usuario ya votó en una elección o no
     *
     * @param int $idEleccion Id de la elección
     * @param int $idUsuario Id del usuario
     * @return bool Si votó o no
     */
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

    /**
     * Cancela un voto de un usuario en una elección
     *
     * @param int $idEleccion  Id de la elección en donde se está cancelando el voto
     * @param int $idUsuario Id del usuario que está cancelando el voto
     * @return bool
     */
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