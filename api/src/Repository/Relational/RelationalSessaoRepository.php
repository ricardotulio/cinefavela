<?php
namespace CineFavela\Repository\Relational;

use CineFavela\Model\Sessao;
use CineFavela\Repository\SessaoRepository;
use Respect\Relational\Mapper;

class RelationalSessaoRepository implements SessaoRepository
{

    private $mapper;

    public function __construct(Mapper $mapper)
    {
        $this->mapper = $mapper;
    }

    public function persist(Sessao $sessao)
    {
        $this->mapper->sessao->persist($sessao);
        $this->mapper->flush();
    }

    public function get($id)
    {
        return $this->mapper->sessao[$id]->usuario->fetch();
    }
}