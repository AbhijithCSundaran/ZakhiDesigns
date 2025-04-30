<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
/* GET METHODS */
$routes->get('/', 'Home::index');

$routes->get('dashboard', 'Dashboard::index'); 

$routes->post('Auth', 'Auth::authenticate'); 

//category
$routes->get('category', 'Category::index');
$routes->get('category/add', 'Category::addCategory');
$routes->post('category/save', 'Category::saveCategory');
$routes->post('category/status', 'Category::changeStatus');
$routes->post('category/delete/(:any)', 'Category::deleteCategory/$1');

//Products
$routes->get('user/products', 'Product::index');