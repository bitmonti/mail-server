<?php
$cors = require __DIR__ . '/config/cross-origin.php';

header("Access-Control-Allow-Origin: " . $cors['allow']);
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, X-Requested-With");

setlocale(LC_TIME, 'de_DE');

require __DIR__ . '/autoload.php';
require __DIR__ . '/config/rootDirectory.php';

$container = new App\Core\Container();
