<?php

use CodeIgniter\Router\RouteCollection;
use App\Controllers\ConsultaUmidade;
/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

$routes->get('consultaUmidade', 'ConsultaUmidade::index');
$routes->post('consultaUmidade/verificaUmidade', 'ConsultaUmidade::verificaUmidade');
