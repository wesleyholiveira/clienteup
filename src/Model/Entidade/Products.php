<?php

namespace ClienteUp\Model\Entidade;

use Doctrine\ORM\EntityRepository;

/** @Entity **/
class Products extends EntityRepository {
	
	/** @Id
		@Column(type="integer")
		@GeneratedValue
	**/
	protected $id;
	/** @Column(type="string") **/
	protected $name;

	public function getId() {
		return $this->id;
	}
	public function setName($name) {
		$this->name =  $name;
	}
	public function getName() {
		return $this->name;
	}

}