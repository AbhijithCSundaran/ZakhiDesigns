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
$routes->get('category/add/(:num)', 'Category::addCategory/$1'); 
$routes->post('category/save', 'Category::saveCategory');
$routes->post('category/status', 'Category::changeStatus');
$routes->post('category/delete/(:any)', 'Category::deleteCategory/$1');


//Subcategory
$routes->get('subcategory', 'Subcategory::index');
$routes->get('subcategory/add', 'Subcategory::addSubcategory');
$routes->get('subcategory/add/(:num)', 'Subcategory::addSubcategory/$1'); 
$routes->post('subcategory/save', 'Subcategory::saveSubcategory');


//Products
$routes->get('user/products', 'Product::index');

//Staff
$routes->get('staff', 'Staff::index');
$routes->get('staff/add', 'Staff::addStaff'); // Create
$routes->get('staff/add/(:num)', 'Staff::addStaff/$1'); // Edit
$routes->post('staff/save', 'Staff::createnew');
$routes->post('staff/delete/(:any)', 'Staff::deleteStaff/$1');


//Customers
$routes->get('customer', 'Customer::index');
$routes->get('customer/view', 'Customer::view_cust'); // Create
$routes->get('customer/view/(:num)', 'Customer::view_cust/$1'); // View Page

//logout
$routes->post('/logout', 'Auth::logout'); 