<?php

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use ClienteUp\Lib\JWT;
use Silex\Application;

$app->post('/cliente/login', function(Application $app, Request $r) use ($em) {

	$usuario = $r->get('usuario');
	$senha = $r->get('senha');

	$clienteRepo = $em->getRepository($app['clienteNamespace']);

	if(($cliente = $clienteRepo->verificaUsuario($usuario, $senha))) {

		$token = new JWT('http://localhost/clienteup', 'http://localhost/clienteup', ['Cliente' => serialize($cliente)]);

		return $app->json(['mensagem' => $token->getToken(), 'cliente' => $app['serializer']->serialize($cliente, 'json')], 200);
	}

	return $app->json(['mensagem' => 'Usuário e/ou senha inválidos.'], 401);

});

$app->post('/empresa/login', function(Application $app, Request $r) use ($em) {

	$usuario = $r->get('usuario');
	$senha = $r->get('senha');

	$clienteRepo = $em->getRepository($app['clienteNamespace']);

	if($clienteRepo->verificaUsuario($usuario, $senha)) {
		
		$signer = new Sha256();

		$token = (new Builder())->setIssuer('http://localhost/clienteup')
		                        ->setAudience('http://localhost/clienteup')
		                        ->setIssuedAt(time())
		                        ->setNotBefore(time() + 60)
		                        ->setExpiration(time() + 3600)
		                        ->set('Cliente', serialize($cliente))
		                        ->sign($signer, 'acessoEmpresaToken')
		                        ->getToken();

		return $app->json(['mensagem' => (string)$token], 200);
	}

	return $app->json(['mensagem' => 'Usuário e/ou senha inválidos.'], 401);

});