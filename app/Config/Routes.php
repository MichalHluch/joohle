<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');


$routes->get('login', 'Auth::login');
$routes->post('login-complete', 'Auth::loginComplete');
$routes->get('logout', 'Auth::logout');


$routes->get('register', 'Auth::register');
$routes->post('register-complete', 'Auth::registerComplete');
$routes->post('register-username', 'Auth::registerUsername');
$routes->post('register-email', 'Auth::registerEmail');

$routes->group('auth', ['filter' => 'auth'], function ($routes) {
});

$routes->group('dashboard', ['filter' => 'dashboard'], function ($routes) {
    $routes->get('/', 'Dashboard::index');
    $routes->get('tests', 'Dashboard::tests');


    $routes->get('users', 'Dashboard::users');
    $routes->get('edit-user/(:num)', 'Dashboard::editUser/$1'); //Opens page with forms
    $routes->post('update-user/(:num)', 'Dashboard::updateUser/$1');//Updates the user in the database
    $routes->delete('delete-user/(:num)', 'Dashboard::deleteUser/$1');
});