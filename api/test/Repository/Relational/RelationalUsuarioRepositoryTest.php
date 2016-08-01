<?php
namespace CineFavela\Repository\Relational;

use CineFavela\TestCase\RelationalRepositoryTestCase;
use CineFavela\Model\Usuario;
use Respect\Relational\Mapper;

class RelationalUsuarioRepositoryTest extends RelationalRepositoryTestCase
{

    private $repository;

    public function setUp()
    {
        $this->repository = new RelationalUsuarioRepository($this->mapper);
    }

    /**
     * @test
     */
    public function testaSePersisteUsuario()
    {
        $usuario = new Usuario();
        $usuario->setNome("Ricardo Ledo");
        $usuario->setEmail("ledo.tulio@gmail.com");
        $usuario->setSenha("123456");
        
        $this->repository->persist($usuario);
        $this->assertGreaterThan(0, $usuario->getId());
        $this->assertNotNull($usuario->getCriadoEm());
        
        return $usuario;
    }

    /**
     * @depends testaSePersisteUsuario
     * @test
     */
    public function testaSeObtemUsuarioPorId($usuario)
    {
        $usuarioDoBanco = $this->repository->get($usuario->getId());
        
        $this->assertEquals($usuario->getId(), $usuarioDoBanco->getId());
        $this->assertEquals($usuario->getNome(), $usuarioDoBanco->getNome());
        $this->assertEquals($usuario->getEmail(), $usuarioDoBanco->getEmail());
        $this->assertEquals($usuario->getSenha(), $usuarioDoBanco->getSenha());
        $this->assertEquals($usuario->getCriadoEm(), $usuarioDoBanco->getCriadoEm());
        $this->assertEquals($usuario->getAtualizadoEm(), $usuarioDoBanco->getAtualizadoEm());
        
        return $usuarioDoBanco;
    }

    /**
     * @depends testaSeObtemUsuarioPorId
     * @test
     */
    public function testaSeAtualizaUsuario($usuario)
    {
        $usuarioParaAtualizar = $this->repository->get($usuario->getId());
        
        $usuarioParaAtualizar->setNome("Carlos Silva");
        $usuarioParaAtualizar->setSenha("654321");
        
        $this->repository->persist($usuarioParaAtualizar);
        
        $usuarioAposAtualizacao = $this->repository->get($usuarioParaAtualizar->getId());
        
        $this->assertEquals($usuarioParaAtualizar->getId(), $usuarioAposAtualizacao->getId());
        $this->assertEquals($usuarioParaAtualizar->getNome(), $usuarioAposAtualizacao->getNome());
        $this->assertEquals($usuarioParaAtualizar->getEmail(), $usuarioAposAtualizacao->getEmail());
        $this->assertEquals($usuarioParaAtualizar->getSenha(), $usuarioAposAtualizacao->getSenha());
        $this->assertEquals($usuarioParaAtualizar->getCriadoEm(), $usuarioAposAtualizacao->getCriadoEm());
        $this->assertEquals($usuarioParaAtualizar->getAtualizadoEm(), $usuarioAposAtualizacao->getAtualizadoEm());
        $this->assertNotNull($usuarioParaAtualizar->getAtualizadoEm());
        
        return $usuarioAposAtualizacao;
    }

    /**
     * @depends testaSeAtualizaUsuario
     * @test
     * @expectedException PDOException
     */
    public function testaSeLancaExcecaoSeEmailJaCadastrado($usuario)
    {
        $novoUsuario = new Usuario();
        $novoUsuario->setNome("João Alberto");
        $novoUsuario->setEmail($usuario->getEmail());
        $novoUsuario->setSenha("123456");
        
        $this->repository->persist($novoUsuario);
    }

    /**
     * @depends testaSeAtualizaUsuario
     * @test
     */
    public function testaSeBuscaUsuarioPorEmail($usuario)
    {
        $usuarioBuscadoPorEmail = $this->repository->findByEmail($usuario->getEmail());
        
        $this->assertEquals($usuario->getId(), $usuarioBuscadoPorEmail->getId());
        $this->assertEquals($usuario->getNome(), $usuarioBuscadoPorEmail->getNome());
        $this->assertEquals($usuario->getEmail(), $usuarioBuscadoPorEmail->getEmail());
        $this->assertEquals($usuario->getSenha(), $usuarioBuscadoPorEmail->getSenha());
        $this->assertEquals($usuario->getCriadoEm(), $usuarioBuscadoPorEmail->getCriadoEm());
        $this->assertEquals($usuario->getAtualizadoEm(), $usuarioBuscadoPorEmail->getAtualizadoEm());
        
        return $usuarioBuscadoPorEmail;
    }

    /**
     * @depends testaSeBuscaUsuarioPorEmail
     * @test
     */
    public function testaSeRemoveUsuario($usuario)
    {
        $this->repository->remove($usuario);
        $this->assertFalse($this->repository->get($usuario->getId()));
    }
}