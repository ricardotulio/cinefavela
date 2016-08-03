<?php
namespace CineFavela\Model;

class Sessao
{

    const CHAVE_ENCRIPTACAO = ":xyd97E3";

    private $id;

    private $usuario_id;

    private $dataHoraInicio;

    private $dataHoraFim;

    public function __construct()
    {
        $this->id = sha1(date('YmdHis.u') . rand(0, 99999) . self::CHAVE_ENCRIPTACAO);
        $this->dataHoraInicio = date('Y-m-d H:i:s');
        $this->dataHoraFim = date('Y-m-d H:i:s');
    }

    public function getId()
    {
        return $this->id;
    }

    public function setUsuario(Usuario $usuario)
    {
        $this->usuario_id = $usuario->getId();
    }

    public function getDataHoraInicio()
    {
        return $this->dataHoraInicio;
    }

    public function setDataHoraInicio($dataHoraInicio)
    {
        $this->dataHoraInicio = $dataHoraInicio;
    }
    
    public function getDataHoraFim() {
        return $this->dataHoraFim;
    }

    public function setDataHoraFim($dataHoraFim)
    {
        $this->dataHoraFim = $dataHoraFim;
    }
}