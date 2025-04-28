<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->get('user/dashboard', 'Home::dashboard');


//category
$routes->get('user/category', 'Category::index');
$routes->post('category/add','ManageCategory::index');


//Products
$routes->get('user/products', 'Product::index');

