<?php
namespace CineFavela\Controller;

use GuzzleHttp\Client;
use PHPUnit\Framework\TestCase;
use GuzzleHttp\Exception\RequestException;

class UsuarioControllerTest extends TestCase
{

    private $client;

    public function setUp()
    {
        $this->client = new Client();
    }

    public function provider()
    {
        return array(
            array(
                null,
                "ricardo.tulio@fatec.sp.gov.br",
                "123456"
            ),
            array(
                "",
                "ricardo.tulio@fatec.sp.gov.br",
                "123456"
            ),
            array(
                "",
                "ricardo.tulio@fatec.sp.gov.br",
                "123456"
            ),
            array(
                "ri",
                "ricardo.tulio@fatec.sp.gov.br",
                "123456"
            ),
            array(
                "Ricardo Ledo de Tulio Oliveira Silva Machado Tulio Bedaque Ma",
                "ricardo.tulio@fatec.sp.gov.br",
                "123456"
            ),
            array(
                "Ricardo Ledo de Tulio",
                "ricardo.tulio",
                "123456"
            ),
            array(
                "Ricardo Ledo de Tulio",
                "ricardo.tulio@.",
                "123456"
            ),
            array(
                "Ricardo Ledo de Tulio",
                "@uol.com.br",
                "123456"
            ),
            array(
                "Ricardo Ledo de Tulio",
                "ricardo.tulio@fatec.sp.gov.br",
                "12345"
            ),
            array(
                "Ricardo Ledo de Tulio",
                "ricardo.tulio@fatec.sp.gov.br",
                "012345678901234567890"
            )
        );
    }

    /**
     * @test
     * @dataProvider provider
     */
    public function testaSeRetornaErro400QuandoDadosDeUsuarioInvalidos($nome, $email, $senha)
    {
        $usuario = new \stdClass();
        $usuario->nome = $nome;
        $usuario->email = $email;
        $usuario->senha = $senha;
        
        $res = null;
        
        try {
            $this->client->post("http://localhost:8080/api/public/v1/usuarios/", [
                "json" => $usuario,
                "headers" => [
                    "Accept" => "application/json",
                    "Content-Type" => "application/json",
                    "Pragma" => "no-cache"
                ]
            ]);
        } catch (RequestException $e) {
            $res = $e->getResponse();
        }
        
        $body = $res->getBody()->getContents();
        $responseObject = json_decode($body);
        
        $this->assertEquals(400, $res->getStatusCode());
        $this->assertEquals(1, count($responseObject->errors));
        $this->assertEquals(400, $responseObject->errors[0]->code);
        $this->assertEquals("Os dados informados para cadastro de usuário são inválidos.", $responseObject->errors[0]->message);
    }

    /**
     * @test
     */
    public function testaSeCadastraUsuario()
    {
        $usuario = new \stdClass();
        $usuario->nome = "Ricardo Ledo";
        $usuario->email = "outroemail@fatec.sp.gov.br";
        $usuario->senha = "gf155c44";
        
        $res = $this->client->post("http://localhost:8080/api/public/v1/usuarios/", [
            "json" => $usuario,
            "headers" => [
                "Accept" => "application/json",
                "Content-Type" => "application/json",
                "Pragma" => "no-cache"
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
                "Accept" => "application/json",
                "Content-Type" => "application/json",
                "Pragma" => "no-cache"
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