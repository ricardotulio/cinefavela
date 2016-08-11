<?php
namespace CineFavela\Repository;

use CineFavela\Model\Usuario;

interface UsuarioRepository
{

    public function get($id);

    public function persist(Usuario $usuario);

    public function remove(Usuario $usuario);
    
    public function findByEmail($email);
}