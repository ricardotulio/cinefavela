<?php
namespace CineFavela\Controller;

use Respect\Rest\Routable;
use CineFavela\Repository\UsuarioRepository;
use CineFavela\Model\Sessao;
use CineFavela\Repository\SessaoRepository;

class AutenticacaoController extends AbstractController implements Routable
{

    private $usuarioRepository;

    private $sessaoRepository;

    public function __construct(UsuarioRepository $usuarioRepository, SessaoRepository $sessaoRepository)
    {
        $this->usuarioRepository = $usuarioRepository;
        $this->sessaoRepository = $sessaoRepository;
    }

    public function post()
    {
        $input = $this->request->input;
        
        $usuario = $this->usuarioRepository->findByEmail($input->email);
        
        if (! $usuario || ! $usuario->autentica($input->senha)) {
            header("HTTP/1.1 400 Bad Request");
            return array(
                "errors" => array(
                    array(
                        "code" => 400,
                        "message" => "Dados para autenticação inválidos."
                    )
                )
            );
        }
        
        $sessao = new Sessao();
        $sessao->setUsuario($usuario);
        $this->sessaoRepository->persist($sessao);
        
        return array(
            "data" => array(
                "token_acesso" => $sessao->getId()         
            )
        );
    }
}