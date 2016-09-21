<?php

namespace ClienteUp\Config;

final class BD {

	const DadosConexao = [
			'driver' => 'pdo_mysql',
		    'dbname' => 'clienteup',
		    'user' => 'root',
		    'password' => 'bolinha',
		    'host' => 'localhost',
		    'charset' => 'utf8'
		];
		
}