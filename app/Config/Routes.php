<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */
$routes->get('/', 'Home::index');
$routes->get('tasks', 'Tasks::index');
$routes->get('profile', 'Profile::index');
$routes->get('about', 'About::index');
$routes->get('login', 'Auth::index');
$routes->post('login', 'Auth::attempt');
$routes->post('logout', 'Auth::logout');

$routes->group('', ['filter' => 'auth'], static function ($routes) {
    $routes->get('tasks/new', 'Tasks::new');
    $routes->post('tasks', 'Tasks::create');
    $routes->get('tasks/(:num)/edit', 'Tasks::edit/$1');
    $routes->post('tasks/(:num)', 'Tasks::update/$1');
    $routes->post('tasks/(:num)/toggle', 'Tasks::toggle/$1');
    $routes->post('tasks/(:num)/delete', 'Tasks::delete/$1');
});
