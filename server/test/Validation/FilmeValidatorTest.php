<?php
namespace CineFavela\Model;

use CineFavela\Validation\FilmeValidator;
use PHPUnit\Framework\TestCase;

class FilmeValidatorTest extends TestCase
{

    private $validator;

    public function setUp()
    {
        $this->validator = new FilmeValidator();
    }

    public function provider()
    {
        return array(
            array(
                null,
                "Este filme conta a história de um homem que vivia fazendo testes automatizados para facilitar o seu trabalho como programador. É o programador automatizado.",
                "https://www.youtube.com/watch?v=boanuwUMNNQ",
                false
            ),
            array(
                "",
                "Este filme conta a história de um homem que vivia fazendo testes automatizados para facilitar o seu trabalho como programador. É o programador automatizado.",
                "https://www.youtube.com/watch?v=boanuwUMNNQ",
                false
            ),
            array(
                "ab",
                "Este filme conta a história de um homem que vivia fazendo testes automatizados para facilitar o seu trabalho como programador. É o programador automatizado.",
                "https://www.youtube.com/watch?v=boanuwUMNNQ",
                false
            ),
            array(
                "ab",
                "Este filme conta a história de um homem que vivia fazendo testes automatizados para facilitar o seu trabalho como programador. É o programador automatizado.",
                "https://www.youtube.com/watch?v=boanuwUMNNQ",
                false
            ),
            array(
                "Este filme conta a história de um homem que vivia fazendo testes automatizados para facilitar o seu trabalho como prograw",
                "Este filme conta a história de um homem que vivia fazendo testes automatizados para facilitar o seu trabalho como programador. É o programador automatizado.",
                "https://www.youtube.com/watch?v=boanuwUMNNQ",
                false
            ),
            array(
                "abc",
                null,
                "https://www.youtube.com/watch?v=boanuwUMNNQ",
                false
            ),
            array(
                "abc",
                "",
                "https://www.youtube.com/watch?v=boanuwUMNNQ",
                false
            ),
            array(
                "abc",
                "Este filme conta a história de um homem que vivia fazendo testes automatizados para facilitar o seu trabalho como programador. É o programa",
                "https://www.youtube.com/watch?v=boanuwUMNNQ",
                false
            ),
            array(
                "abc",
                "Este filme conta a história de um homem que vivia fazendo testes automatizados para facilitar o seu trabalho como programador. É o programador coisado.",
                null,
                false
            ),
            array(
                "abc",
                "Este filme conta a história de um homem que vivia fazendo testes automatizados para facilitar o seu trabalho como programador. É o programador coisado.",
                "",
                false
            ),
            array(
                "abc",
                "Este filme conta a história de um homem que vivia fazendo testes automatizados para facilitar o seu trabalho como programador. É o programador coisado.",
                "youtube.com",
                false
            ),
            array(
                "abc",
                "Este filme conta a história de um homem que vivia fazendo testes automatizados para facilitar o seu trabalho como programador. É o programador coisado.",
                "http://",
                false
            ),
            array(
                "abc",
                "Este filme conta a história de um homem que vivia fazendo testes automatizados para facilitar o seu trabalho como programador. É o programador coisado.",
                "http://www.google.com",
                false
            ),
            array(
                "abc",
                "Este filme conta a história de um homem que vivia fazendo testes automatizados para facilitar o seu trabalho como programador. É o programador coisado.",
                "https://www.youtube.com.br",
                false
            ),
            array(
                "abc",
                "Este filme conta a história de um homem que vivia fazendo testes automatizados para facilitar o seu trabalho como programador. É o programador coisado.",
                "https://www.youtube.com",
                false
            ),
            array(
                "abc",
                "Este filme conta a história de um homem que vivia fazendo testes automatizados para facilitar o seu trabalho como programador. É o programador coisado.",
                "https://www.youtube.com/watch?v=LQUXuQ6Zd9w",
                true
            ),
            array(
                "Este filme conta a história de um homem que vivia fazendo testes automatizados para facilitar o seu trabalho como progra",
                "Este filme conta a história de um homem que vivia fazendo testes automatizados para facilitar o seu trabalho como programador. É o programador coisado.",
                "https://www.youtube.com/watch?v=-DDs98yXIoE",
                true
            ),
            array(
                "Filme Coisado",
                "Este filhttps://www.youtube.com/watch?v=-DDs98yXIoEme conta a história de um homem que vivia fazendo testes automatizados para facilitar o seu trabalho como programador. É o programador coisado.",
                "https://www.youtube.com/watch?v=-DDs98yXIoE",
                true
            ),
            array(
                "Filme Coisado",
                "Este filme conta a história de um homem que vivia fazendo testes automatizados para facilitar o seu trabalho como programador. É o programador coisado.",
                "https://www.youtube.com/watch?v=SXMe2VCTdtY",
                true
            )
        );
    }

    /**
     * @test
     * @dataProvider provider
     */
    public function testaSeValidaFilme($titulo, $sinopse, $linkYoutube, $resultadoEsperado)
    {
        $filme = new \stdClass();
        $filme->titulo = $titulo;
        $filme->sinopse = $sinopse;
        $filme->linkYoutube = $linkYoutube;
        
        $this->assertEquals($resultadoEsperado, $this->validator->validate($filme));
    }
}