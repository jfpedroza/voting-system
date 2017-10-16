<?php
/**
 * Created by PhpStorm.
 * User: johnf
 * Date: 14/10/2017
 * Time: 7:41 PM
 */

namespace models;


class Usuario {

    /** @var  int */
    public $id;

    /** @var  string */
    public $usuario;

    /** @var  string */
    public $clave;

    /** @var  int */
    public $idPersona;

    /** @var  Persona */
    public $presona;

    /** @var  int */
    public $idRol;

    /** @var  Rol */
    public $rol;

    public static function toArray(Usuario $usuario): array {
        $array = (array)$usuario;
        $array["persona"] = (array)$usuario->persona;
        $array["rol"] = (array)$usuario->rol;

        return $array;
    }

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