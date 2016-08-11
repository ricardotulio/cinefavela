<?php
namespace CineFavela\Controller;

use CineFavela\Repository\FilmeRepository;
use CineFavela\Validation\ValidatorInterface;
use Respect\Rest\Routable;
use CineFavela\Model\Filme;
use CineFavela\Repository\SessaoRepository;

class FilmeController__AopProxied extends AbstractController implements Routable
{

    private $validator;

    private $sessaoRepository;

    private $filmeRepository;

    public function __construct(ValidatorInterface $validator, SessaoRepository $sessaoRepository, FilmeRepository $filmeRepository)
    {
        $this->validator = $validator;
        $this->sessaoRepository = $sessaoRepository;
        $this->filmeRepository = $filmeRepository;
    }

    public function get($id = null)
    {
        $limit = isset($_GET['page']['size']) && $_GET['page']['size'] > 0 && $_GET['page']['size'] < 31 ? $_GET['page']['size'] : 30;
        $page = isset($_GET['page']['number']) && $_GET['page']['number'] > 0 ? $_GET['page']['number'] : 1;
        
        $offset = $page > 0 ? ($page - 1) * $limit : 0;
        
        $data = array();
        
        if ($id > 0) {
            $data = $this->filmeRepository->get($id);
        } else {
            $data = $this->filmeRepository->getList($limit, $offset);
        }
        
        return array(
            "data" => $data
        );
    }

    public function post()
    {
        $input = $this->request->input;
        $sessao = $this->sessaoRepository->get($this->request->headers["Authorization"]);
        
        if (! $sessao) {
            header("HTTP/1.1 401 Unauthorized");
            return array(
                "errors" => array(
                    array(
                        "code" => 401,
                        "message" => "Não autorizado."
                    )
                )
            );
        }
        
        if (! $this->validator->validate($input)) {
            header("HTTP/1.1 400 Bad Request");
            return array(
                "errors" => array(
                    array(
                        "code" => 400,
                        "message" => "Os dados informados para cadastro de filme são inválidos."
                    )
                )
            );
        }
        
        $filme = new Filme();
        $filme->setUsuario($sessao->getUsuario());
        $filme->setTitulo($input->titulo);
        $filme->setSinopse($input->sinopse);
        $filme->setLinkYoutube($input->linkYoutube);
        
        $this->filmeRepository->persist($filme);
        
        return array(
            "data" => $filme
        );
    }
}

include_once AOP_CACHE_DIR . '/_proxies/src/Controller/FilmeController.php';

