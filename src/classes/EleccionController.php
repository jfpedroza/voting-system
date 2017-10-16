<?php

use models\Usuario;
use Slim\Http\Request;
use Slim\Http\Response;

/**
 * Created by PhpStorm.
 * User: johnf
 * Date: 15/10/2017
 * Time: 8:36 PM
 */

class EleccionController extends Controller {

    protected function configure() {
        $app = $this->app;
        $this->app->group('/elections', function () use ($app) {

            $app->get("/{id:[0-9]+}", function (Request $request, Response $response, $args) {
                $id = $args['id'];
                $user = Usuario::fromArray($_SESSION['user']);

                $election = $this->dao->eleccion->getEleccion($id);
                $candidates = $this->dao->candidato->getCandidatos($election);

                $response = $this->view->render($response, "election.phtml",
                    ["router" => $this->router, "user" => $user, "election" => $election, "candidates" => $candidates]);
                return $response;
            })->setName("seeElection");

            $app->get("/{id:[0-9]+}/vote/{idC:[0-9]+}", function (Request $request, Response $response, $args) {
                $id = $args['id'];
                $idCandidate = $args['idC'];
                $user = Usuario::fromArray($_SESSION['user']);

                return $response->withRedirect("/");
            })->setName("vote");
        });
    }
}