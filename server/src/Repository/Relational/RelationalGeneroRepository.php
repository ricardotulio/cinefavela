<?php
namespace CineFavela\Repository\Relational;

use CineFavela\Model\Genero;
use CineFavela\Repository\GeneroRepository;
use Respect\Relational\Mapper;

class RelationalGeneroRepository implements GeneroRepository
{
    private $mapper;

    public function __construct(Mapper $mapper)
    {
        $this->mapper = $mapper;
    }

    public function get($id)
    {
        return $this->mapper->genero[$id]->fetch();
    }
}