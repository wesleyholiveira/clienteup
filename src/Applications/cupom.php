<?php

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use ClienteUp\Lib\JWT;
use Silex\Application;

$app->get('/cupom', function(Application $app, Request $req) use ($em) {
	
	$todosCupons = $em->getRepository($app['cupomNamespace'])->findAll();
	return new Response($app['serializer']->serialize($todosCupons, 'json'), 200);

});