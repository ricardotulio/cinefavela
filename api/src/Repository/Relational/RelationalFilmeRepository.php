<?php
namespace CineFavela\Repository\Relational;

use CineFavela\Model\Filme;
use CineFavela\Repository\FilmeRepository;
use Respect\Relational\Mapper;
use Respect\Relational\Sql;

class RelationalFilmeRepository implements FilmeRepository
{

    private $mapper;

    public function __construct(Mapper $mapper)
    {
        $this->mapper = $mapper;
    }

    public function persist(Filme $filme)
    {
        $filme->setCriadoEm(date('Y-m-d H:i:s'));
        $this->mapper->filme->persist($filme);
        $this->mapper->flush();
    }

    public function get($id)
    {
        return $this->mapper->filme[$id]->usuario->fetch();
    }

    public function getList($limit, $offset)
    {
        return $this->mapper->filme->usuario->fetchAll(Sql::orderBy('filme.criadoEm')->desc()
            ->limit($limit)
            ->offset($offset));
    }
}