<?php

$app['cliente'] = $app->factory(function() {
	return new ClienteUp\Model\Entities\Cliente;
});

$app['cupom'] = $app->factory(function() {
	return new ClienteUp\Model\Entities\Cupom;
});

$app['pesquisa'] = $app->factory(function() {
	return new ClienteUp\Model\Entities\Pesquisa;
});

$app['posUp'] = $app->factory(function() {
	return new ClienteUp\Model\Entities\PosUp;
});

$app['clienteNamespace'] = function() use ($app) {
	$clienteClasse = new ReflectionClass($app['cliente']);
	return $clienteClasse->getName();
};

$app['cupomNamespace'] = function() use ($app) {
	$cupomClasse = new ReflectionClass($app['cupom']);
	return $cupomClasse->getName();
};

$app['posUpNamespace'] = function() use ($app) {
	$posUp = new ReflectionClass($app['posUp']);
	return $posUp->getName();
};
