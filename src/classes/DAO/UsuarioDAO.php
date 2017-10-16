<?php
/**
 * Created by PhpStorm.
 * User: johnf
 * Date: 14/10/2017
 * Time: 7:49 PM
 */

namespace DAO;


use models\Persona;
use models\Rol;
use models\Usuario;

/**
 * Permite realizar operaciones relacionadas con los usuarios
 *
 * Class UsuarioDAO
 * @package DAO
 */
class UsuarioDAO extends BaseDAO {

    /**
     * Inicia sesión con un nombre de usuario y contraseña, devuelve el usuario si el inicio
     * de sesión fue exitoso, null si no.
     *
     * @param string $usuario Nombre del usuario ingresado
     * @param string $clave Contraseña ingresada
     * @return Usuario|null Usuario logeado o null si no se pudo inicar sesión
     */
    public function iniciarSesion(string $usuario, string $clave): ?Usuario {
        $stmt = $this->db->prepare('SELECT * FROM public.iniciar_sesion(:usuario, :clave)');
        $stmt->bindParam(':usuario', $usuario);
        $stmt->bindParam(':clave', $clave);
        $stmt->execute();

        $result = $stmt->fetch();
        if ($result != null) {
            $user = new Usuario();
            $user->id = $result->id;
            $user->usuario = $result->usuario;

            $persona = new Persona();
            $persona->nombre = $result->nombre;
            $persona->segundoNombre = $result->segundo_nombre;
            $persona->apellido = $result->apellido;
            $persona->segundoApellido = $result->segundo_apellido;
            $persona->tipoDocumento = $result->tipo_documento;
            $persona->numeroDocumento = $result->numero_documento;
            $persona->genero = $result->genero;
            $persona->fechaNacimiento = $result->fecha_de_nacimiento;
            $user->persona = $persona;

            $rol = new Rol();
            $rol->nombre = $result->rol;
            $user->rol = $rol;

            return $user;
        }

        return null;
    }

    /**
     * Crea un usuario en la base de datos
     *
     * @param Usuario $usuario Usuario a crear
     */
    public function crearUsuario(Usuario $usuario) {
        $stmt = $this->db->prepare('SELECT public.crear_usuario(:tipo_id, :identificacion, :nombre, :segundoNombre, :apellido, :segundoApellido, :usuario, :clave, :genero, :fechaNac, :rol) as id');
        $stmt->bindParam(':usuario', $usuario->usuario);
        $stmt->bindParam(':clave', $usuario->clave);
        $stmt->bindParam(':nombre', $usuario->persona->nombre);
        $stmt->bindParam(':apellido', $usuario->persona->apellido);
        $stmt->bindParam(':segundoNombre', $usuario->persona->segundoNombre);
        $stmt->bindParam(':segundoApellido', $usuario->persona->segundoApellido);
        $stmt->bindParam(':genero', $usuario->persona->genero);
        $stmt->bindParam(':fechaNac', $usuario->persona->fechaNacimiento);
        $stmt->bindParam(':identificacion', $usuario->persona->numeroDocumento);
        $stmt->bindParam(':tipo_id', $usuario->persona->tipoDocumento);
        $stmt->bindParam(':rol', $usuario->idRol);
        $stmt->execute();

        $result = $stmt->fetch();
        if ($result != null) {
            $usuario->id = $result->id;
        }
    }

    /**
     * Devuelve la lista de votantes del sistema, es decir los usuarios con rol Votante.
     *
     * @return array Array de votantes del sistema
     */
    public function getVotantes() {
        $stmt = $this->db->prepare('SELECT * FROM public.get_votantes()');
        $stmt->execute();

        $result = $stmt->fetchAll();
        $votantes = [];
        foreach ($result as $el) {
            $votante = new Usuario();
            $votante->id = $el->id_usuario;
            $votante->usuario = $el->usuario;

            $persona = new Persona();
            $persona->nombre = $el->nombre;
            $persona->segundoNombre = $el->segundo_nombre;
            $persona->apellido = $el->apellido;
            $persona->segundoApellido = $el->segundo_apellido;
            $persona->tipoDocumento = $el->tipo_documento;
            $persona->numeroDocumento = $el->numero_documento;
            $persona->genero = $el->genero;
            $persona->fechaNacimiento = $el->fecha_de_nacimiento;
            $votante->persona = $persona;

            array_push($votantes, $votante);
        }

        return $votantes;
    }
}