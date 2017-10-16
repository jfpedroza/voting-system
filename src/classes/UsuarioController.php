<?php

use models\Persona;
use models\Usuario;
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
                $array = ["router" => $this->router];

                if (isset($_SESSION['type'])) {
                    $array['type'] = $_SESSION['type'];
                    unset($_SESSION['type']);
                }

                if (isset($_SESSION['message'])) {
                    $array['message'] = $_SESSION['message'];
                    unset($_SESSION['message']);
                }

                return $this->view->render($response, "register.phtml", $array);
            })->setName("register");

            $app->post("/register", function (Request $request, Response $response) {
                $data = $request->getParsedBody();

                $usuario = new Usuario();
                $persona = new Persona();

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

                $_SESSION['type'] = $type;
                $_SESSION['message'] = $message;

                return $response->withRedirect('/register');
            })->setName("doRegister");

            $app->get("/voters", function (Request $request, Response $response) {
                $user = Usuario::fromArray($_SESSION['user']);
                $voters = $this->dao->usuario->getVotantes();

                $response = $this->view->render($response, "voters.phtml",
                    ["router" => $this->router, "user" => $user, "voters" => $voters]);
                return $response;
            })->setName("seeVoters");
        });
    }
}