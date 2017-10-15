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

class UsuarioDAO extends BaseDAO {

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
            $user->presona = $persona;

            $rol = new Rol();
            $rol->nombre = $result->rol;
            $user->rol = $rol;

            return $user;
        }

        return null;
    }

    public function crearUsuario(Usuario $usuario) {
        $stmt = $this->db->prepare('SELECT * FROM public.crear_usuario(:tipo_id, :identificacion, :nombre, :segundoNombre, :apellido, :segundoApellido, :usuario, :clave, :genero, :fechaNac, :rol)');
        $stmt->bindParam(':usuario', $usuario->usuario);
        $stmt->bindParam(':clave', $usuario->clave);
        $stmt->bindParam(':nombre', $usuario->presona->nombre);
        $stmt->bindParam(':apellido', $usuario->presona->apellido);
        $stmt->bindParam(':segundoNombre', $usuario->presona->segundoNombre);
        $stmt->bindParam(':segundoApellido', $usuario->presona->segundoApellido);
        $stmt->bindParam(':genero', $usuario->presona->genero);
        $stmt->bindParam(':fechaNac', $usuario->presona->fechaNacimiento);
        $stmt->bindParam(':identificacion', $usuario->presona->numeroDocumento);
        $stmt->bindParam(':tipo_id', $usuario->presona->tipoDocumento);
        $stmt->bindParam(':rol', $usuario->idRol);
        $stmt->execute();

        $result = $stmt->fetch();
        if ($result != null) {
            $usuario->id = $result->id;
        }
    }
}