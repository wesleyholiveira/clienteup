<?php

declare(strict_types=1);
setlocale(LC_ALL, 'pt-BR');

require_once 'vendor/autoload.php';
require_once 'bootstrap.php';

use Lcobucci\JWT\Parser;
use Lcobucci\JWT\Builder;
use Lcobucci\JWT\Signer\Hmac\Sha256;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Doctrine\DBAL\Exception\ConnectionException;
use Silex\Application;

$app = new Application();
$app->register(new Silex\Provider\SerializerServiceProvider());

$app['debug'] = true;
$app['key'] = 'a8c2860a1bfe6debd81c4e32354758fc';

require_once './src/Applications/register.php';
require_once './src/Applications/autenticacao.php';
require_once './src/Applications/cliente.php';
require_once './src/Applications/cupom.php';

$app->before(function(Request $request) use ($app) {

	$url = $request->getPathInfo();
	$url = explode('/', $url);
	$url[2] = $url[2] ?? false;

	if(($url[1] === 'cliente' || $url[1] === 'empresa') && ($url[2] !== 'login' && $request->getMethod() !== Request::METHOD_POST)) {
		try {
			$signer = new Sha256();

			$token = $request->headers->get('x-authorization');
			$token = (new Parser())->parse($token);

			if(!$token->verify($signer, 'acessoToken'))
				return $app->json(['mensagem' => 'Você não possui permissão para acessar este recurso.'], 403);

		} catch(Exception $e) {
			return $app->json(['mensagem' => 'Você não possui permissão para acessar este recurso.'], 403);
		}
	}else
		$request->request->set('senha', hash('sha256', $request->get('senha') . $app['key']));

});

$app->after(function(Request $request, Response $response) {
	$response->headers->set('Content-Type', 'application/json');
});

$app->error(function(ConnectionException $cn) use ($app) {
	return $app->json(['mensagem' => 'Erro de conexão, por favor contate o administrador.'], 500);
});

$app->error(function(NotFoundHttpException $nt) use ($app) {
	return $app->json(['mensagem' => ''], 404);
});

$app->error(function(Exception $e) use ($app) {
	return $app->json(['mensagem' => $e->getMessage()], 400);
});

$app->run();