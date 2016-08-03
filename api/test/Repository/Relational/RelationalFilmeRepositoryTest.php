<?php
namespace CineFavela\Repository\Relational;

use CineFavela\TestCase\RelationalRepositoryTestCase;
use CineFavela\Model\Filme;
use CineFavela\Model\Usuario;

class RelationalFilmeRepositoryTest extends RelationalRepositoryTestCase
{

    private $usuarioRepository;

    private $filmeRepository;

    public function setUp()
    {
        $this->usuarioRepository = new RelationalUsuarioRepository($this->mapper);
        $this->filmeRepository = new RelationalFilmeRepository($this->mapper);
    }

    /**
     * @test
     */
    public function testaSePersisteFilme()
    {
        $usuario = new Usuario();
        $usuario->setNome("Reginaldo Jovem");
        $usuario->setEmail("reginaldo.tulio@gmail.com");
        $usuario->setSenha("123456");
        $this->usuarioRepository->persist($usuario);
        
        $filme = new Filme();
        $filme->setUsuario($usuario);
        $filme->setTitulo("Filme do João");
        $filme->setSinopse("O filme do joão xpto cablabla 123");
        $filme->setLinkYoutube("https://www.youtube.com/watch?v=PbgKEjNBHqM");
        
        $this->filmeRepository->persist($filme);
        $this->assertGreaterThan(0, $filme->getId());
        $this->assertNotNull($filme->getCriadoEm());
        
        return $filme;
    }

    /**
     * @test
     * @depends testaSePersisteFilme
     */
    public function testaSeObtemFilmePorId($filme)
    {
        $filmeNoBanco = $this->filmeRepository->get($filme->getId());
        
        $this->assertEquals($filme->getId(), $filmeNoBanco->getId());
        $this->assertInstanceOf("CineFavela\Model\Usuario", $filmeNoBanco->getUsuario());
        $this->assertEquals($filme->getTitulo(), $filmeNoBanco->getTitulo());
        $this->assertEquals($filme->getSinopse(), $filmeNoBanco->getSinopse());
        $this->assertEquals($filme->getCriadoEm(), $filmeNoBanco->getCriadoEm());
        $this->assertEquals($filme->getAtualizadoEm(), $filmeNoBanco->getAtualizadoEm());
    }
}