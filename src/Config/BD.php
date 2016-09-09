<?php

namespace ClienteUp\Config;

final class BD {

	const DadosConexao = [
			'driver' => 'pdo_mysql',
		    'dbname' => 'clienteUp',
		    'user' => 'root',
		    'password' => '',
		    'host' => 'localhost',
		    'charset' => 'utf8'
		];
		
}