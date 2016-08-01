<?php
namespace CineFavela\Controller;

use CineFavela\Model\Usuario;
use CineFavela\Repository\UsuarioRepository;
use CineFavela\Validation\ValidatorInterface;
use Respect\Rest\Routable;

final class UsuarioController extends AbstractController implements Routable
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
        return $this->repository->get($id);
    }

    public function post()
    {
        if ($this->validator->validate($this->input)) {
            $usuario = new Usuario();
            $usuario->setNome($this->input->nome);
            $usuario->setEmail($this->input->email);
            $usuario->setSenha($this->input->senha);
            
            $this->repository->persist($usuario);
            
            return $usuario;
        }
    }

    public function put($id)
    {}

    public function delete($id)
    {}
}