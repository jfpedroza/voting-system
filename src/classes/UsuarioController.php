<?php

use Slim\Http\Request;
use Slim\Http\Response;

/**
 * Created by PhpStorm.
 * User: johnf
 * Date: 15/10/2017
 * Time: 4:57 PM
 */

class UsuarioController extends Controller {

    protected function configure() {
        $app = $this->app;
        $this->app->group('/users', function () use ($app) {

            $app->get("/register", function (Request $request, Response $response) {
                $response = $this->view->render($response, "register.phtml", ["router" => $this->router]);
                return $response;
            })->setName("register");

            $app->post("/register", function (Request $request, Response $response) {
                $data = $request->getParsedBody();

                $usuario = new \models\Usuario();
                $persona = new \models\Persona();

                $usuario->usuario = $data['usuario'];
                $usuario->clave = $data['password'];
                $usuario->idRol = 2;
                $usuario->persona = $persona;
                $persona->nombre = $data['nombre'];
                $persona->segundoNombre = $data['segundo_nombre'];
                $persona->apellido = $data['apellido'];
                $persona->segundoApellido = $data['segundo_apellido'];
                $persona->tipoDocumento = $data['tipo_identificacion'];
                $persona->numeroDocumento = $data['identificacion'];
                $persona->genero = $data['genero'];
                $persona->fechaNacimiento = $data['fecha_nacimiento'];

                $type = "success";
                $message = "Usuario creado correctamente";

                try {
                    $this->dao->usuario->crearUsuario($usuario);
                } catch (PDOException $ex) {
                    $type = "danger";
                    $message = "Ocurrió un error al crear el usuario";
                    $this->logger->addError($ex->getTraceAsString());
                }

                $response = $this->view->render($response, "register.phtml",
                    ["router" => $this->router, "type" => $type, "message" => $message]);

                return $response;
            })->setName("doRegister");
        });
    }
}