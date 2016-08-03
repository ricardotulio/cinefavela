<?php
namespace CineFavela\Controller;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use PHPUnit\Framework\TestCase;

class FilmeControllerTest extends TestCase
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
                    "Pragma" => "no-cache"
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
        $usuarioQueVaiCadastrarOFilme = new \stdClass();
        $usuarioQueVaiCadastrarOFilme->nome = "Novo Usuario Cadastrador";
        $usuarioQueVaiCadastrarOFilme->email = "cadastrador@teste.com.br";
        $usuarioQueVaiCadastrarOFilme->senha = "123456";
        
        $this->client->post("http://localhost:8080/api/public/v1/usuarios/", [
            "json" => $usuarioQueVaiCadastrarOFilme,
            "headers" => [
                "Accept" => "application/json",
                "Content-Type" => "application/json",
                "Pragma" => "no-cache"
            ]
        ]);
        
        $resAuth = $this->client->post("http://localhost:8080/api/public/v1/autenticacao/", [
            "json" => $usuarioQueVaiCadastrarOFilme,
            "headers" => [
                "Accept" => "application/json",
                "Content-Type" => "application/json",
                "Pragma" => "no-cache"
            ]
        ]);
        
        $auth = json_decode($resAuth->getBody()->getContents());
        
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
                "Authorization" => $auth->data->token_acesso
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