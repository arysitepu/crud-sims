<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Auth::index');
$routes->get('/categories', 'Categories::index');
$routes->post('/login-process', 'Auth::login_process');
$routes->get('/logout', 'Auth::logout');

$routes->group('superadmin', ['filter' => 'authFilter:1'], function($routes){
    $routes->get('dashboard', 'Home::index');
    $routes->get('product', 'Product::index');
    $routes->get('add-product', 'Product::add');
    $routes->get('edit-product/(:num)', 'Product::edit/$1');
    $routes->post('update-product/(:num)', 'Product::update/$1');
    $routes->post('save-product', 'Product::save');
    $routes->delete('product/(:num)', 'Product::delete/$1');
    $routes->get('profile/(:num)', 'Home::profile/$1');
    $routes->get('edit-profile/(:num)', 'Home::edit_profile/$1');
    $routes->post('update-profile/(:num)', 'Home::update_profile/$1');
    $routes->get('search', 'Product::search');
});
$routes->group('user', ['filter' => 'authFilter:0'], function($routes){
    $routes->get('dashboard', 'Home::index');
});
