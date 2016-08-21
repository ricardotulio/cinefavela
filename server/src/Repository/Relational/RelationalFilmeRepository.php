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

        foreach($filme->getGeneros() as $chave => $valor) {
            if($valor == true) {
                $filmeGenero = new \stdClass;
                $filmeGenero->filme_id = $filme->getId();
                $filmeGenero->genero_id = $chave;

                $this->mapper->filme_genero->persist($filmeGenero);
                $this->mapper->flush();
            }
        }
    }

    public function get($id)
    {
        $filme = $this->mapper->filme[$id]->usuario->fetch();
        
        $generos = array();

        foreach($this->mapper->filme_genero(array('filme_id' => $filme->getId()))->genero->fetchAll() as $genero) {
            $generos[] = $genero->genero_id->getId();
        }

        $filme->setGeneros($generos); 

        return $filme;
    }

    public function getList($limit, $offset)
    {
        $filmes = $this->mapper->filme->usuario->fetchAll(Sql::orderBy('filme.criadoEm')->desc()
            ->limit($limit)
            ->offset($offset));

        foreach($filmes as $filme) {
            $generos = array();

            foreach($this->mapper->filme_genero(array('filme_id' => $filme->getId()))->genero->fetchAll() as $genero) {
                $generos[] = $genero->genero_id->getId();
            }

            $filme->setGeneros($generos);            
        }

        return $filmes;
    }
}