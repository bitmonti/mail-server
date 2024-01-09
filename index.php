<?php
require __DIR__ . '/init.php';

ini_set('display_errors', 1); // Turn on/off error reporting
error_reporting(E_ALL); // Turn on/off error reporting

// set routes
$routes = [
  '/send/mail' => [
    'controller' => 'mailController',
    'method' => 'sendMail'
  ],
];

$pathInfo = strtolower($_SERVER['PATH_INFO']);

// render route
if (isset($routes[$pathInfo])) {
  $route = $routes[$pathInfo];
  $controller = $container->make($route['controller']);
  $method = $route['method'];
  $controller->$method();
}
