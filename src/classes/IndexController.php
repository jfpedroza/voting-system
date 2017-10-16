<?php

use models\Usuario;
use Slim\Http\Request;
use Slim\Http\Response;

/**
 * Created by PhpStorm.
 * User: johnf
 * Date: 14/10/2017
 * Time: 1:45 PM
 */

/**
 * Controlador de la página de inicio e inicio/cierre de sesión
 *
 * Class IndexController
 */
class IndexController extends Controller {

    /**
     * @inheritdoc
     */
    protected function configure() {

        /**
         * Ruta para la página de inicio, envía las elecciones la plantilla
         */
        $this->app->get("/", function (Request $request, Response $response) {

            if (isset($_SESSION['user'])) {
                $user = Usuario::fromArray($_SESSION['user']);
                $elections = $this->dao->eleccion->getElecciones($user);

                $array = ["router" => $this->router, 'user' => $user, 'elections' => $elections];

                if (isset($_SESSION['type'])) {
                    $array['type'] = $_SESSION['type'];
                    unset($_SESSION['type']);
                }

                if (isset($_SESSION['message'])) {
                    $array['message'] = $_SESSION['message'];
                    unset($_SESSION['message']);
                }

                return $this->view->render($response, "index.phtml", $array);
            } else {
                return $response->withRedirect("/login");
            }
        })->setName("index");

        /**
         * Ruta para la página de inicio de sesión
         */
        $this->app->get("/login", function (Request $request, Response $response) {
            $invalid = $request->getQueryParam('invalid', false);
            $response = $this->view->render($response, "login.phtml", ["router" => $this->router, "invalid" => $invalid]);
            return $response;
        })->setName("login");

        /**
         * Ruta para accción de inicio de sesión, guarda el usuario en sesión si el inicio de sesión fue exitoso
         */
        $this->app->post("/login", function (Request $request, Response $response) {
            $data = $request->getParsedBody();
            $user = $data['user'];
            $password = $data['password'];
            $result = $this->dao->usuario->iniciarSesion($user, $password);
            if ($result != null) {
                $_SESSION['user'] = Usuario::toArray($result);

                return $response->withRedirect("/");
            } else {
                return $response->withRedirect("/login?invalid=true");
            }
        })->setName("doLogin");

        /**
         * Ruta para el cierre de sesión
         */
        $this->app->any("/logout", function (Request $request, Response $response) {
            unset($_SESSION['user']);

            session_destroy();

            return $response->withRedirect("/");
        })->setName("logout");
    }
}