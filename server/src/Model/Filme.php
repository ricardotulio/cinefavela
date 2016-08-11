<?php
namespace CineFavela\Model;

class Filme
{

    private $id;

    private $usuario_id;

    private $titulo;

    private $sinopse;

    private $linkYoutube;

    private $criadoEm;

    private $atualizadoEm;

    public function getId()
    {
        return $this->id;
    }

    public function setUsuario(Usuario $usuario)
    {
        $this->usuario_id = $usuario;
    }

    public function getUsuario()
    {
        return $this->usuario_id;
    }

    public function getTitulo()
    {
        return $this->titulo;
    }

    public function setTitulo($titulo)
    {
        $this->titulo = $titulo;
    }

    public function getSinopse()
    {
        return $this->sinopse;
    }

    public function setSinopse($sinopse)
    {
        $this->sinopse = $sinopse;
    }

    public function getLinkYoutube()
    {
        return $this->linkYoutube;
    }

    public function setLinkYoutube($linkYoutube)
    {
        $this->linkYoutube = $linkYoutube;
    }

    public function getCriadoEm()
    {
        return $this->criadoEm;
    }

    public function setCriadoEm($criadoEm)
    {
        $this->criadoEm = $criadoEm;
    }

    public function getAtualizadoEm()
    {
        return $this->atualizadoEm;
    }

    public function setAtualizadoEm($atualizadoEm)
    {
        $this->atualizadoEm = $atualizadoEm;
    }
}