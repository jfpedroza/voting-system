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
            $response = $this->view->render($response, "index.phtml", []);
            return $response;
        })->setName("index");

        $this->app->get("/login", function (Request $request, Response $response) {
            $response = $this->view->render($response, "login.phtml", []);
            return $response;
        })->setName("login");
    }
}