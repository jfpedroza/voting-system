<?php

use Slim\Http\Request;
use Slim\Http\Response;

/**
 * Created by PhpStorm.
 * User: johnf
 * Date: 14/10/2017
 * Time: 1:45 PM
 */

class IndexController extends Controller {

    protected function configure() {

        $this->app->get("/", function (Request $request, Response $response) {

            if (isset($_SESSION['user'])) {
                $user = (object)$_SESSION['user'];
                return $this->view->render($response, "index.phtml", ["router" => $this->router, 'user' => $user]);
            } else {
                return $response->withRedirect("/login");
            }
        })->setName("index");

        $this->app->get("/login", function (Request $request, Response $response) {
            $invalid = $request->getQueryParam('invalid', false);
            $response = $this->view->render($response, "login.phtml", ["router" => $this->router, "invalid" => $invalid]);
            return $response;
        })->setName("login");

        $this->app->post("/login", function (Request $request, Response $response) {
            $data = $request->getParsedBody();
            $user = $data['user'];
            $password = $data['password'];
            $result = $this->dao->usuario->iniciarSesion($user, $password);
            if ($result != null) {
                $_SESSION['user'] = (array)$result;

                return $response->withRedirect("/");
            } else {
                return $response->withRedirect("/login?invalid=true");
            }

            return $response;
        })->setName("doLogin");


        $this->app->any("/logout", function (Request $request, Response $response) {
            unset($_SESSION['user']);

            session_destroy();

            return $response->withRedirect("/");
        })->setName("logout");
    }
}