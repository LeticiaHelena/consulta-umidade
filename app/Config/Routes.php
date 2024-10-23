<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

$routes->get('consultaUmidade', 'ConsultaUmidade::index');
$routes->post('consultaUmidade/verificaUmidade', 'ConsultaUmidade::verificaUmidade');
