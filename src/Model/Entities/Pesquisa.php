<?php

namespace ClienteUp\Model\Entities;

use \Exception;

/**
	* @Entity
	* @Table(name="pesquisa")
*/
class Pesquisa {

	const ANUNCIOS = [
		'Facebook',
		'Internet',
		'Rádio',
		'Panfleto',
		'Outdoor',
		'TV',
		'Carro de som',
		'Outros'
	];

	const OPCOES_BOOLEANAS = [
		'Sim',
		'Não'
	];

	const COMPRAS = [
		'Comércio',
		'Shopping'
	];

	const PAGAMENTOS = [
		'À vista',
		'Cartão de crédito',
		'Crediário'
	];

	const OPCOES = [
		'Variedades',
		'Marcas',
		'Preços atrativos',
		'Promoções'
	];

	/**
		* @OneToOne(targetEntity="ClienteUp\Model\Entities\Cliente")
		* @JoinColumn(name="id_cliente", referencedColumnName="id_cliente", nullable=false)
	*/
	protected $id_cliente;
	/** @Id @Column(type="integer") @GeneratedValue	*/
	protected $id_pesquisa;
	/** @Column(columnDefinition="ENUM('Facebook', 'Internet', 'Rádio', 'Panfleto', 'Outdoor', 'TV', 'Carro de som', 'Outros') NOT NULL") */
	protected $anuncio_pesquisa;
	/** @Column(columnDefinition="ENUM('Sim', 'Não') NOT NULL") */
	protected $radio_pesquisa;
	/** @Column(columnDefinition="ENUM('Sim', 'Não') NOT NULL") */
	protected $revista_pesquisa;
	/** @Column(columnDefinition="ENUM('Comércio', 'Shopping') NOT NULL") */
	protected $compra_pesquisa;
	/** @Column(type="string", nullable=false) */
	protected $opcoes_pesquisa;
	/** @Column(columnDefinition="ENUM('À vista', 'Cartão de crédito', 'Crediário') NOT NULL") */
	protected $pagamento_pesquisa;

	public function getId() : int
	{
		return $this->id_pesquisa;
	}

	public function setCliente(Cliente $cliente)
	{
		$this->id_cliente = $cliente;
	}

	public function getCliente() : Cliente
	{
		return $this->id_cliente;
	}

	public function setAnuncio(string $anuncio)
	{
		if(!in_array($anuncio, self::ANUNCIOS))
			throw new Exception('Anúncio inválido.');

		$this->anuncio_pesquisa = $anuncio;
	}

	public function getAnuncio() : string
	{
		return $this->anuncio_pesquisa;
	}

	public function setRadio(string $radio)
	{
		if(!in_array($radio, self::OPCOES_BOOLEANAS))
			throw new Exception('Opção de rádio inválida.');

		return $this->radio_pesquisa = $radio;
	}

	public function getRadio() : string
	{
		return $this->radio_pesquisa;
	}

	public function setRevista(string $revista)
	{
		if(!in_array($revista, self::OPCOES_BOOLEANAS))
			throw new Exception('Opção de revista inválida.');

		$this->revista_pesquisa = $revista;
	}

	public function getRevista() : string
	{
		return $this->revista_pesquisa;
	}

	public function setCompra(string $compra)
	{
		if(!in_array($compra, self::COMPRAS))
			throw new Exception('Opção de compra inválida.');

		return $this->compra_pesquisa = $compra;

	}

	public function getCompra() : string
	{
		return $this->compra_pesquisa;
	}

	public function setOpcoes(array $opcoes)
	{
		$opcoes = implode(', ', $opcoes);
		$this->opcoes_pesquisa = $opcoes;
	}

	public function getOpcoes() : array
	{
		return $this->opcoes_pesquisa;
	}

	public function setPagamento(string $pagamento)
	{
		if(!in_array($pagamento, self::PAGAMENTOS))
			throw new Exception('Opção de pagamento inválida.');

		$this->pagamento_pesquisa = $pagamento;
	}

	public function getPagamento()
	{
		return $this->pagamento_pesquisa;
	}

}