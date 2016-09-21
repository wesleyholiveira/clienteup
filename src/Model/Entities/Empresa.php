<?php

namespace ClienteUp\Model\Entities;

/**
	* @Entity @Table(name="empresa")
**/

class Empresa {
	
	/** @Id @Column(type="integer") @GeneratedValue **/
	private $id_empresa;
	/** @Column(type="string", length=60, nullable=false) **/
	private $nome_empresa;
	/** @Column(columnDefinition="ENUM('Moda e Acessório', 'Eletrônicos e Tecnologia', 'Alimentos e Bebidas', 'Esporte e Lazer', 'Loja de Departamentos', 'Celulares e Smartphones', 'Beleza e Saúde', 'Livros, CDs e DVDs', 'Eletrodomésticos', 'Informática', 'Viagem e Turismo', 'Perfumes')", nullable=false) **/
	private $categoria_empresa;

	public function getId() : int
	{
		return $this->id_empresa;
	}

	public function setNome(string $nomeEmpresa)
	{
		$this->nome_empresa = $nomeEmpresa;
	}

	public function getNome() : string
	{
		return $this->nome_empresa;
	}

	public function setFoto(string $fotoEmpresa)
	{
		$this->foto_empresa = $fotoEmpresa;
	}

	public function setCategoria(string $categoria)
	{
		$this->categoria_empresa = $categoria;
	}

	public function getCategoria() : string
	{
		return $this->categoria_empresa;
	}

}