<?php

namespace ClienteUp\Model\Repositories;

use Doctrine\ORM\EntityRepository;

class ClienteRepository extends EntityRepository
{

	public function findById(int $id) {
		return $this->findBy(['id_cliente' => $id]);
	}

	public function findByEmail(string $email) {
		return $this->findBy(array('email_cliente' => $email));
	}

	public function verificaUsuario(string $usuario, string $senha) {
		return $this->findBy(['usuario_cliente' => $usuario, 'senha_cliente' => $senha])[0] ?? false;
	}

}
