<?php
/**
 * Created by PhpStorm.
 * User: johnf
 * Date: 14/10/2017
 * Time: 1:55 PM
 */

/**
 * Clase base para los controladores, provee variables útiles accesibles solo para los
 * controladores que hereden esta clase
 *
 * Class Controller
 */
abstract class Controller {

    /** Representa la aplicación completa, apartir de esta propiedad se obtienen las demás
     * @var \Slim\App  */
    protected $app;

    /** Container del Inyector de Dependencias
     * @var \Psr\Container\ContainerInterface  */
    protected $cont;

    /** PDO conectado a la base de datos
     * @var PDO  */
    protected $db;

    /** Renderizador de plantillas de PHP
     * @var  \Slim\Views\PhpRenderer */
    protected $view;

    /** Logger para guardar los logs del sistema
     * @var  \Monolog\Logger */
    protected $logger;

    /** Router que permite obtener las urls de las rutas a partir de sus nombres
     * @var  \Slim\Router */
    protected $router;

    /** Manager de DAO que contiene las instancias de todos los DAOs existentes
     * @var  \DAO\DAOManager */
    protected $dao;

    /**
     * Inicializa las propiedades protegidas para que sean accesibles por los controladores
     *
     * Controller constructor.
     * @param \Slim\App $app
     */
    public function __construct(\Slim\App $app) {
        $this->app = $app;
        $this->cont = $app->getContainer();
        $this->db = $this->cont->get("db");
        $this->view = $this->cont->get("view");
        $this->logger = $this->cont->get("logger");
        $this->router = $this->cont->get("router");
        $this->dao = $this->cont->get("dao");

        $this->configure();
    }

    /**
     * Método abstracto que configura todas las rutas del controlador
     *
     * @return mixed
     */
    protected abstract function configure();
}