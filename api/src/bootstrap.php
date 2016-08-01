<?php
define('APPLICATION_ENVIRONMENT', 'testing');

if (defined('APPLICATION_ENVIRONMENT')) {
    switch (APPLICATION_ENVIRONMENT) {
        case 'development':
            error_reporting(E_ALL);
            ini_set('display_errors', 1);
            break;
        case 'testing':
        case 'production':
            error_reporting(0);
            ini_set('display_errors', 0);
            break;
    }
}

use Respect\Config\Container;
use Respect\Rest\Router;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

require_once ("../vendor/autoload.php");

$container = new Container("../config/" . APPLICATION_ENVIRONMENT . ".ini");

$encoders = array(
    new JsonEncoder()
);
$normalizers = array(
    new ObjectNormalizer()
);
$serializer = new Serializer($normalizers, $encoders);

$router = new Router("/api/public");

$router->always("Accept", array(
    "application/json" => function ($input) use ($serializer) {
        return $serializer->serialize(array(
            "data" => $input
        ), "json");
    }
));

$router->any("/v1/usuarios/*", "CineFavela\\Controller\\UsuarioController", array(
    $container->usuarioValidator,
    $container->usuarioRepository
));

echo $router->run();