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

//Products
$routes->get('user/products', 'Product::index');

//Staff
$routes->get('staff', 'Staff::index');
$routes->get('staff/add', 'Staff::addStaff');
$routes->post('staff/save', 'Staff::createnew');

//logout
$routes->post('/logout', 'Auth::logout'); 