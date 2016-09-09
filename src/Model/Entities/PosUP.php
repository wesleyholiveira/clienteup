<?php

namespace ClienteUp\Model\Entities;

use \Exception;
use \DateTime;
use Respect\Validation\Validator as v;

/** 
	* @Entity @Table(name="posup") 
**/

class PosUP {

	const OPCOES = [
		'Sim',
		'Não'
	];

	const INTERESSE = [
		'Já sou cliente',
		'Indicação',
		'Propaganda',
		'Preço',
		'Promoção'
	];

	/** @Id @Column(type="integer") @GeneratedValue **/
	private $id_posUp;
	/**
		* @ManyToOne(targetEntity="ClienteUp\Model\Entities\Cupom")
		* @JoinColumn(name="cupom", referencedColumnName="codigo_cupom", nullable=false)
	*/
	private $cupom;
	/** @Column(columnDefinition="ENUM('Sim', 'Não') NOT NULL") **/
	private $produtoLoja_posUp;
	/** @Column(type="integer", length=2, nullable=false) **/
	private $atendimento_posUp;
	/** @Column(type="string", nullable=false) */
	private $opcoes_posUp;
	/** @Column(columnDefinition="ENUM('Sim', 'Não') NOT NULL") **/
	private $nomeVendedor_posUp;
	/** @Column(columnDefinition="ENUM('Sim', 'Não') NOT NULL") **/
	private $perguntarNome_posUp;
	/** @Column(columnDefinition="ENUM('Sim', 'Não') NOT NULL") **/
	private $produtoLoja_posUp;
	/** @Column(columnDefinition="ENUM('Sim', 'Não') NOT NULL") **/
	private $recomendarLoja_posUp;

	public function setId(int $idPos)
	{
		$this->id_posUp = $idPos;
	}

	public function getId() : int
	{
		return $this->id_posUp;
	}

	public function setCupom(Cupom $cupom)
	{
		$this->cupom = $cupom;
	}

	public function getCupom() : Cupom
	{
		return $this->cupom;
	}

	public function setProdutoLoja(string $opcao)
	{
		if(!in_array($opcao, self::OPCOES))
			throw new Exception('Opção inválida.');

		$this->produtoLoja_posUp = $opcao;

	}

	public function getProdutoLoja() : string
	{
		return $this->produtoLoja_posUp;
	}

	public function setAtendimento(int $nota)
	{
		$this->atendimento_posUp = $nota;
	}

	public function getAtendimento() : int
	{
		return $this->atendimento_posUp;
	}


	public function setOpcoes(array $opcoes)
	{
		$opcoes = implode(', ', $opcoes);
		$this->opcoes_posUp = $opcoes;
	}

	public function getOpcoes() : string
	{
		return $this->opcoes_posUp;
	}

	public function setNomeVendedor(string $opcao)
	{
		if(!in_array($opcao, self::OPCOES))
			throw new Exception('Opção inválida.');

		$this->nomeVendedor_posUp = $opcao;

	}

	public function getNomeVendedor() : string
	{
		return $this->nomeVendedor_posUp;
	}

	public function setPerguntarNome(string $opcao)
	{
		if(!in_array($opcao, self::OPCOES))
			throw new Exception('Opção inválida.');

		$this->perguntarNome_posUp = $opcao;

	}

	public function getPerguntarNome() : string
	{
		return $this->perguntarNome_posUp;
	}


}