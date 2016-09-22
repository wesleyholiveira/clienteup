<?php

namespace ClienteUp\Model\Entities;

use \Exception;
use \DateTime;
use Respect\Validation\Validator as v;
use Doctrine\Common\Collections\ArrayCollection;

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
	private $recomendarLoja_posUp;

	/**
     * @ManyToOne(targetEntity="ClienteUp\Model\Entities\Cliente")
     * @JoinColumn(name="cliente", referencedColumnName="id_cliente")
     */
	private $cliente;
	
	public function setId(int $idPos)
	{
		$this->id_posUp = $idPos;
	}

	public function getId() : int
	{
		return $this->id_posUp;
	}

	public function setCliente(Cliente $cliente)
	{
		$this->cliente = $cliente;
	}

	public function getCliente() : Cliente
	{
		return $this->cliente;
	}

	public function setProdutoLoja(string $opcao)
	{
		if(!in_array($opcao, self::OPCOES))
			throw new Exception('\'Você encontrou o produto na Loja?\' - Opção inválida.');

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
			throw new Exception('\'Você lembra o nome do vendedor?\' - Opção inválida.');

		$this->nomeVendedor_posUp = $opcao;

	}

	public function getNomeVendedor() : string
	{
		return $this->nomeVendedor_posUp;
	}

	public function setPerguntarNome(string $opcao)
	{
		if(!in_array($opcao, self::OPCOES))
			throw new Exception('\'Você recomendaria esta loja?\' - Opção inválida.');

		$this->perguntarNome_posUp = $opcao;

	}

	public function getPerguntarNome() : string
	{
		return $this->perguntarNome_posUp;
	}

	public function setRecomendar(string $opcao)
	{
		if(!in_array($opcao, self::OPCOES))
			throw new Exception('\'Você recomendaria esta loja?\' - Opção inválida.');

		$this->recomendarLoja_posUp = $opcao;

	}

	public function getRecomendar() : string
	{
		return $this->recomendarLoja_posUp;
	}


}