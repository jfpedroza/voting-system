<?php
/**
 * Created by PhpStorm.
 * User: johnf
 * Date: 14/10/2017
 * Time: 7:41 PM
 */

namespace models;

/**
 * Representa un usuario del sistema, puede ser Administrador o Votante
 *
 * Class Usuario
 * @package models
 */
class Usuario {

    /** Id del usuario, es autoincrementable
     * @var  int */
    public $id;

    /** Nombre de usuario
     * @var  string */
    public $usuario;

    /** Contraseña del usuario
     * @var  string */
    public $clave;

    /** Llave foránea a la tabla persona
     * @var  int */
    public $idPersona;

    /** Objeto de tipo Persona con la información personal del usuario
     * @var  Persona */
    public $persona;

    /** Llave foránea a la tabla rol
     * @var  int */
    public $idRol;

    /** Objeto de tipo Rol con el rol al que pertenece el usuario
     * @var  Rol */
    public $rol;

    /**
     * Convierte un objeto Usuario en un array asociativo
     *
     * @param Usuario $usuario Usuario a convertir
     * @return array Array asociativo con la información del usuario
     */
    public static function toArray(Usuario $usuario): array {
        $array = (array)$usuario;
        $array["persona"] = (array)$usuario->persona;
        $array["rol"] = (array)$usuario->rol;

        return $array;
    }

    /**
     * Convierte un array asociativo en un objeto Usuario
     *
     * @param array $array Array a convertir
     * @return Usuario El usuario con la información sacada el array
     */
    public static function fromArray(array $array): Usuario {
        $usuario = new Usuario();
        $usuario->id = $array['id'];
        $usuario->usuario = $array['usuario'];
        $usuario->clave = $array['clave'];
        $usuario->idRol = $array['idRol'];
        $usuario->idPersona = $array['idPersona'];

        $persona = new Persona();
        $persona->id = $array["persona"]["id"];
        $persona->nombre = $array["persona"]["nombre"];
        $persona->segundoNombre = $array["persona"]["segundoNombre"];
        $persona->apellido = $array["persona"]["apellido"];
        $persona->segundoApellido = $array["persona"]["segundoApellido"];
        $persona->tipoDocumento = $array["persona"]["tipoDocumento"];
        $persona->numeroDocumento = $array["persona"]["numeroDocumento"];
        $persona->genero = $array["persona"]["genero"];
        $persona->fechaNacimiento = $array["persona"]["fechaNacimiento"];
        $usuario->persona = $persona;

        $rol = new Rol();
        $rol->id = $array["rol"]["id"];
        $rol->nombre = $array["rol"]["nombre"];
        $usuario->rol = $rol;

        return $usuario;
    }
}