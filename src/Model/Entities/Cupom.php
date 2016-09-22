<?php

namespace ClienteUp\Model\Entities;

use \Exception;
use ClienteUp\Model\Entities\Empresa;
use Doctrine\Common\Collections\ArrayCollection;

/**
	* @Entity @Table(name="cupom")
**/

class Cupom {
	
	/** @Id @Column(type="string", length=13, nullable=false) **/
	private $codigo_cupom;
	/** 
		* @ManyToOne(targetEntity="ClienteUp\Model\Entities\Empresa", inversedBy="id_empresa")
		* @JoinColumn(name="empresa", referencedColumnName="id_empresa")
	 **/
	private $empresa;
	/** @Column(type="integer", nullable=false) **/
	private $pontos_cupom;
	/** @Column(type="string", length=100, nullable=false) **/
	private $titulo_cupom;
	/** @Column(type="string", length=255, nullable=false) **/
	private $imagem_cupom;

	/**
     * @ManyToMany(targetEntity="ClienteUp\Model\Entities\Cliente", mappedBy="cliente")
     **/
	private $cliente;

	public function __construct()
	{
		$this->cliente = new ArrayCollection();
	}

	public function setCodigo(string $codigo)
	{
		$this->codigo_cupom = $codigo;
	}

	public function getCodigo() : string
	{
		return $this->codigo_cupom;
	}

	public function setEmpresa(Empresa $empresa)
	{
		$this->empresa = $empresa;
	}

	public function getEmpresa() : Empresa
	{
		return $this->empresa;
	}

	public function setTitulo(string $titulo)
	{
		$this->titulo_cupom = $titulo;
	}

	public function getTitulo() : string
	{
		return $this->titulo_cupom;
	}

	public function setImagem(string $imagem)
	{
		$this->imagem_cupom = $imagem;
	}

	public function getImagem() : string
	{
		return $this->imagem_cupom;
	}

	public function setPontos(int $pontos)
	{
		$this->pontos_cupom = $pontos;
	}

	public function getPontos() : int
	{
		return $this->pontos_cupom;
	}

}