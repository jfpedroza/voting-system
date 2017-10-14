<?php

use Slim\Http\Request;
use Slim\Http\Response;

/**
 * Created by PhpStorm.
 * User: johnf
 * Date: 14/10/2017
 * Time: 1:45 PM
 */

class IndexController implements Controller {

    public static function configure(\Slim\App $app) {
        $cont = $app->getContainer();
        $app->get("/", function (Request $request, Response $response) use ($cont) {
            $response = $cont->view->render($response, "index.phtml", []);
            return $response;
        })->setName("index");
    }
}