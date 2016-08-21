<?php
namespace CineFavela\Model;

class Genero
{
	private $id;

	private $titulo;

	public function getId() {
		return $this->id;
	}

	public function setId($id) {
		$this->id = $id;
	}

	public function getTitulo() {
		return $this->titulo;
	}

	public function setTitulo($titulo) {
		$this->titulo = $titulo;
	}

}