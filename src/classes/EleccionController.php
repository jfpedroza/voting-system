<?php

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
                $response = $this->view->render($response, "election.phtml",
                    ["router" => $this->router, "id" => $id]);
                return $response;
            })->setName("seeElection");
        });
    }
}