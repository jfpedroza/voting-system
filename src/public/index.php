<?php
/**
 * Created by PhpStorm.
 * User: johnf
 * Date: 14/10/2017
 * Time: 12:04 PM
 */
session_start();

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require '../../vendor/autoload.php';

$config = include '../../config.php';

$app = new \Slim\App(["settings" => $config]);
$container = $app->getContainer();

$container['logger'] = function($c) {
    $logger = new \Monolog\Logger('my_logger');
    $file_handler = new \Monolog\Handler\StreamHandler("../../logs/app.log");
    $logger->pushHandler($file_handler);
    return $logger;
};

$container['db'] = function ($c) {
    $db = $c['settings']['db'];
    $pdo = new PDO("pgsql:host=" . $db['host'] . ";dbname=" . $db['dbname'],
        $db['user'], $db['pass']);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
    return $pdo;
};

$container['dao'] = function ($c) {
    return new \DAO\DAOManager($c['db'], $c['logger']);
};

$container['view'] = new \Slim\Views\PhpRenderer("../templates/");

$app->get('/hello/{name}', function (Request $request, Response $response) {
    $name = $request->getAttribute('name');
    $response->getBody()->write("Hello, $name");
    $this->logger->addInfo("Hello");

    $stmt = $this->db->prepare('SELECT * FROM usuarios');
    $stmt->execute();
    $result = $stmt->fetchAll();
    foreach ($result as $user) {
        $response->getBody()->write("<br/>".$user->usuario);
    }

    return $response;
});

new IndexController($app);
new UsuarioController($app);
new EleccionController($app);

$app->run();