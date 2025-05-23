<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
/* GET METHODS */
$routes->get('/', 'Home::index');






// $routes->group('admin', ['namespace' => 'App\Controllers\admin'], function($routes) {

$routes->get('admin', 'Admin\Home::index'); 
$routes->post('admin/Auth', 'Admin\Auth::authenticate'); 
$routes->get('admin/dashboard', 'Admin\Dashboard::index'); 



//category
$routes->get('admin/category', 'Admin\Category::index');
$routes->get('admin/category/add', 'Admin\Category::addCategory');
$routes->get('admin/category/edit/(:num)', 'Admin\Category::addCategory/$1'); 
$routes->post('admin/category/save', 'Admin\Category::saveCategory');
$routes->post('admin/category/status', 'Admin\Category::changeStatus');
$routes->post('admin/category/delete/(:any)', 'Admin\Category::deleteCategory/$1');


//Subcategory
$routes->get('admin/subcategory', 'Admin\Subcategory::index');
$routes->post('admin/subcategory/List', 'Admin\Subcategory::ajaxList');
$routes->get('admin/subcategory/add', 'Admin\Subcategory::addSubcategory');
$routes->get('admin/subcategory/edit/(:num)', 'Admin\Subcategory::addSubcategory/$1'); 
$routes->post('admin/subcategory/save', 'Admin\Subcategory::saveSubcategory');
$routes->post('admin/subcategory/delete/(:any)', 'Admin\Subcategory::deleteSubcategory/$1');
$routes->post('admin/subcategory/status', 'Admin\Subcategory::changeStatus');


//Products
$routes->get('admin/product', 'Admin\Product::index');
$routes->post('admin/product/List', 'Admin\Product::ajaxList');
$routes->get('admin/product/add', 'Admin\Product::addProduct');
$routes->get('admin/product/edit/(:num)', 'Admin\Product::addProduct/$1'); 
$routes->post('admin/product/save', 'Admin\Product::saveProduct');
$routes->post('admin/product/delete/(:any)', 'Admin\Product::deleteProduct/$1');
$routes->post('admin/product/get-subcategories', 'Admin\Product::getSubcategories');
$routes->post('admin/product/upload-media', 'Admin\Product::uploadMedia');
$routes->get('admin/product/get-product-images/(:num)', 'Admin\Product::getProductImages/$1');
$routes->post('admin/product/delete-product-image', 'Admin\Product::deleteProductImage');
$routes->post('admin/product/video', 'Admin\Product::ProductuploadVideo');
$routes->post('admin/product/getVideo', 'Admin\Product::getVideo');
$routes->post('admin/product/deletevideo','Admin\Product::deleteVideo');
$routes->post('admin/product/status', 'Admin\Product::changeStatus');




//Staff
$routes->get('admin/staff', 'Admin\Staff::index');
$routes->post('admin/staff/List', 'Admin\Staff::ajaxList');
$routes->get('admin/staff/add', 'Admin\Staff::addStaff'); // Create
$routes->get('admin/staff/add/(:num)', 'Admin\Staff::addStaff/$1'); // Edit
$routes->post('admin/staff/status', 'Admin\Staff::updateStatus');// Update status of a staff
$routes->post('admin/staff/save', 'Admin\Staff::createnew');
$routes->post('admin/staff/delete/(:any)', 'Admin\Staff::deleteStaff/$1');


//Customers
$routes->get('admin/customer', 'Admin\Customer::index');
$routes->get('admin/customer/view', 'Admin\Customer::view_cust'); // Create
$routes->get('admin/customer/view/(:num)', 'Admin\Customer::view_cust/$1'); // Edit Page
$routes->post('admin/customer/save', 'Admin\Customer::createnew');
$routes->post('admin/customer/delete/(:any)', 'Admin\Customer::deleteCust/$1');
//$routes->post('customer/updateStatus', 'Customer::updateStatus');
$routes->post('admin/customer/status', 'Admin\Customer::updateStatus');
$routes->get('admin/customer/location/(:num)', 'Admin\Customer_address::location/$1');//customer address edit
$routes->get('admin/customer_address/view/(:num)', 'Admin\Customer_address::view_address/$1');
$routes->get('admin/customer_address/view/(:num)/(:num)', 'Admin\Customer_address::view_address/$1/$2');
$routes->post('admin/customer_address/save', 'Admin\Customer_address::createnew');
$routes->post('admin/customer_address/delete/(:any)', 'Admin\Customer_address::deleteAddress/$1');



//Themes
$routes->get('admin/themes', 'Admin\Themes::index');
$routes->post('admin/themes/List', 'Admin\Themes::ajaxList');
$routes->post('admin/themes/status', 'Admin\Themes::updateStatus');
$routes->get('admin/themes/add', 'Admin\Themes::addbanner'); // Create
$routes->get('admin/themes/add/(:num)', 'Admin\Themes::addbanner/$1'); // Edit
//$routes->post('themes/save', 'Themes::save_file');
$routes->post('admin/themes/delete/(:any)', 'Admin\Themes::deleteBanner/$1');
$routes->post('admin/themes/save_file', 'Admin\Themes::save_file');

//logout
$routes->post('admin/logout', 'Admin\Auth::logout'); 





//banners
$routes->get('admin/banner', 'Admin\Banner::index');
$routes->post('admin/banner/List', 'Admin\Banner::ajaxList');
$routes->post('admin/banner/status', 'Admin\Banner::updateStatus');
$routes->get('admin/banner/add', 'Admin\Banner::addbanner'); // Create
$routes->get('admin/banner/add/(:num)', 'Admin\Banner::addbanner/$1'); // Edit
$routes->post('admin/banner/save', 'Admin\Banner::createnew');
$routes->post('admin/banner/delete/(:any)', 'Admin\Banner::deleteBanner/$1');


//offer banners
$routes->get('offer_banner', 'Offer_Banner::index');
$routes->post('offer_banner/List', 'Offer_Banner::ajaxList');
$routes->post('offer_banner/changeStatus', 'Offer_Banner::updateStatus');
$routes->get('offer_banner/add', 'Offer_Banner::addbanner'); // Create
$routes->get('offer_banner/add/(:num)', 'Offer_Banner::addbanner/$1'); // Edit
$routes->post('offer_banner/save', 'Offer_Banner::createnew');
$routes->post('offer_banner/delete/(:any)', 'Offer_Banner::deleteBanner/$1');
$routes->post('offer_banner/get-subcategories', 'Offer_Banner::getSubcategories');
$routes->post('offer_banner/get-products', 'Offer_Banner::getProducts');
//admin_updation
$routes->get('/admin', 'Admin::index');
$routes->post('admin/save', 'Admin::createnew');
//});
