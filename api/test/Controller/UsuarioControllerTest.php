<?php
namespace CineFavela\Controller;

use GuzzleHttp\Client;
use PHPUnit\Framework\TestCase;

class UsuarioControllerTest extends TestCase
{

    private $client;

    public function setUp()
    {
        $this->client = new Client();
    }

    /**
     * @test
     */
    public function testaSeCadastraUsuario()
    {
        $usuario = new \stdClass();
        $usuario->nome = "Ricardo Ledo";
        $usuario->email = "ricardo.tulio@fatec.sp.gov.br";
        $usuario->senha = "gf155c44";
        
        $res = $this->client->post("http://localhost:8080/api/public/v1/usuarios/", [
            "json" => $usuario,
            "headers" => [
                "Accept" => "application/json"
            ]
        ]);
        
        $body = $res->getBody()->getContents();
        $responseObject = json_decode($body);
        
        $this->assertEquals(200, $res->getStatusCode());
        $this->assertGreaterThan(0, $responseObject->data->id);
        $this->assertEquals($usuario->nome, $responseObject->data->nome);
        $this->assertEquals($usuario->email, $responseObject->data->email);
        $this->assertEquals($usuario->senha, $responseObject->data->senha);
        
        return $responseObject->data;
    }

    /**
     * @test
     * @depends testaSeCadastraUsuario
     */
    public function testaSeObtemUsuarioPorId($usuario)
    {
        $res = $this->client->get('http://localhost:8080/api/public/v1/usuarios/' . $usuario->id, [
            "headers" => [
                "Accept" => "application/json"
            ]
        ]);
        
        $body = $res->getBody()->getContents();
        $responseObject = json_decode($body);
        
        $this->assertEquals(200, $res->getStatusCode());
        $this->assertEquals($usuario->id, $responseObject->data->id);
        $this->assertEquals($usuario->nome, $responseObject->data->nome);
        $this->assertEquals($usuario->email, $responseObject->data->email);
        $this->assertEquals($usuario->senha, $responseObject->data->senha);
    }
}