<?php

namespace CineFavela\Model;

use PHPUnit\Framework\TestCase;

class UsuarioTest extends TestCase {
	
	/**
	 * @test
	 */
	public function testaSeAutenticaUsuario() {
		$usuario = new Usuario();
		$usuario->setNome("Ricardo Ledo");
		$usuario->setEmail("ricardo.tulio@fatec.sp.gov.br");
		$usuario->setSenha("123456");
		
		$this->assertFalse($usuario->autentica("123454"));
		$this->assertFalse($usuario->autentica("123457"));
		$this->assertTrue($usuario->autentica("123456"));
	}
}