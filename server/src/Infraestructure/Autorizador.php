<?php
namespace CineFavela\Infraestructure;

use CineFavela\Repository\SessaoRepository;
use Respect\Rest\Request;

class Autorizador
{

    private $requerAutenticacao;

    private $sessaoRepository;

    public function __construct(SessaoRepository $sessaoRepository)
    {
        $this->sessaoRepository = $sessaoRepository;
    }

    public function autoriza(Request $request)
    {
        if (! isset($request->headers['Authorization']))
            return false;
        
        if (($sessao = $this->sessaoRepository->get($request->headers['Authorization'])) == false)
            return false;
        
        return true;
    }
}