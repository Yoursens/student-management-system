<?php
use CodeIgniter\Router\RouteCollection;
/**
 * @var RouteCollection $routes
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('HomeController');   // ← changed
$routes->setDefaultMethod('landing');              // ← changed
$routes->setTranslateURIDashes(false);
$routes->set404Override();
$routes->setAutoRoute(false);

// ─── Landing & Auth Routes ────────────────────────────────────
$routes->get('/',       'HomeController::landing');  // ← changed
$routes->get('landing', 'HomeController::landing');
$routes->get('login',   'AuthController::login');
$routes->post('login',  'AuthController::loginPost');
$routes->get('logout',  'AuthController::logout');

// ─── Admin Routes ─────────────────────────────────────────────
$routes->group('admin', ['filter' => 'auth:Admin'], function ($routes) {
    $routes->get('dashboard',                'AdminController::dashboard');
    $routes->get('students',                 'StudentController::index');
    $routes->get('students/create',          'StudentController::create');
    $routes->post('students/store',          'StudentController::store');
    $routes->get('students/edit/(:num)',     'StudentController::edit/$1');
    $routes->post('students/update/(:num)',  'StudentController::update/$1');
    $routes->post('students/delete/(:num)',  'StudentController::delete/$1');
    $routes->get('students/view/(:num)',     'StudentController::view/$1');
    $routes->get('users',                    'UserController::index');
    $routes->get('users/create',             'UserController::create');
    $routes->post('users/store',             'UserController::store');
    $routes->get('users/edit/(:num)',        'UserController::edit/$1');
    $routes->post('users/update/(:num)',     'UserController::update/$1');
    $routes->post('users/delete/(:num)',     'UserController::delete/$1');
    $routes->get('audit-logs',               'AdminController::auditLogs');
});

// ─── Staff Routes ──────────────────────────────────────────────
$routes->group('staff', ['filter' => 'auth:Staff'], function ($routes) {
    $routes->get('dashboard',                'StaffController::dashboard');
    $routes->get('students',                 'StudentController::indexStaff');
    $routes->get('students/view/(:num)',     'StudentController::view/$1');
});

// ─── REST API Routes ───────────────────────────────────────────
$routes->group('api', ['filter' => 'apiAuth'], function ($routes) {
    $routes->get('students',             'ApiController::students');
    $routes->get('students/(:num)',      'ApiController::studentById/$1');
    $routes->get('users',               'ApiController::users');
    $routes->get('stats',               'ApiController::stats');
});