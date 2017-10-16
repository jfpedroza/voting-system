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
                $voted = $this->dao->eleccion->usuarioVoto($id, $user->id);

                $winners = null;
                if (new DateTime() > $election->fechaFin) {
                    $winners = \models\Candidato::getGanadores($candidates);
                }

                $array = ["router" => $this->router, "user" => $user, "election" => $election,
                    "candidates" => $candidates, "voted" => $voted, "winners" => $winners];

                if (isset($_SESSION['type'])) {
                    $array['type'] = $_SESSION['type'];
                    unset($_SESSION['type']);
                }

                if (isset($_SESSION['message'])) {
                    $array['message'] = $_SESSION['message'];
                    unset($_SESSION['message']);
                }

                $response = $this->view->render($response, "election.phtml", $array);
                return $response;
            })->setName("seeElection");

            $app->get("/{id:[0-9]+}/vote/{idC:[0-9]+}", function (Request $request, Response $response, $args) {
                $id = $args['id'];
                $idCandidate = $args['idC'];
                $user = Usuario::fromArray($_SESSION['user']);

                $success = $this->dao->eleccion->votar($id, $idCandidate, $user->id);
                $_SESSION['type'] = $success ? 'success' : 'danger';
                $_SESSION['message'] = $success ? 'Su voto ha sido registrado' : 'Ocurrió un error al registrar su voto';

                return $response->withRedirect($this->router->pathFor('seeElection', ['id' => $id]));
            })->setName("vote");

            $app->get("/{id:[0-9]+}/vote/cancel", function (Request $request, Response $response, $args) {
                $id = $args['id'];
                $user = Usuario::fromArray($_SESSION['user']);

                $success = $this->dao->eleccion->cancelarVoto($id, $user->id);
                $_SESSION['type'] = $success ? 'success' : 'danger';
                $_SESSION['message'] = $success ? 'Su voto ha sido cancelado' : 'Ocurrió un error al cancelar su voto';

                return $response->withRedirect($this->router->pathFor('seeElection', ['id' => $id]));
            })->setName("cancelVote");
        });
    }
}