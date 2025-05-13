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
$routes->get('category/edit/(:num)', 'Category::addCategory/$1'); 
$routes->post('category/save', 'Category::saveCategory');
$routes->post('category/status', 'Category::changeStatus');
$routes->post('category/delete/(:any)', 'Category::deleteCategory/$1');


//Subcategory
$routes->get('subcategory', 'Subcategory::index');
$routes->get('subcategory/add', 'Subcategory::addSubcategory');
$routes->get('subcategory/edit/(:num)', 'Subcategory::addSubcategory/$1'); 
$routes->post('subcategory/save', 'Subcategory::saveSubcategory');
$routes->post('subcategory/delete/(:any)', 'Subcategory::deleteSubcategory/$1');
$routes->post('subcategory/status', 'Subcategory::changeStatus');


//Products
$routes->get('product', 'Product::index');
$routes->get('product/add', 'Product::addProduct');
$routes->post('product/save', 'Product::saveProduct');
$routes->post('product/get-subcategories', 'Product::getSubcategories');


//Product images
$routes->get('productimage','Productimage::index');
$routes->get('productimage/add', 'ProductImage::addProductImage');


//Staff
$routes->get('staff', 'Staff::index');
$routes->get('staff/add', 'Staff::addStaff'); // Create
$routes->get('staff/add/(:num)', 'Staff::addStaff/$1'); // Edit
$routes->post('staff/status', 'Staff::updateStatus');// Update status of a staff
$routes->post('staff/save', 'Staff::createnew');
$routes->post('staff/delete/(:any)', 'Staff::deleteStaff/$1');


//Customers
$routes->get('customer', 'Customer::index');
$routes->get('customer/view', 'Customer::view_cust'); // Create
$routes->get('customer/view/(:num)', 'Customer::view_cust/$1'); // Edit Page
$routes->post('customer/save', 'Customer::createnew');
$routes->post('customer/delete/(:any)', 'Customer::deleteCust/$1');
//$routes->post('customer/updateStatus', 'Customer::updateStatus');
$routes->post('customer/status', 'Customer::updateStatus');
$routes->get('customer/location/(:num)', 'Customer_address::location/$1');//customer address edit
$routes->get('customer_address/view/(:num)', 'Customer_address::view_address/$1');
$routes->get('customer_address/view/(:num)/(:num)', 'Customer_address::view_address/$1/$2');
$routes->post('customer_address/save', 'Customer_address::createnew');
$routes->post('customer_address/delete/(:any)', 'Customer_address::deleteAddress/$1');
//banners
$routes->get('banner', 'Banner::index');
//logout
$routes->post('/logout', 'Auth::logout'); 


//admin_updation
$routes->get('admin', 'Admin::index');
$routes->post('admin/save', 'Admin::createnew');
