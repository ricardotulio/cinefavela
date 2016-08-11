<?php
namespace CineFavela\Controller;

use PDO;
use Respect\Relational\Mapper;
use GuzzleHttp\Client;
use PHPUnit\Framework\TestCase;
use function GuzzleHttp\json_decode;
use GuzzleHttp\Exception\RequestException;

class AutenticacaoControllerTest extends TestCase
{

    private $client;

    private $mapper;

    public function setUp()
    {
        $db = new PDO("mysql:host=localhost;dbname=cinefavela_test", "root", "123456");
        $this->mapper = new Mapper($db);
        $this->client = new Client();
    }

    public function provider()
    {
        return array(
            array(
                null,
                "123456"
            ),
            array(
                "",
                "123456"
            ),
            array(
                "email",
                "123456"
            ),
            array(
                "naoexisto@teste.com.br",
                "123456"
            ),
            array(
                "naoexisto@teste.com.br",
                null
            ),
            array(
                "naoexisto@teste.com.br",
                ""
            )
        );
    }

    /**
     * @test
     * @dataProvider provider
     */
    public function testaSeInformaUsuarioESenhaInvalidos($email, $senha)
    {
        $usuario = new \stdClass();
        $usuario->email = $email;
        $usuario->senha = $senha;
        
        $res = null;
        
        try {
            $res = $this->client->post("http://localhost:8080/api/public/v1/autenticacao", [
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
        
        $body = $res->getBody();
        $responseObj = json_decode($body->getContents());
        
        $this->assertEquals(400, $res->getStatusCode());
        $this->assertEquals(1, count($responseObj->errors));
        $this->assertEquals(400, $responseObj->errors[0]->code);
        $this->assertEquals("Dados para autenticação inválidos.", $responseObj->errors[0]->message);
    }

    /**
     * @test
     */
    public function testaSeAutenticaUsuario()
    {
        $usuarioValido1 = new \stdClass();
        $usuarioValido1->nome = "Ricardo Tulio";
        $usuarioValido1->email = "tulio.ricardo@gmail.com";
        $usuarioValido1->senha = "abc123";
        
        // Cria usuário antes de autenticá-lo
        $this->client->post("http://localhost:8080/api/public/v1/usuarios", [
            "json" => $usuarioValido1,
            "headers" => [
                "Accept" => "application/json",
                "Content-Type" => "application/json",
                "Pragma" => "no-cache"
            ]
        ]);
        
        $res = $this->client->post("http://localhost:8080/api/public/v1/autenticacao", [
            "json" => $usuarioValido1,
            "headers" => [
                "Accept" => "application/json",
                "Content-Type" => "application/json",
                "Pragma" => "no-cache"
            ]
        ]);
        
        $body = $res->getBody();
        $responseObj = json_decode($body);
        
        $this->assertEquals(200, $res->getStatusCode());
        $this->assertRegExp("([a-f0-9]{40})", $responseObj->data->token_acesso);
    }
}