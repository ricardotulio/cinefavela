<?php
namespace CineFavela\Repository\Relational;

use CineFavela\TestCase\RelationalRepositoryTestCase;
use CineFavela\Model\Sessao;
use CineFavela\Model\Usuario;

class RelationalSessaoRepositoryTest extends RelationalRepositoryTestCase
{

    private $sessaoRepository;

    private $usuarioRepository;

    private $usuario;

    public function setUp()
    {
        $this->sessaoRepository = new RelationalSessaoRepository($this->mapper);
        $this->usuarioRepository = new RelationalUsuarioRepository($this->mapper);
    }

    /**
     * @test
     */
    public function testaSePersisteSessao()
    {
        $usuario = new Usuario();
        $usuario->setNome("Ricardo Jovem Coisado");
        $usuario->setEmail("jovem@coisado.com.br");
        $usuario->setSenha("123456");
        $this->usuarioRepository->persist($usuario);
        
        $sessao = new Sessao();
        $sessao->setUsuario($usuario);
        $sessao->setDataHoraInicio(date('Y-m-d H:i:s'));
        $sessao->setDataHoraFim(date('Y-m-d H:i:s'));
        
        $this->sessaoRepository->persist($sessao);
        
        $this->assertRegExp("([a-f0-9]{40})", $sessao->getId());
        
        return $sessao;
    }

    /**
     * @test
     * @depends testaSePersisteSessao
     */
    public function testaSeObtemSessaoPorId($sessao)
    {
        $sessaoNoBanco = $this->sessaoRepository->get($sessao->getId());
        
        $this->assertEquals($sessao->getId(), $sessaoNoBanco->getId());
        $this->assertEquals($sessao->getDataHoraInicio(), $sessaoNoBanco->getDataHoraInicio());
        $this->assertEquals($sessao->getDataHoraFim(), $sessaoNoBanco->getDataHoraFim());
    }
}