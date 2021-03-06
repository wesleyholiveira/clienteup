<?php

namespace ClienteUp\Model\Entities;

use \Exception;
use \DateTime;
use Respect\Validation\Validator as v;
use Doctrine\Common\Collections\ArrayCollection;

/** 
	* @Entity(repositoryClass="ClienteUp\Model\Repositories\ClienteRepository")
	* @Table(name="cliente") 
**/
class Cliente {

	/** @Id @Column(type="integer") @GeneratedValue **/
	private $id_cliente;
	/** @Column(type="string", length=80, nullable=false) **/
	private $nomeCompleto_cliente;
	/** @Column(type="string", length=100, nullable=false) **/
	private $endereco_cliente;
	/** @Column(type="string", length=90, nullable=false) **/
	private $cidade_cliente;
	/** @Column(type="string", length=14, nullable=false) **/
	private $cpf_cliente;
	/** @Column(type="string", length=14, nullable=false) **/
	private $cep_cliente;
	/** @Column(type="string", length=14, nullable=false) **/
	private $telefone_cliente;
	/** @Column(type="date", nullable=false) **/
	private $dataNascimento_cliente;
	/** @Column(type="string", length=255, unique=true, nullable=false) **/
	private $email_cliente;
	/** @Column(type="string", length=25, unique=true, nullable=false) **/
	private $usuario_cliente;
	/** @Column(type="string", length=64, nullable=false) **/
	private $senha_cliente;

	/**
     * @ManyToMany(targetEntity="ClienteUp\Model\Entities\Cupom")
     * @JoinTable(name="cliente_cupom",
     *      joinColumns={@JoinColumn(name="id_cliente", referencedColumnName="id_cliente")},
     *      inverseJoinColumns={@JoinColumn(name="codigo_cupom", referencedColumnName="codigo_cupom")}
     *      )
 	**/
	private $cupom;

	/** 
		* @OneToMany(targetEntity="ClienteUp\Model\Entities\PosUp", mappedBy="id_posUp")
	**/
	private $posUp;

	public function __construct()
	{
		$this->cupom = new ArrayCollection();
	}

	public function addCupom(Cupom $cupom)
	{
		$this->cupom[] = $cupom;
	}

	public function getCupom()
	{
		return $this->cupom->toArray();
	}

	public function getId() : int
	{
		return $this->id_cliente;
	}

	public function setNomeCompleto(string $nomeCompleto) {
		
		if(!v::alpha()->length(10, 80)->validate(utf8_decode($nomeCompleto)))
			throw new Exception("O campo 'Nome Completo' está inválido. Deve conter entre 10 a 80 caracteres e possuir somente letras.");

		$this->nomeCompleto_cliente = mb_strtoupper($nomeCompleto, 'UTF-8');

	}

	public function getNomeCompleto() : string {
		return $this->nomeCompleto_cliente;
	}

	public function setEndereco(string $endereco) {

		if(!v::alpha()->length(8, 100)->validate(utf8_decode($endereco)))
			throw new Exception("O campo 'Endereço' está inválido.");

		$this->endereco_cliente = mb_strtoupper($endereco, 'UTF-8');
	}

	public function getEndereco() : string {
		return $this->endereco_cliente;
	}

	public function setCidade(string $cidade) {

		if(!v::alpha()->length(8, 90)->validate(utf8_decode($cidade)))
			throw new Exception("O campo 'Cidade' está inválido.");

		$this->cidade_cliente = mb_strtoupper($cidade, 'UTF-8');

	}

	public function getCidade() : string {
		return $this->cidade_cliente;
	}

	public function setCpf(string $cpf) {
		
		if(!v::cpf()->validate($cpf))
			throw new Exception("O campo 'CPF' está inválido.");
		
		$this->cpf_cliente = $cpf;
	}

	public function getCpf() : string {
		return $this->cpf_cliente;
	}

	public function setCep($cep) {

		if(!v::postalCode('BR')->validate($cep))
			throw new Exception("O campo 'CEP' está inválido.");

		$this->cep_cliente = mb_strtoupper($cep, 'UTF-8');

	}

	public function getCep() : string {
		return $this->cep_cliente;
	}

	public function setTelefone(string $telefone) {

		if(!v::phone()->validate($telefone))
			throw new Exception("O campo 'Telefone' está inválido.");

		$this->telefone_cliente = mb_strtoupper($telefone, 'UTF-8');
	}

	public function getTelefone() : string {
		return $this->telefone_cliente;
	}

	public function setDataNascimento(string $dataNascimento) {
		$this->dataNascimento_cliente = new DateTime($dataNascimento);
	}

	public function getDataNascimento() : DateTime {
		return $this->dataNascimento_cliente;
	}

	public function setEmail($email) {

		if(!v::email()->validate($email))
			throw new Exception("O campo 'E-mail' está inválido.");

		$this->email_cliente = $email;
	}

	public function getEmail() : string {
		return $this->email_cliente;
	}

	public function setUsuario(string $usuario) {

		if(!v::length(3, 25)->validate($usuario))
			throw new Exception("O campo 'Usuário' está inválido.");

		$this->usuario_cliente = $usuario;
	}

	public function getUsuario() : string {
		return $this->usuario_cliente;
	}

	public function setSenha(string $senha) {

		if(!v::length(64)->validate($senha))
			throw new Exception("O campo 'Senha' está inválido.");

		$this->senha_cliente = $senha;

	}

	public function getSenha() : string {
		return $this->senha_cliente;
	}

}