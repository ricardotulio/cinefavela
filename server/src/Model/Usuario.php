<?php
namespace CineFavela\Model;

final class Usuario
{

    private $id;

    private $nome;

    private $email;

    private $senha;

    private $criadoEm;

    private $atualizadoEm;

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getNome()
    {
        return $this->nome;
    }

    public function setNome($nome)
    {
        $this->nome = $nome;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setEmail($email)
    {
        $this->email = $email;
    }

    public function getSenha()
    {
        return $this->senha;
    }

    public function setSenha($senha)
    {
        $this->senha = $senha;
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

    public function autentica($senha)
    {
        return $this->senha == $senha;
    }
}