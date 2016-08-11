<?php
namespace CineFavela\Repository;

use CineFavela\Model\Filme;

interface FilmeRepository
{

    public function persist(Filme $filme);

    public function get($id);
    
    public function getList($page, $limit);
}