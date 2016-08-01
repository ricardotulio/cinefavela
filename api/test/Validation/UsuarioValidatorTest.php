<?php
namespace CineFavela\Validation;

use PHPUnit\Framework\TestCase;
use CineFavela\Model\Usuario;

class UsuarioValidatorTest extends TestCase
{

    public function provider()
    {
        return array(
            array(
                null,
                "ricardo.tulio@fatec.sp.gov.br",
                "123456",
                false
            ),
            array(
                "",
                "ricardo.tulio@fatec.sp.gov.br",
                "123456",
                false
            ),
            array(
                "",
                "ricardo.tulio@fatec.sp.gov.br",
                "123456",
                false
            ),
            array(
                "ri",
                "ricardo.tulio@fatec.sp.gov.br",
                "123456",
                false
            ),
            array(
                "Ricardo Ledo de Tulio Oliveira Silva Machado Tulio Bedaque Ma",
                "ricardo.tulio@fatec.sp.gov.br",
                "123456",
                false
            ),
            array(
                "Ricardo Ledo de Tulio",
                "ricardo.tulio",
                "123456",
                false
            ),
            array(
                "Ricardo Ledo de Tulio",
                "ricardo.tulio@.",
                "123456",
                false
            ),
            array(
                "Ricardo Ledo de Tulio",
                "@uol.com.br",
                "123456",
                false
            ),
            array(
                "Ricardo Ledo de Tulio",
                "ricardo.tulio@fatec.sp.gov.br",
                "12345",
                false
            ),
            array(
                "Ricardo Ledo de Tulio",
                "ricardo.tulio@fatec.sp.gov.br",
                "012345678901234567890",
                false
            ),
            array(
                "Ric",
                "ricardo.tulio@fatec.sp.gov.br",
                "123456",
                true
            ),
            array(
                "Ricardo Ledo de Tulio Oliveira Silva Machado Tulio Bedaque M",
                "ricardo.tulio@fatec.sp.gov.br",
                "123456",
                true
            ),
            array(
                "Ricardo Ledo de Tulio",
                "ricardo.tulio@fatec.sp.gov.br",
                "01234567890123456789",
                true
            )            
        );
    }
    
    /**
     * @test
     * @dataProvider provider
     */
    public function testaSeValidaUsuario($nome, $email, $senha, $resultadoEsperado) {
        $usuario = new \stdClass();
        $usuario->nome = $nome;
        $usuario->email = $email;
        $usuario->senha = $senha;
        
        $validator = new UsuarioValidator();
        $this->assertEquals($resultadoEsperado, $validator->validate($usuario));
    }
}