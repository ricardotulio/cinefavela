<?php
namespace CineFavela\Repository\Relational;

use CineFavela\Repository\UsuarioRepository;
use CineFavela\Model\Usuario;
use Respect\Relational\Mapper;

final class RelationalUsuarioRepository implements UsuarioRepository
{

    private $mapper;

    public function __construct(Mapper $mapper)
    {
        $this->mapper = $mapper;
    }

    public function get($id)
    {
        return $this->mapper->usuario[$id]->fetch();
    }

    public function persist(Usuario $usuario)
    {
        $dataAtual = date('Y-m-d H:i:s');
        
        if($usuario->getId() == null) {
            $usuario->setCriadoEm($dataAtual);
        } else {
            $usuario->setAtualizadoEm($dataAtual);
        }
        
        $this->mapper->usuario->persist($usuario);
        $this->mapper->flush();
    }

    public function remove(Usuario $usuario)
    {
        $this->mapper->usuario->remove($usuario);
        $this->mapper->flush();
    }
    
    public function findByEmail($email) {
        return $this->mapper->usuario(array("email" => $email))->fetch();
    }
}