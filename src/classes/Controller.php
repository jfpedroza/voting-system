<?php
/**
 * Created by PhpStorm.
 * User: johnf
 * Date: 14/10/2017
 * Time: 1:55 PM
 */

abstract class Controller {

    /** @var \Slim\App  */
    protected $app;

    /** @var \Psr\Container\ContainerInterface  */
    protected $cont;

    /** @var PDO  */
    protected $db;

    /** @var  \Slim\Views\PhpRenderer */
    protected $view;

    /** @var  \Monolog\Logger */
    protected $logger;

    /** @var  \Slim\Router */
    protected $router;

    public function __construct(\Slim\App $app) {
        $this->app = $app;
        $this->cont = $app->getContainer();
        $this->db = $this->cont->get("db");
        $this->view = $this->cont->get("view");
        $this->logger = $this->cont->get("logger");
        $this->router = $this->cont->get("router");

        $this->configure();
    }

    protected abstract function configure();
}