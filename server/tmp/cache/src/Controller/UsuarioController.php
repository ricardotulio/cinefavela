<?php
namespace CineFavela\Controller;

use CineFavela\Model\Usuario;
use CineFavela\Repository\UsuarioRepository;
use CineFavela\Validation\ValidatorInterface;
use Respect\Rest\Routable;

class UsuarioController__AopProxied extends AbstractController implements Routable
{

    private $repository;

    private $validator;

    public function __construct(ValidatorInterface $validator, UsuarioRepository $repository)
    {
        $this->repository = $repository;
        $this->validator = $validator;
    }

    public function get($id = null)
    {
        return array(
            "data" => $this->repository->get($id)
        );
    }

    public function post()
    {
        $input = $this->request->input;
        
        if ($this->validator->validate($input)) {
            $usuario = new Usuario();
            $usuario->setNome($input->nome);
            $usuario->setEmail($input->email);
            $usuario->setSenha($input->senha);
            
            $this->repository->persist($usuario);
            
            return array(
                "data" => $usuario
            );
        } else {
            header("HTTP/1.1 400 Bad Request");
            return array(
                "errors" => array(
                    array(
                        "code" => 400,
                        "message" => "Os dados informados para cadastro de usuário são inválidos."
                    )
                )
            );
        }
    }

    public function put($id)
    {}

    public function delete($id)
    {}
}

include_once AOP_CACHE_DIR . '/_proxies/src/Controller/UsuarioController.php';

