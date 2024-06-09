<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'TestController::index');

$routes->get('login', 'Auth::login');
$routes->post('login-complete', 'Auth::loginComplete');
$routes->get('logout', 'Auth::logout');


$routes->get('register', 'Auth::register');
$routes->post('register-complete', 'Auth::registerComplete');
$routes->post('register-username', 'Auth::registerUsername');
$routes->post('register-email', 'Auth::registerEmail');

$routes->group('/', ['filter' => 'auth'], function ($routes) {
    $routes->get('category/(:num)', 'TestController::categoryRender/$1');
    $routes->get('test/(:num)', 'TestController::test/$1');
    $routes->get('test-attempt/(:num)', 'TestController::testAttempt/$1');
    $routes->post('test-password', 'TestController::testPassword');
    $routes->get('test-start/(:num)', 'TestController::testFree/$1');
    $routes->post('test-complete', 'TestController::testComplete');
});

$routes->group('dashboard', ['filter' => 'dashboard'], function ($routes) {
    $routes->get('/', 'Dashboard::index');
    $routes->get('tests', 'Dashboard::tests');

    //attempts
    $routes->get('attempts', 'Dashboard::attempts');
    $routes->delete('delete-attempt/(:num)', 'Dashboard::deleteAttempt/$1');

    //categories
    $routes->get('categories', 'Dashboard::categories');
    $routes->get('edit-category/(:num)', 'Dashboard::editCategory/$1');
    $routes->post('update-category/(:num)', 'Dashboard::updateCategory/$1');
    $routes->delete('delete-category/(:num)', 'Dashboard::deleteCategory/$1');
    $routes->get('add-category', 'Dashboard::addCategory');
    $routes->post('create-category', 'Dashboard::createCategory');

    //users
    $routes->get('users', 'Dashboard::users');
    $routes->get('edit-user/(:num)', 'Dashboard::editUser/$1'); //Opens page with forms.
    $routes->post('update-user/(:num)', 'Dashboard::updateUser/$1');//Updates the user in the database.
    $routes->delete('delete-user/(:num)', 'Dashboard::deleteUser/$1');//Deletes the user in the database.
});