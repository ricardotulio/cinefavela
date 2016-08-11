<?php
namespace CineFavela\Infraestructure;

use PHPUnit\Framework\TestCase;

class AutorizadorTest extends TestCase
{

    /**
     * @test
     */
    public function testaSeNegaAcessoSeUsuarioNaoInformarTokenAcesso()
    {        
        $repository = $this->getMockBuilder("\CineFavela\Repository\SessaoRepository")->getMock();
        $repository->method("get")
            ->withAnyParameters()
            ->willReturn(false);
        
        $request = $this->getMockBuilder("\Respect\Rest\Request")->getMock();
        
        $autorizador = new Autorizador($repository);
        $this->assertFalse($autorizador->autoriza($request));
    }

    /**
     * @test
     */
    public function testaSeNegaAcessoSeTokenInformadoForInvalido()
    {       
        $repository = $this->getMockBuilder("\CineFavela\Repository\SessaoRepository")->getMock();
        $repository->method("get")
            ->withAnyParameters()
            ->willReturn(false);
        
        $request = $this->getMockBuilder("\Respect\Rest\Request")->getMock();
        $request->headers = array(
            "Authorization" => "asd0as9da0s9das0d9as"
        );
        
        $autorizador = new Autorizador($repository);
        $this->assertFalse($autorizador->autoriza($request));
    }

    /**
     * @test
     */
    public function testaSeAutorizaAcesso()
    {
        $sessao = $this->getMockBuilder("\CineFavela\Model\Sessao")->getMock();
        $sessao->method("getId")->willReturn("8a09d8as09a809s8A09S809A890");
        
        $repository = $this->getMockBuilder("\CineFavela\Repository\SessaoRepository")->getMock();
        $repository->method("get")
            ->with("8a09d8as09a809s8A09S809A890")
            ->willReturn($sessao);
        
        $request = $this->getMockBuilder("\Respect\Rest\Request")->getMock();
        $request->headers = array(
            "Authorization" => "8a09d8as09a809s8A09S809A890"
        );
        
        $autorizador = new Autorizador($repository);
        $this->assertTrue($autorizador->autoriza($request));
    }
}