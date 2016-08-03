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

use CineFavela\Infraestructure\Autorizador;
use Respect\Config\Container;
use Respect\Rest\Router;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

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

$sessaoRepository = $container->sessaoRepository;

$rotinaAutorizacao = function () use ($router, $sessaoRepository, $serializer) {
    $router->request->headers = getallheaders();
    $autorizador = new Autorizador($sessaoRepository);
    
    if (! $autorizador->autoriza($router->request)) {
        header("HTTP/1.1 401 Unauthorized");
        echo $serializer->serialize(array(
            "errors" => array(
                array(
                    "code" => "401",
                    "message" => "Não autorizado."
                )
            )
        ), "json");
        
        return false;
    }
    
    return true;
};

$router->always("Accept", array(
    "application/json" => function ($input) use ($serializer) {
        return $serializer->serialize($input, "json");
    }
));

$router->post("/v1/usuarios/*", "CineFavela\\Controller\\UsuarioController", array(
    $container->usuarioValidator,
    $container->usuarioRepository
));

$router->post("/v1/autenticacao", "CineFavela\\Controller\\AutenticacaoController", array(
    $container->usuarioRepository,
    $container->sessaoRepository
));

$router->any("/v1/filmes/*", "CineFavela\\Controller\\FilmeController", array(
    $container->filmeValidator,
    $container->sessaoRepository,
    $container->filmeRepository
))->by($rotinaAutorizacao);

echo $router->run();