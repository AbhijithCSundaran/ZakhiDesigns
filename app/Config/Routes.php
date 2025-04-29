<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
/* GET METHODS */
$routes->get('/', 'Home::index');
$routes->get('dashboard', 'Dashboard::index'); 
//$routes->get('/', 'Home::load');
/* POST METHODS */
$routes->post('Auth', 'Auth::authenticate'); 
// $routes->post('Auth', 'Auth::login'); 
