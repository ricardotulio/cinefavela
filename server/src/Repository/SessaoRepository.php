<?php
namespace CineFavela\Repository;

use CineFavela\Model\Sessao;

interface SessaoRepository
{

    public function persist(Sessao $sessao);

    public function get($id);
}