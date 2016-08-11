<?php
namespace CineFavela\Controller;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use PHPUnit\Framework\TestCase;
use function GuzzleHttp\json_decode;

class FilmeControllerTest extends TestCase
{

    private $client;

    private static $token_acesso;
    
    /**
     * @beforeClass
     */
    public static function beforeClass() {
        $client = new Client();
        
        $usuario = new \stdClass();
        $usuario->nome = "Ricardo Tulio";
        $usuario->email = "abcdefghijklm@gmail.com";
        $usuario->senha = "abc123";
        
        // Cria usuário antes de autenticá-lo
        $client->post("http://localhost:8080/api/public/v1/usuarios", [
            "json" => $usuario,
            "headers" => [
                "Accept" => "application/json",
                "Content-Type" => "application/json",
                "Pragma" => "no-cache"
            ]
        ]);
        
        $res = $client->post("http://localhost:8080/api/public/v1/autenticacao", [
            "json" => $usuario,
            "headers" => [
                "Accept" => "application/json",
                "Content-Type" => "application/json",
                "Pragma" => "no-cache"
            ]
        ]);
        
        $body = $res->getBody();
        $responseObj = json_decode($body->getContents());
        
        self::$token_acesso = $responseObj->data->token_acesso;
    }

    public function setUp()
    {
        $this->client = new Client();
        

    }

    public function provider()
    {
        return array(
            array(
                null,
                "Este filme conta a história de um homem que vivia fazendo testes automatizados para facilitar o seu trabalho como programador. É o programador automatizado.",
                "https://www.youtube.com/watch?v=boanuwUMNNQ"
            ),
            array(
                "",
                "Este filme conta a história de um homem que vivia fazendo testes automatizados para facilitar o seu trabalho como programador. É o programador automatizado.",
                "https://www.youtube.com/watch?v=boanuwUMNNQ"
            ),
            array(
                "ab",
                "Este filme conta a história de um homem que vivia fazendo testes automatizados para facilitar o seu trabalho como programador. É o programador automatizado.",
                "https://www.youtube.com/watch?v=boanuwUMNNQ"
            ),
            array(
                "ab",
                "Este filme conta a história de um homem que vivia fazendo testes automatizados para facilitar o seu trabalho como programador. É o programador automatizado.",
                "https://www.youtube.com/watch?v=boanuwUMNNQ"
            ),
            array(
                "Este filme conta a história de um homem que vivia fazendo testes automatizados para facilitar o seu trabalho como prograw",
                "Este filme conta a história de um homem que vivia fazendo testes automatizados para facilitar o seu trabalho como programador. É o programador automatizado.",
                "https://www.youtube.com/watch?v=boanuwUMNNQ"
            ),
            array(
                "abc",
                null,
                "https://www.youtube.com/watch?v=boanuwUMNNQ"
            ),
            array(
                "abc",
                "",
                "https://www.youtube.com/watch?v=boanuwUMNNQ"
            ),
            array(
                "abc",
                "Este filme conta a história de um homem que vivia fazendo testes automatizados para facilitar o seu trabalho como programador. É o programa",
                "https://www.youtube.com/watch?v=boanuwUMNNQ"
            ),
            array(
                "abc",
                "Este filme conta a história de um homem que vivia fazendo testes automatizados para facilitar o seu trabalho como programador. É o programador coisado.",
                null
            ),
            array(
                "abc",
                "Este filme conta a história de um homem que vivia fazendo testes automatizados para facilitar o seu trabalho como programador. É o programador coisado.",
                ""
            ),
            array(
                "abc",
                "Este filme conta a história de um homem que vivia fazendo testes automatizados para facilitar o seu trabalho como programador. É o programador coisado.",
                "youtube.com"
            ),
            array(
                "abc",
                "Este filme conta a história de um homem que vivia fazendo testes automatizados para facilitar o seu trabalho como programador. É o programador coisado.",
                "http://"
            ),
            array(
                "abc",
                "Este filme conta a história de um homem que vivia fazendo testes automatizados para facilitar o seu trabalho como programador. É o programador coisado.",
                "http://www.google.com"
            ),
            array(
                "abc",
                "Este filme conta a história de um homem que vivia fazendo testes automatizados para facilitar o seu trabalho como programador. É o programador coisado.",
                "https://www.youtube.com.br"
            ),
            array(
                "abc",
                "Este filme conta a história de um homem que vivia fazendo testes automatizados para facilitar o seu trabalho como programador. É o programador coisado.",
                "https://www.youtube.com"
            )
        );
    }

    /**
     * @test
     * @dataProvider provider
     */
    public function testaSeRetornaErro400QuandoDadosDoFilmeInvalido($titulo, $sinopse, $linkYoutube)
    {
        $filme = new \stdClass();
        $filme->titulo = $titulo;
        $filme->descricao = $sinopse;
        $filme->linkYoutube = $linkYoutube;
        
        $res = null;
        
        try {
            $res = $this->client->post("http://localhost:8080/api/public/v1/filmes/", [
                "json" => $filme,
                "headers" => [
                    "Accept" => "application/json",
                    "Content-Type" => "application/json",
                    "Pragma" => "no-cache",
                    "Authorization" => self::$token_acesso
                ]
            ]);
        } catch (RequestException $e) {
            $res = $e->getResponse();
        }
        
        $body = $res->getBody();
        $responseObj = json_decode($body);
        
        $this->assertEquals(400, $res->getStatusCode());
        $this->assertEquals(1, count($responseObj->errors));
        $this->assertEquals(400, $responseObj->errors[0]->code);
        $this->assertEquals("Os dados informados para cadastro de filme são inválidos.", $responseObj->errors[0]->message);
    }

    /**
     * @test
     */
    public function testaSeCadastraFilme()
    {       
        $filme = new \stdClass();
        $filme->titulo = "Filme do João";
        $filme->sinopse = "Este filme conta a história de um homem que vivia fazendo testes automatizados para facilitar o seu trabalho como programador. É o programador coisado.";
        $filme->linkYoutube = "https://www.youtube.com/watch?v=SXMe2VCTdtY";
        
        $res = $this->client->post("http://localhost:8080/api/public/v1/filmes/", [
            "json" => $filme,
            "headers" => [
                "Accept" => "application/json",
                "Content-Type" => "application/json",
                "Pragma" => "no-cache",
                "Authorization" => self::$token_acesso
            ]
        ]);
        
        $body = $res->getBody();
        $responseObj = json_decode($body->getContents());
        
        $this->assertEquals(200, $res->getStatusCode());
        $this->assertGreaterThan(0, $responseObj->data->id);
        $this->assertEquals($filme->titulo, $responseObj->data->titulo);
        $this->assertEquals($filme->sinopse, $responseObj->data->sinopse);
        $this->assertEquals($filme->linkYoutube, $responseObj->data->linkYoutube);
    }
}