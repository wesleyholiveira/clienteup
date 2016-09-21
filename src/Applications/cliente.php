<?php

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use ClienteUp\Lib\JWT;
use Silex\Application;

$app->get('/cliente', function(Application $app) use ($em) {

	$todosClientes = $em->getRepository($app['clienteNamespace'])->findAll();
	return new Response($app['serializer']->serialize($todosClientes, 'json'), 200);

});

$app->get('/cliente/{id}', function(Application $app, int $id) use ($em) {

	$cliente = $em->getRepository($app['clienteNamespace'])->findById($id);
	return new Response($app['serializer']->serialize($cliente, 'json'), 200);

});

$app->post('/cliente', function(Application $app, Request $req) use ($em) {

	$nome = $req->get('nome');
	$cpf = $req->get('CPF');
	$endereco = $req->get('endereco');
	$cidade = $req->get('cidade');
	$cep = $req->get('CEP');
	$telefone = $req->get('telefone');
	$dataNascimento = $req->get('dataNascimento');
	$email = $req->get('email');
	$usuario = $req->get('usuario');
	$senha = $req->get('senha');

	try {
		$cliente = $app['cliente'];
		$cliente->setNomeCompleto($nome);
		$cliente->setEndereco($endereco);
		$cliente->setCidade($cidade);
		$cliente->setCpf($cpf);
		$cliente->setCep($cep);
		$cliente->setTelefone($telefone);
		$cliente->setDataNascimento($dataNascimento);
		$cliente->setEmail($email);
		$cliente->setUsuario($usuario);
		$cliente->setSenha($senha, $app['key']);
		$em->persist($cliente);
		$em->flush();
		return $app->json(['mensagem' => 'ok'], 200);
	} catch(UniqueConstraintViolationException $e) {
		return $app->json(['mensagem' => 'os campos CPF/Usuário/Email podem já estar cadastrados.'], 400);
	}

});

$app->post('/cliente/pesquisa', function(Application $app, Request $req) use ($em) {

	$token = JWT::getToken($req->headers->get('x-authorization'));
	
	$anuncio = $req->get('anuncio');
	$radio = $req->get('radio');
	$revista = $req->get('revista');
	$compras = $req->get('compras');
	$lojas = (array)json_decode($req->get('lojas'));
	$pagamento = $req->get('pagamento');
	$cliente = unserialize($token->getClaim('Cliente'));

	foreach($lojas as $key => $loja) {
		if($loja === true) {
			$lojas[$key] = $key;
		}
	}

	try {
		$pesquisa = $app['pesquisa'];
		$pesquisa->setCliente($cliente);
		$pesquisa->setAnuncio($anuncio);
		$pesquisa->setRadio($radio);
		$pesquisa->setRevista($revista);
		$pesquisa->setCompra($compras);
		$pesquisa->setOpcoes($lojas);
		$pesquisa->setPagamento($pagamento);
		$em->merge($pesquisa);
		$em->flush();
		return $app->json(['mensagem' => 'ok'], 200);
	} catch(UniqueConstraintViolationException $e) {
		return $app->json(['mensagem' => 'Você já realizou a pesquisa.'], 400);
	}

});

$app->post('/cliente/pos-venda', function(Application $app, Request $req) use ($em) {

	$token = JWT::getToken($req->headers->get('x-authorization'));

	$nomeVendedor = $req->get('nomeVendedor');
	$codigo = $req->get('codigo');
	$produtoLoja = $req->get('produtoLoja');
	$interesse = (array)json_decode($req->get('interesse'));
	$nota = $req->get('nota');
	$perguntar = $req->get('perguntarNome');
	$recomendar = $req->get('recomendar');
	$cliente = unserialize($token->getClaim('Cliente'));
	$cupom = $em->getRepository($app['cupomNamespace'])->findBy(array('codigo_cupom' => $codigo));
	$codigoUtilizado = $em->getRepository($app['posUpNamespace'])->findBy(array('cupom' => $codigo));

	if(count($cupom) < 1 || count($codigoUtilizado) > 0)
		throw new Exception('Código inválido.');

	foreach($interesse as $key => $opcao) {
		if($opcao === true) {
			$interesse[$key] = $key;
		}
	}

	$posUp = $app['posUp'];
	$posUp->setCupom($cupom[0]);
	$posUp->setCliente($cliente);
	$posUp->setProdutoLoja($produtoLoja);
	$posUp->setAtendimento($nota);
	$posUp->setOpcoes($interesse);
	$posUp->setNomeVendedor($nomeVendedor);
	$posUp->setPerguntarNome($perguntar);
	$posUp->setRecomendar($recomendar);
	$em->persist($posUp);
	$em->flush();
	return $app->json(['mensagem' => 'ok'], 200);

});