<?php
require __DIR__ . '/init.php';

ini_set('display_errors', 0); // Turn on/off error reporting
// error_reporting(E_ALL); // Turn on/off error reporting

// set routes
$routes = [
  '/send/mail' => [
    'controller' => 'mailController',
    'method' => 'sendMail'
  ]
];

$pathInfo = strtolower($_SERVER['PATH_INFO']);

// render route
if (isset($routes[$pathInfo])) {
  $route = $routes[$pathInfo];
  $controller = $container->make($route['controller']);
  $method = $route['method'];
  $controller->$method();
}
?>

<!DOCTYPE HTML>
<html lang="de">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>&#128640; &#127757; &#128187; &#10024; &#127796;</title>
</head>

<body>
  <div>
    <p style="font-size: 28px;">&#129322;</p>
  </div>
</body>

</html>

<?php ob_end_flush(); ?>